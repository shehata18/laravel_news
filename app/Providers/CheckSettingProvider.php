<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\RelatedNewsSite;
use App\Models\Setting;
use Illuminate\Support\ServiceProvider;

class CheckSettingProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $getSetting = Setting::firstOr(function () {
            return Setting::create([
                'site_name' => 'news',
                'logo' => '/img/logo.png',
                'favicon' => 'default',
                'email' => 'news@gmail.com',
                'facebook' => 'https://www.facebook.com/share/sMin7NPooHAWAU8K/?mibextid=qi2Omg',
                'twitter' => 'https://www.twitter.com/',
                'instagram' => 'https://www.instagram.com/',
                'youtube' => 'https://www.youtube.com/',
                'linkedin' => 'https://www.linkedin.com/',
                'phone' => '+201067180305',
                'country' => 'Egypt',
                'city' => 'Faraskour',
                'street' => '14 Canal street',
                'small_desc'=>'Lorem ipsum dolor sit amet, consectetur adipiscing elit,
                 sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.'
            ]);
        });


        $getSetting->whatsapp = "https://wa.me/".$getSetting->phone;
        view()->share([
            'getSetting'=> $getSetting,
        ]);
    }
}
