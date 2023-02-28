var goNextTab = function (current, next, sender) {
    if (sender !== undefined && sender != '') {

        next = $(sender).attr('href').replace('#', '');
        var activeTab = $('a.active');
        current = activeTab.attr('href').replace('#', '');
    }
    var navCur = current.replace('-tab', '');
    var navNext = next.replace('-tab', '');

    var currentTab = $("#" + current + '');
    var currentNav = $("#pane-" + navCur);

    var nextTab = $("#" + next + '');
    var nextNav = $("#pane-" + navNext);

    currentTab.addClass('hide');
    currentTab.removeClass('show active');
    nextTab.addClass("show active");
    nextTab.removeClass("hide");

    currentNav.removeClass('active');
    nextNav.addClass("active");
    window.scrollTo(0, 0);



}

$(document).ready(function () {

    var hasSavedCustomerDetails = false;
    // var forms = $('form');



    function displayErrors(errors) {
        // Code to display errors
        alert(errors);
    }
    var base_url = `${BASE_URL}`;
    console.log(base_url);


    // if()
    // $('.nexttab').on('click', function () {
    var gotonextornotpersonal = $(".nextornotforpersonaldetails").val();
    var gotonextornotaddress = $(".nextornotforpersonaldetails").val();

    // if (gotonextornotpersonal == '1' || gotonextornotaddress)

    $('form').on('submit', function (e) {
        // alert('a')
        e.preventDefault();
        var i, items = $('.nav-link'), pane = $('.tab-pane');
        // var url = form.attr('action');
        // console.log(url);


        var form = $(this);
        var btn = form.find('input[type="submit"]');


        var formId = form.attr('id');
        var eid = $(".hidden_eid").val();
        var submitUrl = form.attr('action');
        if (formId != 'customer-details') {
            // var eid = $(".hidden_eid").val();
            // console.log(eid);

            // submitUrl = submitUrl + '?eid=' + eid;
        }

        var valid = form[0].checkValidity();

        if (valid) {
            var formData = new FormData(form[0]);
            if (formId == 'customer-details') {
                var eimg = $('#emp_image').val();
                var emp_image = $('#emp_image').val();
                // console.log(emp_image);
                var eimg2 = $('#emp_image')[0].dataset.val;
                formData.append('emp_image', $('#emp_image')[0].files[0]);
            }
            // if(eid!='' && formId=='customer_details' &&formId="address_details")

            $.ajax({
                type: 'POST',
                url: submitUrl,
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        console.log(response);
                        // var activeTab = $('a[aria-controls="' + form.parent().attr('id') + '"]');

                        if (formId == 'customer-details') {
                            $(".hidden_eid").val(response.e);
                            // $(".nextornotforpersonaldetails").val(1);

                            btn.attr('type', 'button');
                            btn.attr('onclick', "goNextTab('customer-details-tab', 'address-details-tab');")
                            alert("Customer Details has been submitted successfully!");
                            goNextTab('customer-details-tab', 'address-details-tab');
                            if (emp_image != '' && response.e != '') {
                                formData.append('eid', response.uP);
                                uploadImg(formData, response.uP)
                            }
                        } else if (formId == 'address-details') {
                            btn.attr('type', 'button');
                            btn.attr('onclick', "goNextTab('address-details-tab', 'nominee-details-tab');")
                            $(".nextornotforaddressdetails").val(1);
                            alert("Address has been submitted successfully!");
                            goNextTab('address-details-tab', 'nominee-details-tab');
                        }
                        else {
                            // $(".nextornotforaddressdetails").val()
                            alert("Nominee Details has been submitted successfully!");

                            var href = base_url + response.url
                            location.href = href;
                            // console.log(href);
                        }

                    } else {
                        displayErrors(response.errors);
                    }
                }
            });
        }
    });
    // });
    function bootstrapTabControl() {

        // $('.nexttab').on('click', function () {



        var i, items = $('.nav-link'), pane = $('.tab-pane');
        //     // $('.active form').submit();

        //     for (i = 0; i < items.length; i++) {
        //         // formvalidate();
        //         if ($(items[i]).hasClass('active') == true) {
        //             // $('#employeeRegisterForm').valdate();
        //             break;

        //         }
        //     }

        //     if (i < items.length - 1) {
        //         // for tab
        //         $(items[i]).removeClass('active');
        //         $(items[i + 1]).addClass('active');
        //         // for pane
        //         $(pane[i]).removeClass('show active');
        //         $(pane[i + 1]).addClass('show active');
        //     }


        // });
        //     //     // Prev

        $('.prevtab').on('click', function () {
            var prevBtn = form.find('button');

            for (i = 0; i < items.length; i++) {
                if ($(items[i]).hasClass('active') == true) {
                    break;
                }
            }
            if (i != 0) {
                // for tab
                $(items[i]).removeClass('active');
                $(items[i - 1]).addClass('active');
                // for pane
                $(pane[i]).removeClass('show active');
                $(pane[i - 1]).addClass('show active');
            }
        });
    }
    bootstrapTabControl();

    // var forms = $('form');

    // forms.on('submit', function (e) {
    //     e.preventDefault();
    //     var form = $(this);
    //     var valid = form[0].checkValidity();
    //     if (valid) {
    //         var formData = new FormData(form[0]);
    //         $.ajax({
    //             type: 'POST',
    //             url: form.attr('action'),
    //             data: formData,
    //             contentType: false,
    //             processData: false,
    //             dataType: 'json',
    //             success: function (response) {
    //                 if (response.success) {
    //                     var activeTab = $('a[aria-controls="' + form.parent().attr('id') + '"]');
    //                     var nextTab = activeTab.parent().next().find('a');
    //                     nextTab.tab('show');
    //                     if (form.attr('id') == 'form-1') {
    //                         alert("Form1 has been submitted successfully!");
    //                     } else {
    //                         alert("Form2 has been submitted successfully!");
    //                     }
    //                 } else {
    //                     displayErrors(response.errors);
    //                 }
    //             }
    //         });
    //     }
    // });

    // function displayErrors(errors) {
    //     // Code to display errors
    // }

    function uploadImg(formData, eid) {
        console.log(emp_image);
        console.log(eid);
        var eid = eid;
        var emp_image = emp_image;
        // let eimg = $('#emp_image').val();
        // console.log(eimg);
        // filename = {
        //     name: 'emp_image',
        //     value: eimg
        // }

        $.ajax({
            url: BASE_URL + 'employee/AjaxUploadEmpImage',
            dataType: 'json',
            method: 'post',
            data: formData,
            processData: false,
            contentType: false,
        }).done(function (res) {
            // if (res.filename) {
            //     filename = {
            //         name: 'emp_image',
            //         value: res.filename
            //     }
            // }
            // if (eid != '') {
            //     eid = {
            //         name: 'eid',
            //         value: eid
            //     }
            //     insertUpdateDetails(formData, true, filename, eid);
            // }
            console.log(res);
        }).fail(function (xhr) {
            // Swal.fire({
            //     icon: 'error',
            //     text: 'Server error. Please try again later',
            //     showConfirmButton: false,
            //     timer: 1000,
            // });
            console.log('image not uploaded')

        });
    }
})