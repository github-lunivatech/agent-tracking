jQuery(function () {
    let basicSalary = $('#basic_salary'),
        festivalBonus = $('#festival_bonus'),
        allowance = $('#allowance'),
        others = $('#others'),
        provFund = $('#provident_fund'),
        citInv = $('#citizen_investment'),
        insurance = $('#insurance'),
        otherFund = $('#other_fund'),
        nowPayable = 0,
        tds = $('#tds'),
        totalPayable = $('#total_payable');

    $('#basic_salary, #festival_bonus, #allowance, #others, #provident_fund, #citizen_investment, #insurance, #other_fund').on('input', function (e) {
        addBasicSalary()
    })

    function addBasicSalary() {
        // basic * 12
        // festival same
        // allowance * 12
        // others * 12
        // provident * 12
        // trust * 12
        // insurance same
        // other fund * 12 for now
        // ^ is for monthly for yearly remove all 12
        let addAmt = 0;
        let subAmt = 0;
        if('monthly' == 'monthly'){
            addAmt = (Number(basicSalary.val()) * 12) + Number(festivalBonus.val()) + (Number(allowance.val()) * 12) + (Number(others.val()) * 12);
            subAmt = (Number(provFund.val()) * 12) + (Number(citInv.val()) * 12) + Number(insurance.val()) + (Number(otherFund.val()) * 12)
        }else{
            addAmt = (Number(basicSalary.val())) + Number(festivalBonus.val()) + (Number(allowance.val())) + (Number(others.val()));
            subAmt = (Number(provFund.val())) + (Number(citInv.val())) + Number(insurance.val()) + (Number(otherFund.val()))
        }
        let curAmt = addAmt - subAmt
        if (curAmt >= 0) {
            nowPayable = curAmt;
            // if($('input[name="marital_stat"]').val() == 1){
            singleCalculate()
            // }else{
            //     marriedCalculate()
            // }
        }
    }


    function singleCalculate() {
        let fullTax = 0,
            netPayable = 0,
            firstSlab = 0,
            secondSlab = 0,
            thirdSlab = 0,
            fourthSlab = 0,
            fifthSlab = 0,
            taxSlab = '';
        
        if ($('input[name="marital_stat"]:checked').val() == 1) {
            //calc
            let firstSlabCal = 400000 * 0.01,
                secondSlabCal = 100000 * 0.1,
                thirdSlabCal = 200000 * 0.2,
                fourthSlabCal = 1300000 * 0.3;
            //calc

            // if monthly 12 mul
            // nowPayable = nowPayable * 12;

            //for singles only
            if (nowPayable <= 400000) {
                fullTax = nowPayable * 0.01;
                taxSlab = 'Tax Slab is 1%';
            } else if (nowPayable > 400000 && nowPayable <= 500000) {
                netPayable = nowPayable - 400000;
                firstSlab = firstSlabCal;
                secondSlab = netPayable * 0.1;
                fullTax = firstSlab + secondSlab
                taxSlab = 'Tax Slab is 10%';
            } else if (nowPayable > 500000 && nowPayable <= 700000) {
                netPayable = nowPayable - 500000;
                firstSlab = firstSlabCal;
                secondSlab = secondSlabCal;
                thirdSlab = netPayable * 0.2;
                fullTax = firstSlab + secondSlab + thirdSlab
                taxSlab = 'Tax Slab is 20%';
            } else if (nowPayable > 700000 && nowPayable <= 2000000) {
                netPayable = nowPayable - 700000;
                firstSlab = firstSlabCal;
                secondSlab = secondSlabCal;
                thirdSlab = thirdSlabCal;
                fourthSlab = netPayable * 0.3;
                fullTax = firstSlab + secondSlab + thirdSlab + fourthSlab;
                taxSlab = 'Tax Slab is 30%';
            } else if (nowPayable > 2000000) {
                netPayable = nowPayable - 2000000;
                firstSlab = firstSlabCal;
                secondSlab = secondSlabCal;
                thirdSlab = thirdSlabCal;
                fourthSlab = fourthSlabCal;
                fifthSlab = netPayable * 0.36;
                fullTax = firstSlab + secondSlab + thirdSlab + fourthSlab + fifthSlab;
                taxSlab = 'Tax Slab is 36%';
            }
            let finalPayable = nowPayable - fullTax;

            //if monthly divide 12
            fullTax = fullTax / 12
            finalPayable = finalPayable / 12

            // console.log(fullTax);
            // console.log(finalPayable);
            console.log(taxSlab);
            tds.val(Number(Math.round(fullTax+'e2')+'e-2'))
            totalPayable.val(Number(Math.round(finalPayable+'e2')+'e-2'))
        } else {

            //married

            //calc
            let firstSlabCal = 450000 * 0.01,
                secondSlabCal = 100000 * 0.1,
                thirdSlabCal = 200000 * 0.2,
                fourthSlabCal = 1250000 * 0.3;
            //calc

            // if monthly 12 mul
            // nowPayable = nowPayable * 12;

            //for singles only
            if (nowPayable <= 450000) {
                fullTax = nowPayable * 0.01;
                taxSlab = 'Tax Slab is 1%';
            } else if (nowPayable > 450000 && nowPayable <= 500000) {
                netPayable = nowPayable - 450000;
                firstSlab = firstSlabCal;
                secondSlab = netPayable * 0.1;
                fullTax = firstSlab + secondSlab
                taxSlab = 'Tax Slab is 10%';
            } else if (nowPayable > 500000 && nowPayable <= 700000) {
                netPayable = nowPayable - 500000;
                firstSlab = firstSlabCal;
                secondSlab = secondSlabCal;
                thirdSlab = netPayable * 0.2;
                fullTax = firstSlab + secondSlab + thirdSlab
                taxSlab = 'Tax Slab is 20%';
            } else if (nowPayable > 700000 && nowPayable <= 2000000) {
                netPayable = nowPayable - 700000;
                firstSlab = firstSlabCal;
                secondSlab = secondSlabCal;
                thirdSlab = thirdSlabCal;
                fourthSlab = netPayable * 0.3;
                fullTax = firstSlab + secondSlab + thirdSlab + fourthSlab;
                taxSlab = 'Tax Slab is 30%';
            } else if (nowPayable > 2000000) {
                netPayable = nowPayable - 2000000;
                firstSlab = firstSlabCal;
                secondSlab = secondSlabCal;
                thirdSlab = thirdSlabCal;
                fourthSlab = fourthSlabCal;
                fifthSlab = netPayable * 0.36;
                fullTax = firstSlab + secondSlab + thirdSlab + fourthSlab + fifthSlab;
                taxSlab = 'Tax Slab is 36%';
            }
            let finalPayable = nowPayable - fullTax;

            //if monthly divide 12
            fullTax = fullTax / 12
            finalPayable = finalPayable / 12

            // console.log(fullTax);
            // console.log(finalPayable);
            console.log(taxSlab);
            tds.val(Number(Math.round(fullTax+'e2')+'e-2'))
            totalPayable.val(Number(Math.round(finalPayable+'e2')+'e-2'))

            //married

        }
    }

    $('input[name="marital_stat"]').on('change', function(e){
        singleCalculate()
    })

})