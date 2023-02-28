$(document).ready(function () {
  let today = new Date();
  // let url = new URL();
  // console.log(url);

  // $('#emp_dob').daterangepicker({
  //   locale: {
  //     format: 'YYYY-MM-DD'
  //   },
  //   singleDatePicker: true,
  //   calender_style: "picker_4",
  //   "timePickerSeconds": true,
  //   "maxDate": today
  // })

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
    $('.file-upload-input')[0].dataset.val = '';
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


  $('#employeeRegisterForm').on('submit', function (e) {
    // $('#saver').attr('disabled', true);
    // e.preventDefault();
    // let _action = this.action;
    // let formData = new FormData(this);
    // let eid = $('#eid').val();
    // let eimg = $('#emp_image').val();
    // formData.append('emp_image', $('#emp_image')[0].files[0]);
    // insertUpdateThis()
    // if (eid != '') {
    //   formData.append('eid', eid);
    //   uploadImg(formData)
    // } else {
    //   console.log('no id');

    //   return;
    // }

  })

  function uploadImg(formData) {
    // $.ajax({
    //   url: BASE_URL + 'employee/AjaxUploadEmpImage',
    //   dataType: 'json',
    //   method: 'post',
    //   data: formData,
    //   processData: false,
    //   contentType: false,
    // }).done(function (res) {
    //   filename = {
    //     name: 'filepath',
    //     value: ''
    //   }
    //   if (res.filename) {
    //     filename = {
    //       name: 'filepath',
    //       value: res.filename
    //     }
    //   }
    //   insertUpdateThis(filename);
    // }).fail(function (xhr) {
    //   console.log('server error');
    // })

  }


  function insertUpdateThis(filename = '') {
    // let data = $('#employeeRegisterForm').serializeArray();
    // redata = '';
    // if (filename != '') {
    //   data.push(filename)
    // }
    // // console.log(data);
    // $.ajax({
    //   url: BASE_URL+'employee/insertUpdateEmployeePersonalDetails',
    //   method: 'post',
    //   dataType: 'json',
    //   data: data
    // }).done(function (res) {
    //   if (res.e != 0) {
    //     // formData.append('eid', res.uP);
    //     // uploadImg(formData)
    //     Swal.fire({
    //       title: res.rs + '. <br /> Do you want to go to employee profile?',
    //       icon: 'success',
    //       showDenyButton: true,
    //       showCancelButton: true,
    //       confirmButtonText: `Yes`,
    //       denyButtonText: `No`,
    //     }).then((result) => {
    //       // console.log(result);
    //       if (result.isConfirmed) {
    //         location.href = BASE_URL + 'employee/emprofile?q=' + res.uP;
    //       } else if (result.isDenied) {
    //         location.href = BASE_URL;
    //       } else {
    //         location.href = BASE_URL + 'employee/em_edit?q=' + res.uP;
    //       }
    //     })
    //   } else {
    //     Swal.fire({
    //       icon: 'warning',
    //       text: 'Employee Details is not processed. Please try again later',
    //       showConfirmButton: false,
    //       timer: 1000,
    //     })
    //   }
    // }).fail(function (xhr) {
    //   Swal.fire({
    //     icon: 'error',
    //     text: 'Server error. Please try again later',
    //     showConfirmButton: false,
    //     timer: 1000,
    //   });
    //   $('#saver').removeAttr('disabled');
    // })

  }


})

function readURL(input) {
  if (input.files && input.files[0]) {

    var reader = new FileReader();

    reader.onload = function (e) {
      $('.image-upload-wrap').hide();

      $('.file-upload-image').attr('src', e.target.result);
      $('.file-upload-content').show();

      $('.image-title').html(input.files[0].name);
    };

    reader.readAsDataURL(input.files[0]);

  } else {
    removeUpload();
  }
}



function changestate1() {

  var x = document.getElementById("StateId").value;
  $.ajax({
    url: `${BASE_URL}employee/ajaxGetDistrictsByStateId/` + x,
    method: "post",
    success: function (response) {
      let json1 = JSON.parse(response)
      var html = '<option value="">Select District </option>';
      for (i = 0; i < json1.GetDistrictsByStateId.length; i++) {

        html += '<option value =' + json1.GetDistrictsByStateId[i].Id + '>' + json1.GetDistrictsByStateId[i].Name + '</option>';
      }

      $('#DistrictId').html(html);
    }
  });

  $('#DistrictId').on('change', function (e) {
    var districtId = $(this).val();
    // alert(empid);
    $.ajax({
      url: `${BASE_URL}employee/ajaxGetMunicipalitiesByDistrictId/` + districtId,//for super agent name load through agent id
      method: 'post',
      success: function (response) {

        let json2 = JSON.parse(response)
        //  console.log(json2.GetMunicipalitiesByDistrictId);

        var html = '<option value="">Select Municipality/VDC </option>';
        for (i = 0; i < json2.GetMunicipalitiesByDistrictId.length; i++) {

          html += '<option value =' + json2.GetMunicipalitiesByDistrictId[i].Id + '>' + json2.GetMunicipalitiesByDistrictId[i].Name + '</option>';
        }

        $('#VDCMunId').html(html);
      }
    });

  });
}

function changestate2() {

  var x = $('#StateId1').val();
  console.log(x);
  $.ajax({
    url: `${BASE_URL}employee/ajaxGetDistrictsByStateId/` + x,
    method: "post",
    success: function (response) {
      let json1 = JSON.parse(response)
      var html = '<option value="">Select District </option>';
      for (i = 0; i < json1.GetDistrictsByStateId.length; i++) {

        html += '<option value =' + json1.GetDistrictsByStateId[i].Id + '>' + json1.GetDistrictsByStateId[i].Name + '</option>';
      }

      $('#DistrictId1').html(html);
    }
  });

  $('#DistrictId1').on('change', function (e) {
    var districtId = $(this).val();
    // alert(empid);
    $.ajax({
      url: `${BASE_URL}employee/ajaxGetMunicipalitiesByDistrictId/` + districtId,//for super agent name load through agent id
      method: 'post',
      success: function (response) {
        console.log(response);
        let json2 = JSON.parse(response)
        console.log(json2.GetMunicipalitiesByDistrictId);

        var html = '<option value="">Select Municipality/VDC </option>';
        for (i = 0; i < json2.GetMunicipalitiesByDistrictId.length; i++) {

          html += '<option value =' + json2.GetMunicipalitiesByDistrictId[i].Id + '>' + json2.GetMunicipalitiesByDistrictId[i].Name + '</option>';
        }

        $('#VDCMunId1').html(html);
      }
    });

  });
}

var eid = $('#customer-details input[name="eid"]').val();
// console.log(eid);
if (eid != undefined && eid != '') {
  var stateId = $('#StateId').val();
  var districtId0 = $('#districtId0').val();
  var VDCMunId0 = $('#VDCMunId0').val();

  console.log(districtId0);
  $.ajax({
    url: `${BASE_URL}employee/ajaxGetDistrictsByStateId/` + stateId,
    method: "post",
    success: function (response) {
      let json1 = JSON.parse(response)
      var html = '<option value="">Select District </option>';
      for (i = 0; i < json1.GetDistrictsByStateId.length; i++) {

        html += '<option value =' + json1.GetDistrictsByStateId[i].Id + '>' + json1.GetDistrictsByStateId[i].Name + '</option>';
      }

      // var i = $('#DistrictId').find('option[value="' + districtId0 + '"]').prop('selected', true);
      // console.log(i)
      $('#DistrictId').html(html);
      var i = $('#DistrictId').find('option[value="' + districtId0 + '"]').prop('selected', true);
      console.log(i)
    }
  });


  // var districtId = $(this).val();
  // alert(empid);
  $.ajax({
    url: `${BASE_URL}employee/ajaxGetMunicipalitiesByDistrictId/` + districtId0,//for super agent name load through agent id
    method: 'post',
    success: function (response) {

      let json2 = JSON.parse(response)
      //  console.log(json2.GetMunicipalitiesByDistrictId);

      var html = '<option value="">Select Municipality/VDC </option>';
      for (i = 0; i < json2.GetMunicipalitiesByDistrictId.length; i++) {

        html += '<option value =' + json2.GetMunicipalitiesByDistrictId[i].Id + '>' + json2.GetMunicipalitiesByDistrictId[i].Name + '</option>';
      }

      $('#VDCMunId').html(html);
      var i = $('#VDCMunId').find('option[value="' + VDCMunId0 + '"]').prop('selected', true);
      console.log(i)
    }
  });

  //For temporary

  var stateId1 = $('#StateId1').val();
  var districtId1 = $('#districtId11').val();
  var VDCMunId1 = $('#VDCMunId11').val();

  // console.log(districtId0);
  $.ajax({
    url: `${BASE_URL}employee/ajaxGetDistrictsByStateId/` + stateId1,
    method: "post",
    success: function (response) {
      let json1 = JSON.parse(response)
      var html = '<option value="">Select District </option>';
      for (i = 0; i < json1.GetDistrictsByStateId.length; i++) {

        html += '<option value =' + json1.GetDistrictsByStateId[i].Id + '>' + json1.GetDistrictsByStateId[i].Name + '</option>';
      }

      $('#DistrictId1').html(html);
      var i = $('#DistrictId1').find('option[value="' + districtId1 + '"]').prop('selected', true);
      console.log(i)
    }
  });

  $.ajax({
    url: `${BASE_URL}employee/ajaxGetMunicipalitiesByDistrictId/` + districtId1,//for super agent name load through agent id
    method: 'post',
    success: function (response) {

      let json2 = JSON.parse(response)
      //  console.log(json2.GetMunicipalitiesByDistrictId);

      var html = '<option value="">Select Municipality/VDC </option>';
      for (i = 0; i < json2.GetMunicipalitiesByDistrictId.length; i++) {

        html += '<option value =' + json2.GetMunicipalitiesByDistrictId[i].Id + '>' + json2.GetMunicipalitiesByDistrictId[i].Name + '</option>';
      }

      $('#VDCMunId1').html(html);
      var i = $('#VDCMunId1').find('option[value="' + VDCMunId1 + '"]').prop('selected', true);
      console.log(i)
    }
  });


}
$('#designationId').on('change', function (e) {
  var x = $(this).val();
  // alert(x);

  // var x = document.getElementById("designationId").value;

  if (x == 2) {
    // const sagent = document.getElementById('sagent');
    // const agent = document.getElementById('agent');
    // const customerCodeId = document.getElementById('customerCodeId');
    $('#supervisorId').find('option').not(':first').remove();
    $('#reportingManager').find('option').not(':first').remove();
    $('#sagent').hide();
    $('#agent').hide();
    // sagent.style.display = 'none';
    // agent.style.display = 'none';
    // customerCodeId.style.display = 'none';

  } else if (x == 3) {

    const sagent = document.getElementById('sagent');
    const agent = document.getElementById('agent');
    // const customerCodeId = document.getElementById('customerCodeId');
    $('#reportingManager').find('option').not(':first').remove();
    var getEmployeeId = document.getElementById('eje').value
    // console.log(getEmployeeId);
    const data = {
      getEmployeeId: getEmployeeId
    }
    $('#sagent').show();
    $('#agent').hide();
    // $('#sagent').
    // sagent.style.display = 'block';
    // agent.style.display = 'none';
    // customerCodeId.style.display = 'none';
    $.ajax({
      url: `${BASE_URL}employee/ajaxLoadSuperAgentNameById/` + 2,//for super agent
      method: 'post',
      data: data,
      // dataType: 'json',
      success: function (response) {
        var json = JSON.parse(response)
        console.log(json.EmpDetail);

        var html = '<option value="">Select Chief Marketing Officer</option>';
        for (i = 0; i < json.EmpDetail.length; i++) {

          html += '<option value =' + json.EmpDetail[i].EId + '>' + json.EmpDetail[i].EmployeeName + '</option>';
        }

        $('#supervisorId').html(html);
      }
    });

  } else {
    // alert(a);
    // const sagent = document.getElementById('sagent');
    // const agent = document.getElementById('agent');
    // const customerCodeId = document.getElementById('customerCodeId');
    $('#sagent').show();
    $('#agent').show();
    sagent.style.display = 'block';
    // agent.style.display = 'block';
    // customerCodeId.style.display = 'block';

    // const tempdata={
    //     tempdata1:tempdata1
    // }

    $('#supervisorId').find('option').not(':first').remove();
    $.ajax({
      url: `${BASE_URL}employee/ajaxLoadEmployeeName/` + 2,//for agent name load
      method: 'post',

      success: function (response) {
        console.log(response);
        let json1 = JSON.parse(response)
        console.log(json1.EmpDetail);

        var html = '<option value="">Select Chief Marketing Officer </option>';
        for (i = 0; i < json1.EmpDetail.length; i++) {

          html += '<option value =' + json1.EmpDetail[i].EId + '>' + json1.EmpDetail[i].EmployeeName + '</option>';
        }

        $('#supervisorId').html(html);
      }
    });

    $.ajax({
      url: `${BASE_URL}employee/ajaxLoadSuperAgentNameById/` + 3,//for agent name load
      method: 'post',

      success: function (response) {
        console.log(response);
        let json1 = JSON.parse(response)
        console.log(json1.EmpDetail);

        var html = '<option value="">Select Marketing Officer </option>';
        for (i = 0; i < json1.EmpDetail.length; i++) {

          html += '<option value =' + json1.EmpDetail[i].EId + '>' + json1.EmpDetail[i].EmployeeName + '</option>';
        }

        $('#reportingManager').html(html);
      }
    });

    $('#reportingManager').on('change', function (e) {
      var empid = $(this).val();
      $.ajax({
        url: `${BASE_URL}employee/ajaxLoadSuperAgentNameByAgentId/` + empid,  //for super agent name load through agent id
        method: 'post',
        success: function (response) {
          console.log(response);
          let json1 = JSON.parse(response)
          console.log(json1.EmpDetail);

          var html = '<option value="">Select Chief Marketing Officer </option>';
          for (i = 0; i < json1.EmpDetail.length; i++) {

            html += '<option value =' + json1.EmpDetail[i].EId + '>' + json1.EmpDetail[i].EmployeeName + '</option>';
          }

          $('#supervisorId').html(html);
        }
      });

    });
  }
})
  // alert('a');

