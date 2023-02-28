jQuery(function () {

    // $('#salEmpTbl').DataTable({
    //     dom: 'Bfrtip',
    //     buttons: [
    //         {
    //             extend: 'excel',
    //             text: 'Excel Export'
    //         },
    //         {
    //             extend: 'print',
    //             customize: function (doc) {
    //                 var printDoc = doc.document;

    //                 let data_table = printDoc.getElementsByTagName('table')[0];
    //                 data_table.classList.remove('collapsed');
    //             }
    //         }
    //     ],
    //     responsive: true,
    //     autoWidth: false,
    // })

    $('.add_com').on('click', function (e) {
        let da = this.dataset;
        $('#comp_stat_id').val(da.stid);
        $('#comp_stat_comment').val(da.stat)
        // $('#remarks_comment').val(da.rem)
        $('#add_comment').modal('show');
    })

    $('#complainForm').on('submit', async function (e) {
        e.preventDefault();
        $('#post').attr('disabled', true)
        const res = await complainSubmit();
        if (res) {
            if (res.coid > 0) {
                swaler('success', 'Complain Status Changed', false)
                setTimeout(() => {
                    location.reload()
                }, 500);
            } else {
                swaler('warning', 'Complain Status Not Changed')
            }
        } else {
            swaler('error', 'Something went wrong')
        }
    })

    function swaler(iconer = 'error', texter = '', disabler = true) {
        Swal.fire({
            icon: iconer,
            text: texter,
            showConfirmButton: false,
            timer: 1000,
        })
        if (disabler)
            $('#post').removeAttr('disabled')
    }

    function complainSubmit() {
        return new Promise(resolve => {
            $.ajax({
                url: BASE_URL + 'complain/ajaxUpdateComplainStatus',
                method: 'post',
                data: $('#complainForm').serializeArray(),
                dataType: 'json'
            }).done(function (res) {
                resolve(res)
            }).fail(function (res) {
                resolve(false)
            })
        })
    }

})