jQuery(function() {
    let today = new Date();

    $('#deadline').daterangepicker({
        locale: {
            format: 'YYYY-MM-DD'
        },
        singleDatePicker: true,
        calender_style: "picker_4",
        "timePickerSeconds": true,
        "minDate": today
    })

})