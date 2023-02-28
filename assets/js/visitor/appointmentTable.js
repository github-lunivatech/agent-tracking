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

    let appTab = $('#appTab').DataTable({
        responsive: true,
        autoWidth: false
    })

    $('body').on('click', '.canc_det', function (e) {
        let ai = this.dataset.i;
        Swal.fire({
            title: 'Are you sure you want to cancel this appointment',
            icon: 'warning',
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: `Yes`,
            denyButtonText: `No`,
        }).then((result) => {
            if (result.isConfirmed) {
                cancelAppointment(ai);
            } else {

            }
        })

    })

    function cancelAppointment(ai = 0) {
        dashboard_e.prepend(loaderElem);

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
                setTimeout(function () {
                    loaderElem.remove();
                    location.reload()
                }, 1000);
            } else {
                toastr.warning('Appointment Cancelling error. Please try again')
                loaderElem.remove();
            }
        }).fail(function (xhr) {
            toastr.error('Server Error')
            loaderElem.remove();
        })
    }

    $('body').on('click', '.edit_det', function (e) {
        e.preventDefault();
        $('#ai').val('');
        $('.intimelabel').html('--:--:--');

        let ai = this.dataset.i;
        let ti = this.dataset.in;

        $('#ai').val(ai);
        $('.intimelabel').html(ti);

        iniTime()
        $('#editTimeModal').modal('show')
    })

    $('body').on('submit', '#editTimeForm', function (e) {
        e.preventDefault();
        $('#editTime').attr('disabled', true);
        dashboard_e.prepend(loaderElem);
        $('#editTimeModal').modal('hide');

        $.ajax({
            url: BASE_URL + 'visitor/updateOutTime',
            data: $('#editTimeForm').serializeArray(),
            method: 'post',
            dataType: 'json'
        }).done(function (res) {
            if (res.oid == 'no id') {
                toastr.warning('No Id. Please try again')
                loaderElem.remove();
            } else if (res.oid > 0) {
                toastr.success('Successfully changed out time')
                setTimeout(function () {
                    loaderElem.remove();
                    location.reload()
                }, 1000);
            } else {
                toastr.warning('Error when changing time');
                loaderElem.remove();
            }
            $('#editTime').removeAttr('disabled');
        }).fail(function (xhr) {
            toastr.error('Server Error')
            $('#editTime').removeAttr('disabled');
            loaderElem.remove();
        })
    })

    function iniTime() {
        $('#outtime').daterangepicker({
            timePicker: true,
            singleDatePicker: true,
            timePicker24Hour: false,
            timePickerIncrement: 1,
            timePickerSeconds: true,
            locale: {
                format: 'HH:mm:ss'
            }
        }).on('show.daterangepicker', function (ev, picker) {
            picker.container.find(".calendar-table").hide();
        });
    }

})(jQuery)