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

    let leaveManageTbl = $('#leaveManageTbl').DataTable({
        responsive: true,
        autoWidth: false,
        order: [[1, 'desc']]
    });

    let pendTbl = $('#pendTbl').DataTable({
        responsive: true,
        autoWidth: false,
        order: [[4, 'desc']]
    })

    let appTbl = $('#appTbl').DataTable({
        responsive: true,
        autoWidth: false,
        order: [[4, 'desc']]
    })

    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust()
            .responsive.recalc();
    });

    $('body').on('click', '.view_leavedet', function () {
        $('#view_own_leave .modal-body .leave_view_attachment').html('');
        $('#view_own_leave .modal-body .leave_stat_rem').html('');
        let jData = JSON.parse(this.dataset.json);

        let sD = new Date(jData[4]);
        let eD = new Date(jData[5]);

        // To calculate the time difference of two dates 
        var dTime = eD.getTime() - sD.getTime();

        // To calculate the no. of days between two dates 
        var cDay = dTime / (1000 * 3600 * 24);

        if (jData[11] != '' && jData[11] != null) {
            $('#view_own_leave .modal-body .leave_view_attachment').html('<br /><a href="' + jData[11] + '" target="_blank">View Attachment</a>')
        }
        // if (jData[8] == 'Rejected') { for now show remarks for all stats
            $('#view_own_leave .modal-body .leave_stat_rem').html('<br />' + jData[7]);
        // }
        $("#view_own_leave .modal-body .lDays").html(cDay + 1);
        $("#view_own_leave .modal-body table tbody").html('<tr><td>' + sD.toDateString() + '</td><td>' + jData[13] + '</td></tr>');
        $("#view_own_leave").modal("show");
    })

    $('body').on('click', '.cancel_leavedet', function () {
        let jData = JSON.parse(this.dataset.json);

        Swal.fire({
            title: 'Are you sure you want to cancel this leave request?',
            icon: 'warning',
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: `Yes`,
            denyButtonText: `No`,
        }).then((result) => {
            if (result.isConfirmed) {
                let data = {};
                data['laid'] = jData[0];
                data['eid'] = jData[1];
                data['leave_type'] = jData[2];
                data['leave_period'] = jData[3];
                data['startDate'] = jData[4];
                data['endDate'] = jData[5];
                data['ent_date'] = jData[6];
                cancelRequest(data);
            }
        })
    })

    function cancelRequest(data) {
        $.ajax({
            url: BASE_URL + 'leave/ajaxCancelLeave',
            data: data,
            method: 'post',
            dataType: 'json'
        }).done(function (res) {
            if (res.li != 0) {
                Swal.fire({
                    text: res.rm,
                    icon: 'success'
                }).then((result) => {
                    location.reload();
                })
            } else {
                Swal.fire({
                    text: res.rm,
                    icon: 'warning'
                })
            }
        }).fail(function (res) {
            Swal.fire({
                text: 'Server error. Please try again',
                icon: 'error'
            })
        })
    }

    let sData = {};
    $('body').on('click', '.change_leavedet', function (e) {
        $('#change_leave_stat').attr('disabled', true);
        $('#leave_changerem').val('');
        let jData = JSON.parse(this.dataset.json);
        sData = jData;
        $('#leave_changerem').val(jData[7]);

        //here keep email
        getEmailDetails( {empid: jData[1] });

        $('#view_pend_leave').modal("show")
    })

    $('body').on('submit', '#changePendLeaveStat', function (e) {
        e.preventDefault();
        dashboard_e.prepend(loaderElem);
        $('#change_leave_stat').attr('disabled', true);
        $("#view_pend_leave").modal('hide');
        let _action = BASE_URL + 'leave/ChangeLeaveStatus'
        let data = {};
        let formValid = true;

        $('input,select,textarea', $('#changePendLeaveStat')).each(function () {
            if (!this.checkValidity()) {
                formValid = false
            }
            data[this.name] = this.value
        })
        data['full'] = sData;

        $.ajax({
            url: _action,
            data: data,
            method: 'post',
            dataType: 'json'
        }).done(function (res) {
            if (res.li != 0) {
                sendEmail(res.rm, data);
            } else {
                Swal.fire({
                    text: res.rm,
                    icon: 'warning'
                }).then((result) => {
                    location.reload();
                    $('#change_leave_stat').removeAttr('disabled')
                    loaderElem.remove();
                })
            }
        }).fail(function (xhr) {
            Swal.fire({
                text: 'Server error. Please try again',
                icon: 'error'
            })
            $('#change_leave_stat').removeAttr('disabled')
            loaderElem.remove();
        })

    })

    if (window.location.href.match('#pele')) {
        $('.nav a[href="#pele"]').tab('show')
    }

    function sendEmail(response, data = {}) {
        let selText  = $("#pend_stat option:selected").text();
        data['subject'] = 'Response For Leave Application';
        data['mbody'] = 'Your application for leave has been '+selText+' for the following reason';
        data['from'] = 'Approver';
        $.ajax({
            url: BASE_URL + 'leave/sendStatusEmail',
            method: 'post',
            dataType: 'json',
            data: data
        }).done(function (res) {
            //reload only here when status is changed and email is being sent
            if (res.sent) {
                Swal.fire({
                    text: response + ' ' + res.sent,
                    icon: 'success'
                }).then((result) => {
                    location.reload();
                })
                loaderElem.remove();
                $('#change_leave_stat').removeAttr('disabled')
            }
        }).fail(function (xhr) {
            Swal.fire({
                text: response + ' But Email is not sent',
                icon: 'warning'
            }).then((result) => {
                location.reload();
            })
            $('#change_leave_stat').removeAttr('disabled')
            loaderElem.remove();
        })
    }

    function getEmailDetails(data) {
        $.ajax({
            url: BASE_URL+'leave/ajaxGetEmailDetails',
            method: 'post',
            data: data,
            dataType: 'json'
        }).done(function(res){
            $('#ema').empty()
            res.forEach(el => {
                $('#ema').append('<input type="hidden" name="toer[]"  value="'+el['urlPram']+'">'); 
            });
            $('#change_leave_stat').removeAttr('disabled');
        }).fail(function(res){
            console.log('server error');
        })
    }

})(jQuery)