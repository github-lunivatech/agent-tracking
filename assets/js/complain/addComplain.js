jQuery(function () {

    $('#comp_date').daterangepicker({
        locale: {
            format: 'YYYY-MM-DD'
        },
        singleDatePicker: true,
        calender_style: "picker_4",
        "timePickerSeconds": true,
    })

    $('#addComplainForm').on('submit', function (e) {
        e.preventDefault();
        $('#saver').attr('disabled', true)
        saveCompalin($(this).serializeArray())
    })

    async function saveCompalin(data) {
        const res = await insertComplains(data);
        if (res.coid > 0) {
            Swal.fire({
                title: 'Do you want assign this complain?',
                icon: 'success',
                showDenyButton: true,
                // showCancelButton: true,
                confirmButtonText: `Yes`,
                denyButtonText: `No`,
            }).then((result) => {
                if (result.isConfirmed) {
                    location.href = BASE_URL + 'complain/complainProfile?q=' + res.coo;
                } else {
                    // if (result.isDenied)
                    location.href = BASE_URL + 'complain/viewComplains';
                }
            })
        } else {

        }
        $('#saver').removeAttr('disabled')
    }

    function insertComplains(data) {
        return new Promise(resolve => {
            $.ajax({
                url: BASE_URL + 'complain/insertComplaint',
                data: data,
                dataType: 'json',
                method: 'post'
            }).done(function (res) {
                resolve(res)
            }).fail(function (res) {
                resolve(false)
            })
        })
    }

})