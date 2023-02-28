$(function(){
    $('#fromDate, #toDate').daterangepicker({
        locale: {
            format: 'YYYY-MM-DD'
        },
        singleDatePicker: true,
        calender_style: "picker_4",
        "timePickerSeconds": true,
    })

    let appReport = $('#appReport').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'excel', 'print'
        ],
        responsive: true,
        autoWidth: false
    })

    // setTimeout(function() {
        $('.apper').removeClass('col-md-11')
        $('.apper').addClass('col-md-12')
    // },1000)
})