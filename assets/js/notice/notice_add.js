jQuery(function() {
    let today = new Date();
    $('#notice_startdate, #notice_enddate').daterangepicker({
        locale: {
            format: 'YYYY-MM-DD'
        },
        singleDatePicker: true,
        calender_style: "picker_4",
        "timePickerSeconds": true,
        // "minDate": today
    })

    let salEmpTbl = $('#salEmpTbl').DataTable({
        responsive: true,
        autoWidth: false
    })
})