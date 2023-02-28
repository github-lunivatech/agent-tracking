$(document).ready(function () {
    var dashboard_e = document.getElementById('app-main');
    var loaderElem = ecrm.loaderElement;
    console.log(loaderElem);
    var base_url = `${BASE_URL}`;
    // function bootstrapTabControl() {
    //     var i, items = $('.nav-link'), pane = $('.tab-pane');
    //     $('.nexttab').on('click', function () {
    //         for (i = 0; i < items.length; i++) {
    //             // formvalidate();
    //             if ($(items[i]).hasClass('active') == true) {
    //                 $('#employeeRegisterForm').valdate();
    //                 break;

    //             }
    //         }
    //         if (i < items.length - 1) {
    //             // for tab
    //             $(items[i]).removeClass('active');
    //             $(items[i + 1]).addClass('active');
    //             // for pane
    //             $(pane[i]).removeClass('show active');
    //             $(pane[i + 1]).addClass('show active');
    //         }

    //     });
    //     // Prev

    //     $('.prevtab').on('click', function () {
    //         for (i = 0; i < items.length; i++) {
    //             if ($(items[i]).hasClass('active') == true) {
    //                 break;
    //             }
    //         }
    //         if (i != 0) {
    //             // for tab
    //             $(items[i]).removeClass('active');
    //             $(items[i - 1]).addClass('active');
    //             // for pane
    //             $(pane[i]).removeClass('show active');
    //             $(pane[i - 1]).addClass('show active');
    //         }
    //     });
    // }
    // bootstrapTabControl();

    $('#employeeRegisterForm').on('submit', function (e) {
        $('#saver').attr('disabled', true);
        e.preventDefault();

        // bootstrapTabControl();
        dashboard_e.prepend(loaderElem);

        let formData = new FormData(this);

        let eid = $('#eid').val();
        let eimg = $('#emp_image').val();
        let eimg2 = $('#emp_image')[0].dataset.val;
        formData.append('emp_image', $('#emp_image')[0].files[0]);

        if (eid != '') {
            formData.append('eid', eid);
            uploadImg(formData, eid)
        } else {
            if (eimg == '') {
                insertUpdateDetails(formData);
            } else {
                insertUpdateDetails(formData, false);
            }
        }

    })

    function uploadImg(formData, eid) {
        console.log(formData);
        let eimg = $('#emp_image')[0].dataset.val;
        filename = {
            name: 'emp_image',
            value: eimg
        }
        $.ajax({
            url: BASE_URL + 'employee/AjaxUploadEmpImage',
            dataType: 'json',
            method: 'post',
            data: formData,
            processData: false,
            contentType: false,
        }).done(function (res) {
            if (res.filename) {
                filename = {
                    name: 'emp_image',
                    value: res.filename
                }
            }
            if (eid != '') {
                eid = {
                    name: 'eid',
                    value: eid
                }
                insertUpdateDetails(formData, true, filename, eid);
            }
        }).fail(function (xhr) {
            Swal.fire({
                icon: 'error',
                text: 'Server error. Please try again later',
                showConfirmButton: false,
                timer: 1000,
            });
            $('#saver').removeAttr('disabled');
            loaderElem.remove();
        })
    }

    function insertUpdateDetails(formData, isJustIns = true, filename = '', eid = '') {
        let data = $('#employeeRegisterForm').serializeArray();
        if (filename != '') {
            data.push(filename)
        }
        if (eid != '') {
            data.push(eid);
        }

        $.ajax({
            url: BASE_URL + 'employee/insertUpdateEmployeePersonalDetails',
            method: 'post',
            dataType: 'json',
            data: data
        }).done(function (res) {
            if (res.e != 0) {
                if (isJustIns == false) {
                    returnEid(formData, res.uP);
                } else {
                    Swal.fire({
                        title: res.rs + '. <br /> Do you want to go to employee profile? <br /> Your Customer Code is SAC-' + res.empcode,
                        icon: 'success',
                        showDenyButton: true,
                        showCancelButton: true,
                        confirmButtonText: `Yes`,
                        denyButtonText: `No`,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.href = BASE_URL + 'employee/emprofile?q=' + res.uP;
                        } else if (result.isDenied) {
                            $("#employeeRegisterForm")[0].reset();
                            $("#ece").val(res.e);
                            timer: 1000;
                        } else {
                            location.href = BASE_URL + 'employee/em_edit?q=' + res.uP;
                        }
                    })
                }
            } else {
                Swal.fire({
                    icon: 'warning',
                    text: 'Employee Details is not processed. Please try again later',
                    showConfirmButton: false,
                    timer: 1000,
                })
                $('#saver').removeAttr('disabled');
                loaderElem.remove();
            }
        }).fail(function (xhr) {
            Swal.fire({
                icon: 'error',
                text: 'Server error. Please try again later',
                showConfirmButton: false,
                timer: 1000,
            });
            $('#saver').removeAttr('disabled');
            loaderElem.remove();
        })

    }

    function returnEid(formData, eid) {
        formData.append('eid', eid);
        uploadImg(formData, eid);
    }


})