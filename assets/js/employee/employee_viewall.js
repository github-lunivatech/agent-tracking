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

    let empTable = $('#empTable').DataTable({
        responsive: true,
        autoWidth: false,
    })

})(jQuery)