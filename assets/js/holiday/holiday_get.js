jQuery(function() {
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

    $('#searchHoliday').on('submit', async function(e){
        e.preventDefault()
        dashboard_e.prepend(loaderElem);
        const res = await getAjaxHoliday();
        let tbl = '';
        if(res.length != 0){
            res.forEach(ele => {
                tbl += '<tr><td>'+ele.FiscalYear+'</td><td>'+ele.HolidayDate.split('T')[0]+'</td><td>'+ele.HolidayRemarks+'</td></tr>'
            });
        }else{
            tbl += '<tr><td colspan="3" style="text-align: center;">No Data Available</td></tr>'
        }
        $('#holiTbl tbody').html(tbl)
        loaderElem.remove();
    })

    function getAjaxHoliday() {
        return new Promise(resolve => {
            $.ajax({
                url: BASE_URL+'holiday/ajaxGetHolidayDate',
                dataType: 'json',
                data: {from: $('#from').val(), to: $('#to').val()},
                method: 'post'
            }).done(function(res){
                resolve(res)
            }).fail(function(res){
                resolve(false)
            })
        })
    }
})