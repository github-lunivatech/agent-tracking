$(document).ready(function () {
    let base_url = $('#base_url').html();
    let today = new Date();
    // $('#emp_dob').val('');
    $('#fromDate').daterangepicker({
        locale: {
            format: 'YYYY-MM-DD'
        },
        singleDatePicker: true,
        calender_style: "picker_4",
        "timePickerSeconds": true,
        // "minDate": today
    });

    //for nepali
    var currentDate = new Date();
    var formatedNepaliDate = returnFormatedDate(currentDate);

    if ($("#nepaliFrom").val() == '') {
        $("#nepaliFrom").val(formatedNepaliDate);
    }

    if ($("#nepaliDateForm").val() == '') {
        $("#nepaliDateForm").val(formatedNepaliDate);
    }
    // if ($("#nepaliTo").val() == '') {
    //     $("#nepaliTo").val(formatedNepaliDate);
    // }
    
    $("#nepaliFrom").nepaliDatePicker({
        dateFormat: "%y-%m-%d",
        closeOnDateSelect: true,
        // minDate: "२०७०-१-२०",
        // maxDate: formatedNepaliDate
    });

    
    $("#nepaliDateForm").nepaliDatePicker({
        dateFormat: "%y-%m-%d",
        closeOnDateSelect: true,
        // minDate: "२०७०-१-२०",
        // maxDate: formatedNepaliDate
    });

    

    $("#nepaliFrom").on("dateSelect", function (event) {
        let dateData = event.datePickerData;
        let selNepFrom = dateData.adDate;
        let fullDate = returnFullYear(selNepFrom)
        // $('#fromDate').data('daterangepicker').setStartDate(fullDate);
        // $('#fromDate').data('daterangepicker').setEndDate(fullDate);
    });

    $("#nepaliDateForm").on("dateSelect", function (event) {
        let dateData = event.datePickerData;
        let selNepFrom = dateData.adDate;
        let fullDate = returnFullYear(selNepFrom)
        // $('#fromDate').data('daterangepicker').setStartDate(fullDate);
        // $('#fromDate').data('daterangepicker').setEndDate(fullDate);
    });

    // $("#nepaliTo").on("dateSelect", function (event) {
    //     let dateData = event.datePickerData;
    //     let selNepTo = dateData.adDate;
    //     let fullDate = returnFullYear(selNepTo)
    //     $('#toDate').data('daterangepicker').setStartDate(fullDate);
    //     $('#toDate').data('daterangepicker').setEndDate(fullDate);
    // });

    function returnFullYear(selDate) {
        let y = selDate.getFullYear();
        let m1 = returnMonth(selDate);
        let d = returnDay(selDate.getDate());
        let fullDate = y+'-'+m1+'-'+d;
        return fullDate;
    }

    function returnMonth(selDate,isNepali=false) {
        let m = selDate;
        if(!isNepali){
            m = selDate.getMonth() + 1;
        }
        return m < 10 ? '0'+m : m;
    }

    function returnDay(day) {
        return day < 10 ? '0'+day : day;
    }

    function returnFormatedDate(selFromDate) {
        var currentNepaliDate = calendarFunctions.getBsDateByAdDate(selFromDate.getFullYear(), selFromDate.getMonth() + 1, selFromDate.getDate());
        var formatedNepaliDate = calendarFunctions.bsDateFormat("%y-%m-%d", currentNepaliDate.bsYear, currentNepaliDate.bsMonth, currentNepaliDate.bsDate);
        return formatedNepaliDate;
    }

    function returnEnglishNepaliDate(currentNepaliDate) {
        let bZMonth = returnMonth(currentNepaliDate.bsMonth,true);
        let bZDay = returnDay(currentNepaliDate.bsDate);
        return currentNepaliDate.bsYear+'-'+bZMonth+'-'+bZDay;
    }
    
    $('#fromDate').on('apply.daterangepicker', function (ev, picker) {
        let selFromDate = new Date(picker.startDate.format('YYYY-MM-DD'));
        var formatedNepaliDate = returnFormatedDate(selFromDate)
        $("#nepaliFrom").val(formatedNepaliDate);
    })

    $('#fromDate').on('apply.daterangepicker', function (ev, picker) {
        let selFromDate = new Date(picker.startDate.format('YYYY-MM-DD'));
        var formatedNepaliDate = returnFormatedDate(selFromDate)
        $("#nepaliDateForm").val(formatedNepaliDate);
    })
    // $('#toDate').on('apply.daterangepicker', function (ev, picker) {
    //     let selToDate = new Date(picker.startDate.format('YYYY-MM-DD'));
    //     var formatedNepaliDate = returnFormatedDate(selToDate)
    //     $("#nepaliTo").val(formatedNepaliDate);
    // })

    $('#show_nepaliCheck').on('click', function(e){
        if(this.checked){
            $("#nepaliFrom").hide()
            $('#emp_dob').show()
            // $('input[name="nepaliFrom"]').val('');
            // $("input[name='nepaliFrom']").val('')
        }else{
            $("#nepaliFrom").show()
            $('#emp_dob').hide()
            $('input[name="emp_dob"]').val('');
            // $('#emp_dob').val()

        }
    })
})