jQuery(function () {
    var dashboard_e = document.getElementById('app-main');
    var loaderElem = ecrm.loaderElement;

    // dashboard_e.prepend(loaderElem);
    // loaderElem.remove();

    // $('.rightCheck').on('click', function(e){
    //     console.log(this.checked);
    // })

    $('[key]').on('change', function () {
        var key = $(this).attr('key');
        $($('[name="checked[' + key + ']"]')).val($(this).is(':checked') ? '1' : '0');
    });

    function updateRoles() {
        return new Promise(resolve => {
            $.ajax({
                url: BASE_URL + '',
                method: 'post',
                data: '',
                dataType: 'json'
            }).done(function (res) {
                resolve(res)
            }).fail(function (res) {
                resolve(false)
            })
        })
    }

    $('#rolerAS').on('submit', (e) => {
        $('.updater').attr('disabled', true)
        dashboard_e.prepend(loaderElem);
    })
})