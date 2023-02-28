(function ($) {
    $('body').on('submit', 'form', function (e) {
        $(this).find(':input[type=submit]').prop('disabled', true);
    })
})(jQuery)