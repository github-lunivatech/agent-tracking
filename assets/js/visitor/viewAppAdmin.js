(function ($) {
    var dashboard_e = document.getElementById('app-main');
    var loaderElem = ecrm.loaderElement;

    let today = new Date()
    $('#fromDate,#toDate').daterangepicker({
        locale: {
            format: 'YYYY-MM-DD'
        },
        singleDatePicker: true,
        calender_style: "picker_4",
        "timePickerSeconds": true,
    })

    let carder = '';

    $('.aer').on('click', function (e) {
        e.preventDefault();
        $('#editAppModal #canAppAc').attr('data-ai', '')

        let aData = JSON.parse(this.dataset.all);
        carder = this.dataset.carder;

        $('#editAppModal .app_namer').html(aData['vname'])
        $('#editAppModal .app_addresser').html(aData['vaddress'])
        $('#editAppModal .app_remarker').html(aData['vremarks'])
        $('#editAppModal .app_dater').html(aData['appdate'].split('T')[0])
        $('#editAppModal .app_timer').html(aData['intime'])
        $('#editAppModal #canAppAc').attr('data-ai', aData['encA'])

        $('#editAppModal').modal('show')
    })

    $('body').on('submit', '#editAppForm', async function(e){
        e.preventDefault();
        $('#editAppAc').attr('disabled', true)
        dashboard_e.prepend(loaderElem);
        $('#editAppModal').modal('hide')
        let ai = $('#canAppAc')[0].dataset.ai;
        const res = await accApp(ai)
        if (res.sid == 'no id') {
            toastr.warning('No Id. Please try again')
        } else if (res.sid > 0) {
            toastr.success('Successfully accepted appointment')
        
            $('.'+carder+' .widget-content').removeClass('bg-danger')
            $('.'+carder+' .widget-content').removeClass('bg-warning')
            $('.'+carder+' .widget-content-wrapper').removeClass('text-dark');

            $('.'+carder+' .widget-content').addClass('bg-success');
            $('.'+carder+' .widget-content-wrapper').addClass('text-white');
        } else {
            toastr.warning('Appointment accepting error. Please try again')
        }
        loaderElem.remove();
        $('#editAppAc').removeAttr('disabled')
    })

    function accApp(ai) {
        return new Promise(resolve => {
            $.ajax({
                url: BASE_URL + 'visitor/updateStatus',
                data: { ai: ai, stat: 1 },
                method: 'post',
                dataType: 'json'
            }).done(function (res) {
              resolve(res)
            }).fail(function (xhr) {
                toastr.error('Server Error')
                loaderElem.remove();
                $('#editAppAc').removeAttr('disabled')
            })
        })
    }

    $('body').on('click', '#canAppAc', function (e) {
        let ai = this.dataset.ai,
            titext = 'Are you sure you want to cancel this appointment?',
            ytext = 'Yes',
            ntext = 'No';
        if($('#show_nepali').val() == true){
            titext = 'के तपाइँ पक्का यो भेट रद्द गर्न चाहानुहुन्छ?'
            ytext = 'हो'
            ntext = 'होईन'
        }
        Swal.fire({
            title: titext,
            icon: 'warning',
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: ytext,
            denyButtonText: ntext,
        }).then((result) => {
            if (result.isConfirmed) {
                cancelAppointment(ai);
            } else {

            }
        })

    })

    function cancelAppointment(ai = 0) {
        dashboard_e.prepend(loaderElem);
        $('#editAppModal').modal('hide')
        $.ajax({
            url: BASE_URL + 'visitor/updateStatus',
            data: { ai: ai },
            method: 'post',
            dataType: 'json'
        }).done(function (res) {
            if (res.sid == 'no id') {
                toastr.warning('No Id. Please try again')
                loaderElem.remove();
            } else if (res.sid > 0) {
                toastr.success('Successfully cancelled appointment')
                
                $('.'+carder+' .widget-content').removeClass('bg-success')
                $('.'+carder+' .widget-content').removeClass('bg-warning')
                $('.'+carder+' .widget-content-wrapper').removeClass('text-dark');

                $('.'+carder+' .widget-content').addClass('bg-danger');
                $('.'+carder+' .widget-content-wrapper').addClass('text-white');
                
                loaderElem.remove();
            } else {
                toastr.warning('Appointment Cancelling error. Please try again')
                loaderElem.remove();
            }
        }).fail(function (xhr) {
            toastr.error('Server Error')
            loaderElem.remove();
        })
    }

    $('.pender').on('click', async function(e){
        e.preventDefault();
        console.log('show only pending');
        filterCard()
    })


    function filterCard() {

    }

})(jQuery)