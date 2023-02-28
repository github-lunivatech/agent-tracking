(function($){

    let today = new Date()
    $('#fromDate,#toDate').daterangepicker({
        locale: {
            format: 'YYYY-MM-DD'
        },
        singleDatePicker: true,
        calender_style: "picker_4",
        "timePickerSeconds": true,
    })

    let leaveLookupTbl = $('#leaveLookupTbl').DataTable({
        responsive: true,
        autoWidth: false
    })

    console.log(leaveLookupTbl);

})(jQuery)