(function ($) {

    let vname = $('#visit_name'),
        vaddress = $('#visit_address');

    $('#visit_mobno').on('input', async function(e){
        let mobno = this.value.length
        if(mobno == 10){
            $('#addApp').attr('disabled', true)
            const vd = await visitorDetails(mobno);
            // console.log(vd);
            // console.log(vname.val());
            // console.log(vaddress.val());
            // $("input[name=visit_gender][value='Female']").prop("checked",true);
            $('#addApp').removeAttr('disabled')
        }
    })

    function visitorDetails(mobno='') {
        return new Promise(resolve => {
            $.ajax({
                url: BASE_URL+'',
                data: '',
                method: 'post',
                dataType: 'json'
            }).done(function(res){
                resolve(res);
            }).fail(function(res){
                console.log('server error');
                $('#addApp').removeAttr('disabled')
            })
        })
    }

})(jQuery)