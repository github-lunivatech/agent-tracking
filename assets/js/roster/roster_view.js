jQuery(function () {
    let today = new Date();
    var dashboard_e = document.getElementById('app-main');
    var loaderElem = ecrm.loaderElement;

    // $('#from, #to').daterangepicker({
    //     locale: {
    //         format: 'YYYY-MM-DD'
    //     },
    //     singleDatePicker: true,
    //     calender_style: "picker_4",
    //     "timePickerSeconds": true,
    //     // "maxDate": today
    // })

    $('#week_sel').on('change', function (e) {
        getWeeker(true)
    })


    getWeeker()
    function getWeeker(changeOnlyDate = false) {
        let weekAdder = $('#week_sel').val()
        let startDay = moment().add(weekAdder, 'weeks').startOf('week').format('YYYY-MM-DD');
        getAllWeek(startDay, changeOnlyDate)
    }

    function getAllWeek(weekAdder, changeOnlyDate = false) {
        var weekStart = weekAdder
        var days = [];

        for (var i = 0; i <= 6; i++) {
            let mData = moment(weekStart).add(i, 'days').format("YYYY-MM-DD")
            days.push(mData);
        }
        let dayLen = days.length;
        if (changeOnlyDate == false) {
            for (let i = 0; i < dayLen; i++) {
                const element = days[i];
                $('.' + i + '_day').attr('data-day', element);
                $('.' + i + '_Name span').html(element)
            }
        }

        $('#from').val(days[0])
        $('#to').val(days[dayLen - 1])
    }

    $('#searchApp').on('submit', function (e) {
        e.preventDefault()
        insertAllTable()
    })

    async function insertAllTable() {
        $('.duty_roster tbody').empty();
        let allTable = '';

        const res = await ajxTable()
        var combined = res.reduce((hash, obj) => {
            return obj.EId in hash ? hash[obj.EId].push(obj) : hash[obj.EId] = [obj], hash;
        }, Object.create(null));

        var result = Object.values(combined);
        result.forEach(ele => {
            sun = '',
                mon = '';
            let DateArr = Array(),
                ShiftArr = Array();
            if (ele.length > 1) {
                ele.forEach(ee => {
                    let eee = ee.DutyDate.split('T')[0];
                    DateArr.push({
                        dater: eee, shifter: ee.Duty_Shift
                    });
                });

                sunDa = DateArr.find(({ dater }) => dater === $('.0_Name span').html())
                monDa = DateArr.find(({ dater }) => dater === $('.1_Name span').html())
                tueDa = DateArr.find(({ dater }) => dater === $('.2_Name span').html())
                wedDa = DateArr.find(({ dater }) => dater === $('.3_Name span').html())
                thuDa = DateArr.find(({ dater }) => dater === $('.4_Name span').html())
                friDa = DateArr.find(({ dater }) => dater === $('.5_Name span').html())
                satDa = DateArr.find(({ dater }) => dater === $('.6_Name span').html())

                sun = sunDa != undefined ? sunDa.dater + ` (${sunDa.shifter})` : ''
                mon = monDa != undefined ? monDa.dater + ` (${monDa.shifter})` : ''
                tue = tueDa != undefined ? tueDa.dater + ` (${tueDa.shifter})` : ''
                wed = wedDa != undefined ? wedDa.dater + ` (${wedDa.shifter})` : ''
                thu = thuDa != undefined ? thuDa.dater + ` (${thuDa.shifter})` : ''
                fri = friDa != undefined ? friDa.dater + ` (${friDa.shifter})` : ''
                sat = satDa != undefined ? satDa.dater + ` (${satDa.shifter})` : ''
            } else {
                let eee = ele[0].DutyDate.split('T')[0];
                sun = $('.0_Name span').html() == eee ? eee + ` (${ele[0].Duty_Shift})` : ''
                mon = $('.1_Name span').html() == eee ? eee + ` (${ele[0].Duty_Shift})` : ''
                tue = $('.2_Name span').html() == eee ? eee + ` (${ele[0].Duty_Shift})` : ''
                wed = $('.3_Name span').html() == eee ? eee + ` (${ele[0].Duty_Shift})` : ''
                thu = $('.4_Name span').html() == eee ? eee + ` (${ele[0].Duty_Shift})` : ''
                fri = $('.5_Name span').html() == eee ? eee + ` (${ele[0].Duty_Shift})` : ''
                sat = $('.6_Name span').html() == eee ? eee + ` (${ele[0].Duty_Shift})` : ''
            }

            allTable += `<tr>
            <td>${ele[0].EmployeeName}</td>
            <td>${ele[0].Department}</td>
            <td>${sun}</td>
            <td>${mon}</td>
            <td>${tue}</td>
            <td>${wed}</td>
            <td>${thu}</td>
            <td>${fri}</td>
            <td>${sat}</td>
            </tr>`

        });

        $('.duty_roster tbody').append(allTable);
    }

    function ajxTable() {
        return new Promise(resolve => {
            $.ajax({
                url: BASE_URL + 'roster/ajaxShift',
                data: { jobId: $('#jobId').val(), from: $('#from').val(), to: $('#to').val() },
                method: 'post',
                dataType: 'json'
            }).done(function (res) {
                resolve(res)
            }).fail(function (res) {
                resolve(res)
            })
        })
    }

    $('#print_roster').on('click', function (e) {
        e.preventDefault();

        var newtabSt = '<style>.table {width: 100%;max-width: 100%;margin-bottom: 20px;border-spacing: 0;border-collapse: collapse;}.patient-medical-history-infos table tr :first-child{border-left: 1px solid #ddd;}.patient-medical-history-infos table tr td {border-right: 1px solid #ddd;}.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;font-size:12px;}th {text-align: left;}.patient-medical-history-infos table tr:last-child {border-bottom: 1px solid #ddd;}</style>'
        var styles = '<style type="text/css">.patient-info{margin-top:140px;}.header{display:none;} body{ font-family: arial; } .companyName{font-size:18px; font-weight:bold;} .header table tr td:last-child,.patient-info table tr td:last-child{text-align: right;} .header,.patient-info{padding-bottom:0.5em; border-bottom: solid 1px; margin-bottom:0.5em;}  table.med-info tr:nth-child(even) td{ padding-bottom:2em; } table.med-info tr:nth-child(odd) td { font-weight: bold; font-size:16px; }.subContent span{font-weight:normal;} .subContent td{padding-left:3em;} .med-info td{white-space:pre-line;}@media print{body{margin-left:20px;margin-right:20px;}} tr.subContent+tr.notSubContent td{     padding-top: 1.5em; }tr.subContent:nth-child(even) td{ padding-bottom: 0.5em !important;}</style>' + newtabSt;
        var newWindow = window.open();
        
        newWindow.document.body.innerHTML = styles+ $('.duty_roster_table').html();

        setTimeout(function () {
            newWindow.print();
            newWindow.close();
        }, 1000);

    })
})