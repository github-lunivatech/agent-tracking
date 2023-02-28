//new message here
const a = new URL(window.location.href);
var web_so = 'ws://' + a.hostname + ':8282';
var conn = new WebSocket(web_so);
var client = {
    user_id: 99,
    recipient_id: null,
    type: 'socket',
    token: null,
    message: null,
    role: 'appointment'
};

conn.onopen = function (e) {
    conn.send(JSON.stringify(client));
};

conn.onmessage = function (e) {
    //here on added
    setTimeout(function(){
        getAppointmentNotification()
    }, 2000)
};

conn.onerror = function (e) {
    console.log('Live Notification Server is not responding. Please restart the server');
}

getAppointmentNotification()

function getAppointmentNotification() {
    $.ajax({
        url: BASE_URL + 'liveupdate/ajax_livenotif',
        method: 'post',
        dataType: 'json',
        data: ''
    }).done(function (res) {
        if(res['appointment'] != '' && res['appointment'] != null && res['appointment'].length != 0 && res['appointment'].length != undefined){
            $('#all_notif .ion-android-notifications').addClass('icon-anim-pulse');
            $('.dropper').removeClass('dropper');
            if(!$('#all_notif span').hasClass('badge-dot')){
                $('#all_notif span').append('<span class="badge badge-dot badge-dot-sm badge-danger show_num">'+res['appointment'].length+'</span>');
            }
            if($('.menu-header-subtitle').text() == ''){
                $('.menu-header-subtitle').html('You have <span class="not_num">'+res['appointment'].length+'</span> unchecked notifications');
            }else{
                if($('.not_num').text() != '' && $('.not_num').text() != 'undefined'){
                    $('.not_num').text(Number($('.not_num').text()) + res['appointment'].length);
                    $('.show_num').text(Number( $('.not_num').text()) );
                }else{
                    $('.not_num').text(res['appointment'].length);
                    $('.show_num').text(res['appointment'].length);
                }
            }
            res['appointment'].forEach(element => {
                $('.drophere').append('<a href="'+BASE_URL+'visitor/viewFromApp?q='+element.urlPram+'&a=true" class="dropdown-item list-group-item app_notifi">'+element.name+' has applied for an Appointment</a>') 
            });
        }else{
            $('.dropdown-menu-xl .scroll-area-sm').css('height','unset');
        }
        if(res['notice'] != '' && res['notice'] != null && res['notice'].length != 0 && res['notice'].length != undefined){
            $('#all_notif .ion-android-notifications').addClass('icon-anim-pulse');
            $('.dropper').removeClass('dropper');
            if(!$('#all_notif span').hasClass('badge-dot')){
                $('#all_notif span').append('<span class="badge badge-dot badge-dot-sm badge-danger show_num">'+res['notice'].length+'</span>');
            }
            if($('.menu-header-subtitle').text() == ''){
                $('.menu-header-subtitle').html('You have <span class="not_num">'+res['notice'].length+'</span> unchecked notifications');
            }else{
                if($('.not_num').text() != '' && $('.not_num').text() != 'undefined'){
                    $('.not_num').text(Number($('.not_num').text()) + res['notice'].length);
                    $('.show_num').text(Number( $('.not_num').text()) );
                }else{
                    $('.not_num').text(res['notice'].length);
                    $('.show_num').text(res['notice'].length);
                }
            }

            res['notice'].forEach(element => {
                $('.drophere').append('<h6>'+element.NoticeTitle+'</h6> <p>'+element.NoticeDescription+'</p>');
            });
        }
    }).fail(function (xhr) {
        console.log('server error');
    })
}