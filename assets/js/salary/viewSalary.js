(function ($) {
    let today = new Date();

    setTimeout(function(){
        $('#hamclose').trigger('click');
    }, 500);

    $('#from, #to').daterangepicker({
        locale: {
            format: 'YYYY-MM-DD'
        },
        singleDatePicker: true,
        calender_style: "picker_4",
        "timePickerSeconds": true,
        // "maxDate": today
    })

    $('#searchEmp').on('submit', async function (e) {
        e.preventDefault();
        const res = await callEmployeeSal();
        $('#salEmpTbl tbody').empty()
        if(res != false){
            let alD = res.rdet
            if(alD.length != 0){
                // toastr.success('Called')
                let seData = '';
                alD.forEach(ele => {
                    seData += `<tr>
                    <td>${ele.EmployeeId}</td>
                    <td>${ele.SalaryMonth}</td>
                    <td>${ele.BasicSalary}</td>
                    <td>${ele.Allowance}</td>
                    <td>${ele.Bonus}</td>
                    <td>${ele.ProvidentFund}</td>
                    <td>${ele.Insurance}</td>
                    <td>${ele.CitizenInvestmentTrust}</td>
                    <td>${ele.DeductionAmt}</td>
                    <td>${ele.OtherFunds}</td>
                    <td>${ele.Others}</td>
                    <td>${ele.TDSAmount}</td>
                    <td>${ele.TotalPayable}</td>
                    <td>${ele.Remarks}</td></tr>`
                });
                $('#salEmpTbl').append(`tbody ${seData}`)
            }else{
                toastr.info('No Salary Data. Please try a valid Date')
            }
        }else{
            toastr.error('Server error')
        }
    })

    function callEmployeeSal() {
        return new Promise(resolve => {
            $.ajax({
                url: BASE_URL + 'salary/ajaxGetMonthlySalaryByEmployeeIdAndDate',
                data: { empId: $('#emp_id').val(), from: $('#from').val(), to: $('#to').val() },
                method: 'post',
                dataType: 'json'
            }).done(function (res) {
                resolve(res)
            }).fail(function (res) {
                resolve(false)
            })
        })
    }


})(jQuery)