(function ($) {
    const a = new URL(window.location.href);

    if(a.searchParams.get('a') == 'true'){
        let u = a.searchParams.get('q');
        updateWithUser(u)
    }

    function updateWithUser(u = '') {
        $.ajax({
            url: BASE_URL + 'visitor/updateSeenFlag',
            data: {u: u},
            method: 'post',
            dataType: 'json'
        }).done(function (res) {
            if(res.fid > 0){
                $('input[name="is_seenby"][value=1]').prop('checked', 'checked')
            }
        }).fail(function (xhr) {
            console.log('server error');
        })
    }

})(jQuery)