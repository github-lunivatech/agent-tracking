jQuery(function () {
    let today = new Date();
    var dashboard_e = document.getElementById('app-main');
    var loaderElem = ecrm.loaderElement;

    $('.allDateRange').daterangepicker({
        locale: {
            format: 'YYYY-MM-DD'
        },
        singleDatePicker: true,
        calender_style: "picker_4",
        "timePickerSeconds": true,
        "minDate": today
    })

    $('.give_rev_btn').on('click', async function (e) {
        e.preventDefault()
        this.disabled = true;
        let rowno = this.dataset.row
        let data = $('.' + rowno + ' input, .' + rowno + ' select').serializeArray();
        data.push(
            { name: "fromDate", value: $('#from').val() }, 
            { name: "toDate", value: $('#to').val() }
        );
        const res = await giveReview(data)
        if (res) {
            if (res.no_id != 0) {
                toastr.warning(res.no_id);
                this.disabled = false;
            } else {
                if (res.retI > 0) {
                    toastr.success('Successfully Review given')
                } else {
                    this.disabled = false;
                    toastr.warning('Reivew not given. Please try again')
                }
            }
        } else {
            this.disabled = false;
            toastr.warning('Please try again.')
        }
    })

    function giveReview(data) {
        return new Promise(resolve => {
            $.ajax({
                url: BASE_URL + 'performance/giveReview',
                data: data,
                method: 'post',
                dataType: 'json'
            }).done(function (res) {
                resolve(res)
            }).fail(function (res) {
                resolve(false)
            })
        })
    }

    $('input[name="give_point[]"]').on('input', function(e){
        let maxvalue = Number(this.getAttribute('max'));
        let nowValue = Number(this.value);
        if(maxvalue < nowValue || nowValue < 0){
            this.value = '';
        }
    })
})