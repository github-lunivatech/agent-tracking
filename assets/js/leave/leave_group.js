(function ($) {

    let today = new Date()
    initEduDate()

    $('body').on('click', '.edit_lg', function(e){
        initEduDate()
        let ef = this.dataset.e;
        let res = JSON.parse(this.dataset.json);
        $('#leave_group').val(res[2]);
        $('#start_period').val(res[4].split('T')[0]);
        $('#end_period').val(res[5].split('T')[0]);
        if(res[6] == true){
            $("input[name=isactive][value='1']").prop("checked", true);
        }else{
            $("input[name=isactive][value='0']").prop("checked", true);
        }
        $('#eeff').val(ef);
        $('#leaveGroupModal').modal('show');

    })

    function initEduDate() {
        $('#start_period,#end_period').daterangepicker({
            locale: {
                format: 'YYYY-MM-DD'
            },
            singleDatePicker: true,
            calender_style: "picker_4",
            "timePickerSeconds": true,
        })
    }

    // function returnD(data) {
    //     $.ajax({
    //         url: BASE_URL+'leave/ajaxLeaveGroup',
    //         data: {a : data},
    //         dataType: 'json',
    //         method: 'post'
    //     }).done(function(res){
    //         // leave_group start_period end_period isactive
    //         $('#leave_group').val(res[2]);
    //         $('#start_period').val(res[4].split('T')[0]);
    //         $('#end_period').val(res[5].split('T')[0]);
    //         $('#isactive').val(res[6]);
    //         console.log(res);
    //     }).fail(function(xhr){
    //         console.log('server error');
    //     })
    // }

})(jQuery)