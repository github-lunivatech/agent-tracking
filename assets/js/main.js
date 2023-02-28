// Demo Theme Options

$(document).ready(() => {

    $('.btn-open-options').click(function () {
        $('.ui-theme-settings').toggleClass('settings-open');
    });

    $('.close-sidebar-btn').click(function () {

        var classToSwitch = $(this).attr('data-class');
        var containerElement = '.app-container';
        $(containerElement).toggleClass(classToSwitch);

        var closeBtn = $(this);

        if (closeBtn.hasClass('is-active')) {
            closeBtn.removeClass('is-active');

        } else {
            closeBtn.addClass('is-active');
        }
    });

    $('.switch-container-class').on('click', function () {

        var classToSwitch = $(this).attr('data-class');
        var containerElement = '.app-container';
        $(containerElement).toggleClass(classToSwitch);

        $(this).parent().find('.switch-container-class').removeClass('active');
        $(this).addClass('active');
    });

    $('.switch-theme-class').on('click', function () {

        var classToSwitch = $(this).attr('data-class');
        var containerElement = '.app-container';

        if (classToSwitch == 'body-tabs-line') {
            $(containerElement).removeClass('body-tabs-shadow');
            $(containerElement).addClass(classToSwitch);
        }

        if (classToSwitch == 'body-tabs-shadow') {
            $(containerElement).removeClass('body-tabs-line');
            $(containerElement).addClass(classToSwitch);
        }

        $(this).parent().find('.switch-theme-class').removeClass('active');
        $(this).addClass('active');

    });

    $('.switch-header-cs-class').on('click', function () {
        var classToSwitch = $(this).attr('data-class');
        var containerElement = '.app-header';

        $('.switch-header-cs-class').removeClass('active');
        $(this).addClass('active');

        $(containerElement).attr('class', 'app-header');
        $(containerElement).addClass('header-shadow ' + classToSwitch);
    });

    $('.switch-sidebar-cs-class').on('click', function () {
        var classToSwitch = $(this).attr('data-class');
        var containerElement = '.app-sidebar';

        $('.switch-sidebar-cs-class').removeClass('active');
        $(this).addClass('active');

        $(containerElement).attr('class', 'app-sidebar');
        $(containerElement).addClass('sidebar-shadow ' + classToSwitch);
    });

    setTimeout(function () {

        if ($(".scrollbar-container")[0]) {

            $('.scrollbar-container').each(function () {
                const ps = new PerfectScrollbar($(this)[0], {
                    wheelSpeed: 2,
                    wheelPropagation: false,
                    minScrollbarLength: 20
                });
            });

        }
        const ps = new PerfectScrollbar('.scrollbar-sidebar', {
            wheelSpeed: 2,
            wheelPropagation: false,
            minScrollbarLength: 20
        });

    }, 1000);

    setTimeout(function () {
        $(".vertical-nav-menu").metisMenu();
    }, 100);

    // Search wrapper trigger

    $('.search-icon').click(function () {
        $(this).parent().parent().addClass('active');
    });

    $('.search-wrapper .close').click(function () {
        $(this).parent().removeClass('active');
    });

    // Stop Bootstrap 4 Dropdown for closing on click inside

    $('.dropdown-menu').on('click', function (event) {
        var events = $._data(document, 'events') || {};
        events = events.click || [];
        for (var i = 0; i < events.length; i++) {
            if (events[i].selector) {

                if ($(event.target).is(events[i].selector)) {
                    events[i].handler.call(event.target, event);
                }

                $(event.target).parents(events[i].selector).each(function () {
                    events[i].handler.call(this, event);
                });
            }
        }
        event.stopPropagation(); //Always stop propagation
    });

    $(function () {
        $('[data-toggle="popover"]').popover();
    });

    // BS4 Tooltips

    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });

    $('.mobile-toggle-nav').click(function () {
        $(this).toggleClass('is-active');
        $('.app-container').toggleClass('sidebar-mobile-open');
    });

    $('.mobile-toggle-header-nav').click(function () {
        $(this).toggleClass('active');
        $('.app-header__content').toggleClass('header-mobile-open');
    });

    // Responsive

    var resizeClass = function () {
        var win = document.body.clientWidth;
        if (win < 1250) {
            $('.app-container').addClass('closed-sidebar-mobile closed-sidebar');
        } else {
            $('.app-container').removeClass('closed-sidebar-mobile closed-sidebar');
        }
    };


    $(window).on('resize', function () {
        resizeClass();
    });

    resizeClass();


    //alert fades in main for all
    $(".app-main__inner .alert").fadeTo(2000, 500).slideUp(500, function () {
        $(".app-main__inner .alert").slideUp(500);
    });
    //alert fades in main for all


    //here notifications
    $.ajax({
        url: BASE_URL + 'leave/ajax_get_noti',
        data: '',
        method: 'post',
        dataType: 'json'
    }).done(function (res) {
        if (res != '' && res != null && res.length != 0) {
            $('#all_notif .ion-android-notifications').addClass('icon-anim-pulse');
            $('.dropper').removeClass('dropper');
            if (!$('#all_notif span').hasClass('badge-dot')) {
                $('#all_notif span').append('<span class="badge badge-dot badge-dot-sm badge-danger show_num"></span>');
            }
            if ($('.menu-header-subtitle').text() == '') {
                $('.menu-header-subtitle').html('You have <span class="not_num">' + res.length + '</span> unchecked notifications');
            } else {
                if ($('.not_num').text() != '' && $('.not_num').text() != 'undefined') {
                    $('.not_num').text(Number($('.not_num').text()) + res.length);
                    $('.show_num').text(Number($('.not_num').text()));
                } else {
                    $('.not_num').text(res.length);
                    $('.show_num').text(res.length);
                }
            }
            res.forEach(element => {
                let notData = element[14] + ' has applied for leave. Visit Leave managment for more details'
                $('.drophere').append('<a href="' + BASE_URL + 'leave/leaveManage#pele" class="dropdown-item list-group-item">' + notData + '</a>')
            });
        } else {
            $('.dropdown-menu-xl .scroll-area-sm').css('height', 'unset');
        }
    }).fail(function (xhr) {
        console.log('server error');
    })

    $('#all_notif').on('click', function (e) {
        $('#all_notif .ion-android-notifications').removeClass('icon-anim-pulse');
        $('#all_notif .badge.badge-dot.badge-dot-sm.badge-danger').remove();
    })
    //here notitiaiton

    setTimeout(() => {
        let ele = document.getElementsByClassName('mm-collapse')

        for (i = 0; i < ele.length; i++) {
            if (ele[i].childElementCount == 0) {
                ele[i].parentElement.remove()
            }
        }
    }, 100)


});