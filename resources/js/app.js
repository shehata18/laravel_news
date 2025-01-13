import './bootstrap';
window.Echo.private('User.' + id)
    .notification((event)=>{
        console.log('Notification received:', event);
        $('#push-notification').prepend(`<div class="dropdown-item d-flex justify-content-between align-items-center">
                                        <span>Post Comment: ${event.post_title.substring(0,9) + '...' }</span>
                                        <a href="${event.link}?notify=${event.id}"><i class="fa fa-eye"></i></a>
                                    </div>
        `);
                                let count = Number($('#count-notification').text());
                                count++;
                                $('#count-notification').text(count);
    });
