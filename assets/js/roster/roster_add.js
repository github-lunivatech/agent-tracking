jQuery(function () {
    let today = new Date('2021-08-06');
    $('#from, #to').daterangepicker({
        locale: {
            format: 'YYYY-MM-DD'
        },
        singleDatePicker: true,
        calender_style: "picker_4",
        "timePickerSeconds": true,
        "maxDate": today
    })

    $('#week_sel').on('change', function(e){
        
    })
    
    getWeeker()
    function getWeeker() {
        let weekAdder = $('#week_sel').val()
        let startDay = moment().add(weekAdder, 'weeks').startOf('week').format('YYYY-MM-DD');
        getAllWeek(startDay)
    }

    function getAllWeek(weekAdder) {
        var weekStart = weekAdder
        var days = [];
    
        for (var i = 0; i <= 6; i++) {
            let mData = moment(weekStart).add(i, 'days').format("YYYY-MM-DD")
            days.push(mData);
        }

        for (let i = 0; i < days.length; i++) {
            const element = days[i];
            $('.'+i+'_day').attr('data-day', element);   
            $('.'+i+'_Name span').html(element)
        }

    }


    // getCurrentWeek()
    // function getCurrentWeek() {
    //     var currentDate = moment();

    //     var weekStart = currentDate.clone().startOf('week');
    //     var weekEnd = currentDate.clone().endOf('week');

    //     var days = [];

    //     for (var i = 0; i <= 6; i++) {
    //         let mData = moment(weekStart).add(i, 'days').format("YYYY-MM-DD")
    //         days.push(mData);
    //     }

    //     for (let i = 0; i < days.length; i++) {
    //         const element = days[i];
    //         $('.'+i+'_day').attr('data-day', element);   
    //         $('.'+i+'_Name span').html(element)
    //     }
    // }

    $('select[name="shiftSel[]"]').on('change', async function(e){
        this.disabled = true
        let dater = this.dataset.day;
        let vall = this.value;
        let classer = $('.'+this.dataset.row+' input[name="exD[]"]').val();
        let fullData = {
            val: vall,
            dater: dater,
            ed: classer
        }
        const res = await updateRoster(fullData);
        if(res.drid > 0){
            toastr.success('Successfully Added')
        }else{
            toastr.warning('Not Added. Please try again')
        }
        console.log(res);
    })

    function updateRoster(data) {
        return new Promise(resolve => {
            $.ajax({
                url: BASE_URL+'roster/insertRoster',
                dataType: 'json',
                data: data,
                method: 'post'
            }).done(function(res){
                resolve(res)
            }).fail(function(res){
                resolve(false)
            })
        })
    }

})