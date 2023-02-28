(function ($) {

    let baseSalary = $('#basicSalary'),
        bonus = $('#bonus'),
        allowance = $('#allowance'),
        dedAmt = $('#deductionAmt'),
        advAmt = $('#advanceAmt'),
        tds = $('#tds'),
        totalPayable = $('#totalPayable'),
        nowPayable = 0;

    $('#basicSalary, #bonus, #allowance').on('input', function (e) {
        addBasicSalary()
        calculateTDS()
    })

    $('#deductionAmt, #advanceAmt').on('input', function (e) {
        subBasicSalary()
        calculateTDS()
    })

    function addBasicSalary() {
        let curAmt = Number(baseSalary.val()) + Number(bonus.val()) + Number(allowance.val())
        nowPayable = curAmt;
    }

    function subBasicSalary() {
        let curAmt = Number(dedAmt.val()) + Number(advAmt.val())
        nowPayable = nowPayable - curAmt
    }

    function calculateTDS() {
        //un married
        if(1 == 1){

        }
        // married
        else{

        }
    }

    $('#salary_month').on('change', function(e){
        salaryMonth()
    })
    
    function salaryMonth() {

    }

})(jQuery)