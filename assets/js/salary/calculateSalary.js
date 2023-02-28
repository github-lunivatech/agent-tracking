jQuery(function () {
    let baseSalary = $('#basicSalary'),
        bonus = $('#bonus'),
        allowance = $('#allowance'),
        dedAmt = $('#deductionAmt'),
        advAmt = $('#advanceAmt'),
        tds = $('#tds'),
        totalPayable = $('#totalPayable'),
        nowPayable = 0,
        finalTax = 0;

    $('#basicSalary, #bonus, #allowance, #deductionAmt, #advanceAmt').on('input', function (e) {
        addBasicSalary()
    })

    function addBasicSalary() {
        let curAmt = Number(baseSalary.val()) + Number(bonus.val()) + Number(allowance.val()) - (Number(dedAmt.val()) + Number(advAmt.val()))
        if(curAmt > 0){
            nowPayable = curAmt;
            // $('#fullSalary').val(nowPayable)
            singleCalculate()
        }
    }

    // $('#deductionAmt, #advanceAmt').on('input', function (e) {
    //     let curAmt = Number(dedAmt.val()) + Number(advAmt.val())
    //     subBasicSalary(curAmt)
    // })

    // function subBasicSalary(curAmt) {
    //     subAmt = $('#fullSalary').val() - curAmt;
    //     console.log(subAmt);
    // }

    //for monthly calculations only change event needs to be added
    function singleCalculate() {
        let fullTax = 0,
            netPayable = 0,
            firstSlab = 0,
            secondSlab = 0,
            thirdSlab = 0,
            fourthSlab = 0,
            fifthSlab = 0,
            taxSlab = '';


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
        // fullTax = fullTax / 12
        // finalPayable = finalPayable / 12

        tds.val(fullTax)
        totalPayable.val(finalPayable)

        // console.log(fullTax, finalPayable, taxSlab);
    }

})