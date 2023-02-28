jQuery(function () {
    let today = new Date();
    var dashboard_e = document.getElementById('app-main');
    var loaderElem = ecrm.loaderElement;

    $('#from, #to').daterangepicker({
        locale: {
            format: 'YYYY-MM-DD'
        },
        singleDatePicker: true,
        calender_style: "picker_4",
        "timePickerSeconds": true,
        // "maxDate": today
    })

})