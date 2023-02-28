(function ($) {

  let today = new Date()

  var dashboard_e = document.getElementById('app-main');
  var loaderElem = ecrm.loaderElement;

  $('#leReq').attr('disabled', true);
  getEmailDetails({empid: null })

  $('#startDate,#endDate').daterangepicker({
    locale: {
      format: 'YYYY-MM-DD'
    },
    singleDatePicker: true,
    calender_style: "picker_4",
    "timePickerSeconds": true,
    "minDate": today
  })

  //images
  $('#add_image_button').on('click', function (e) {
    e.preventDefault()
    $('.file-upload-input').click()
  })

  $('#remove_image_button').on('click', function (e) {
    e.preventDefault()
    removeUpload()
  })

  function removeUpload() {
    $('.file-upload-input').replaceWith($('.file-upload-input').clone());
    $('.file-upload-input').val('');
    $('.file-upload-content').hide();
    $('.image-upload-wrap').show();
  }
  $('.image-upload-wrap').bind('dragover', function () {
    $('.image-upload-wrap').addClass('image-dropping');
  });
  $('.image-upload-wrap').bind('dragleave', function () {
    $('.image-upload-wrap').removeClass('image-dropping');
  });
  //images

  // setReason()
  getLeaveDays()
  $('#leave_type').on('change', function (e) {
    getLeaveDays()
  })
  function getLeaveDays() {
    $('#leReq').attr('disabled', true);
    let da = $('#leave_type').val();
    let data = { eid: '', da: da };
    $.ajax({
      url: BASE_URL + 'leave/ajaxGetLeaveDetails',
      data: data,
      method: 'post',
      dataType: 'json'
    }).done(function (res) {

      if(res >= 1) {
        $('#leReq').removeAttr('disabled');
      }

      $('.ava_day').html(res.reduce((a, b) => a + b, 0));
    })
  }
  // function setReason() {
  //   let desc = $('#leave_type').find(':selected').data('desc');
  //   $('#reason').val(desc);
  // } 
  let reqBtn = $('#leReq');
  $('#leaveForm').on('submit', function (e) {
    e.preventDefault();
    reqBtn.attr('disabled', true)
    if ($('#leave_type').val() == '' || $('#leave_type').val() == 0) {
      showError('Leave is invalid please contact the administrator for valid leaves')
      return;
    }
    if ($('#leave_type').find("option:selected").attr('data-ava') == 0) {
      showError('Leave is invalid please contact the administrator for valid leaves')
      return;
    }
    let sD = new Date($('#startDate').val());
    let eD = new Date($('#endDate').val());

    if (sD > eD) {
      showError('invalid Date call')
      reqBtn.removeAttr('disabled')
      return;
    }

    for (var arr = [], dt = new Date(sD); dt <= eD; dt.setDate(dt.getDate() + 1)) {
      arr.push(new Date(dt));
    }

    let fullLoopNeeded = arr.length;
    if (fullLoopNeeded > 7) {
      showError('only less that 7 days leave can be applied at one time')
      reqBtn.removeAttr('disabled')
      return;
    }

    dashboard_e.prepend(loaderElem);
    let _action = this.action;
    let formData = new FormData(this);

    let did = $('#did').val();
    let dimg = $('#leave_attachment').val();

    formData.append('leave_attachment', $('#leave_attachment')[0].files[0]);
    formData.append('eid', $('#eeid').val());

    if (did != '') {
      uploadAttachment(formData, did)
    } else {
      if (dimg == '') {
        submitLeaveApplication('', true, formData);
      } else {
        submitLeaveApplication('', false, formData);
      }
    }

  })

  callOnlyOnce = 0;
  function uploadAttachment(formData, did = '') {
    if (callOnlyOnce < 1) {
      formData.append('did', did);

      $.ajax({
        url: BASE_URL + 'leave/AjaxUploadLeaveAttachment',
        data: formData,
        method: 'post',
        dataType: 'json',
        processData: false,
        contentType: false,
      }).done(function (res) {
        let fPath = '';
        if (res.filename) {
          fPath = res.filename;
        }
        submitLeaveApplication(fPath, true, formData, did);
      }).fail(function (xhr) {
        console.log('server error');
        reqBtn.removeAttr('disabled')
        loaderElem.remove();
      })
    }
    callOnlyOnce++;
  }

  lastCount = 1;
  isAlreadyDone = false;
  hereNow = 1;
  async function submitLeaveApplication(fPath = '', isJusIns = true, formData, did) {
    let sD = new Date($('#startDate').val());
    let eD = new Date($('#endDate').val());

    if (sD > eD) {
      showError('invalid Date call')
      reqBtn.removeAttr('disabled')
      return;
    }

    for (var arr = [], dt = new Date(sD); dt <= eD; dt.setDate(dt.getDate() + 1)) {
      arr.push(new Date(dt));
    }

    let fullLoopNeeded = arr.length;
    if (fullLoopNeeded > 7) {
      showError('only less that 7 days leave can be applied at one time')
      reqBtn.removeAttr('disabled')
      return;
    }
    arr.forEach(element => {
      if (isAlreadyDone == false) {
        insertLeaveApplication(returnFullDate(element), fPath, lastCount, fullLoopNeeded, isJusIns, formData, did, lastCount);
      } else if (isAlreadyDone == true && hereNow == 1) {
        insertLeaveApplication(returnFullDate(element), fPath, lastCount, fullLoopNeeded, isJusIns, formData, did, lastCount);
        hereNow++;
      }
      lastCount++;
    });
  }

  function returnFullDate(dater) {
    var today = dater;
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0');
    var yyyy = today.getFullYear();

    today = yyyy + '-' + mm + '-' + dd;
    return today;
  }

  async function insertLeaveApplication(leaveDates, fPath = '', lastLoop, fullLoopNeeded, isJusIns = true, formData, did = '', onlyfirst = 0) {
    let data = {};
    let _form = $('#leaveForm');
    let formValid = true;

    $('input,select,textarea', _form).each(function () {
      if (!this.checkValidity()) {
        formValid = false;
      }
      data[this.name] = this.value;
    })
    data['startDate'] = leaveDates;
    data['endDate'] = leaveDates;
    data['leave_attachment'] = fPath;
    data['totalDays'] = fullLoopNeeded;
    if (did != '') {
      data['did'] = did;
    }

    $.ajax({
      url: BASE_URL + 'leave/ajaxLeaveApplicationByEmp',
      data: data,
      method: 'post',
      dataType: 'json'
    }).done(function (res) {
      if (isJusIns == false) {
        if (onlyfirst == 1 && isAlreadyDone == false) {
          uploadAttachment(formData, res.lis);
          isAlreadyDone = true
        }
      } else {
        // console.log(lastLoop, fullLoopNeeded);
        // for now if greater than fullloop redirect
        if (lastLoop >= fullLoopNeeded) {
          sendEmail(res, data);
        }
      }
    }).fail(function (xhr) {
      console.log('server error');
      reqBtn.removeAttr('disabled')
      loaderElem.remove();
    })
  }

  async function showError(data) {
    Swal.fire({
      title: data,
      toast: true,
      icon: 'warning',
      showDenyButton: false,
      showCancelButton: false,
    })

  }

  function sendEmail(response = '', data = {}) {

    data['subject'] = 'Application for leave';
    data['mbody'] = 'I am applying for leave with the following reason.';
    data['from'] = 'Applicant'
    $.ajax({
      url: BASE_URL + 'leave/sendStatusEmail',
      method: 'post',
      dataType: 'json',
      data: data
    }).done(function (res) {
      //reload only here when leave is applied and email is being sent
      if (res.sent) {
        setTimeout(function () {
          if (response.li > 0) {
            location.href = BASE_URL + 'leave/leaveManage';
          } else {
            location.reload();
          }
        }, 2000);
      }
    }).fail(function (xhr) {
      setTimeout(function () {
        if (response.li > 0) {
          location.href = BASE_URL + 'leave/leaveManage';
        } else {
          location.reload();
        }
      }, 2000);
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
        $('#leReq').removeAttr('disabled');
    }).fail(function(res){
        console.log('server error');
    })
}

})(jQuery)


function readURL(input) {
  if (input.files && input.files[0]) {

    var reader = new FileReader();

    reader.onload = function (e) {
      $('.image-upload-wrap').hide();
      // $('.file-upload-image').attr('src', e.target.result);
      $('.file-upload-content').show();

      $('.image-title').html(input.files[0].name);
    };

    reader.readAsDataURL(input.files[0]);

  } else {
    removeUpload();
  }
}