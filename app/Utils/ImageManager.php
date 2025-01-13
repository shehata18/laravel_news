<?php

namespace App\Utils;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ImageManager
{
    public static function uploadImages($request, $post= null, $user= null)
    {
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $file = self::generateImageName($image);
                $path = self::storeImageLocal($image,'posts',$file);
//                $path = $image->storeAs('uploads/posts', $file, [ 'disk' => 'uploads' ]);

                $post->images()->create([
                    'path' => $path,
                ]);
                // same as
//                Image::create([
//                    'post_id' => $post->id,
//                    'path' => $path,
//                ]);
            }
        }

        // Upload Single Image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            // Delete Image form Local
            self::deleteImageFromLocal($user->image);

            // store New Image in local
            $file = self::generateImageName($image);
            $path = self::storeImageLocal($image,'users',$file);
//            $path = $image->storeAs('uploads/users', $file, [ 'disk' => 'uploads' ]);

            // Update Image in database
            $user->update([ 'image' => $path ]);

        }
    }

    public static function deleteImages($post)
    {
        if ($post->images()->count() > 0) {
            foreach ($post->images as $image) {
                self::deleteImageFromLocal($image->path);
                $image->delete();
            }
        }
    }

    private static function generateImageName($image)
    {
        $file = Str::uuid() . '-' . time() . '.' . $image->getClientOriginalExtension();
        return $file;
    }

    public static function storeImageLocal($image, $path, $file_name)
    {
        $path = $image->storeAs('uploads/'.$path, $file_name, [ 'disk' => 'uploads' ]);
        return $path;

    }

    public static function deleteImageFromLocal($image_path): void{
        if (File::exists(public_path($image_path))) {
            File::delete(public_path($image_path));
        }
    }

}
