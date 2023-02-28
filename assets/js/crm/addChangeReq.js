(function ($) {

    //all for date
    $('.all_date_pick').daterangepicker({
        locale: {
            format: 'YYYY-MM-DD'
        },
        singleDatePicker: true,
        calender_style: "picker_4",
        "timePickerSeconds": true,
        // "minDate": today
    })

    $('.all_time_pick').daterangepicker({
        timePicker: true,
        singleDatePicker: true,
        timePicker24Hour: true,
        timePickerIncrement: 1,
        timePickerSeconds: true,
        locale: {
            format: 'HH:mm:ss'
        }
    }).on('show.daterangepicker', function (ev, picker) {
        picker.container.find(".calendar-table").hide();
    });

    $('#analysis_time, #design_time, #develop_time,#test_time').on('input', function() {
        let allTime = calculateTotalTime()
        let setVal = allTime != 'NaN' ? allTime : 0;
        $('#total_tent_time').val(setVal)
    })

    function calculateTotalTime() {
        let totTime = Number($('#analysis_time').val()) + Number($('#design_time').val()) + Number($('#develop_time').val()) + Number($('#test_time').val())
        return totTime;
    }

    $('#analysis_cost, #design_cost, #develop_cost,#test_cost').on('input', function() {
        let allCost = calculateTotalCost()
        let setVal = allCost != 'NaN' ? allCost : 0;
        $('#total_tent_cost').val(setVal)
    })

    function calculateTotalCost() {
        let totTime = Number($('#analysis_cost').val()) + Number($('#design_cost').val()) + Number($('#develop_cost').val()) + Number($('#test_cost').val())
        return totTime;
    }

    $('form').on('submit', function(e){
        $('#saver').prop('disabled', true);
     })


})(jQuery)