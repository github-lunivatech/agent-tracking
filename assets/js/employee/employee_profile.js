(function ($) {
  let today = new Date();
  var dashboard_e = document.getElementById("app-main");
  var loaderElem = ecrm.loaderElement;

  //images
  $("#add_image_button").on("click", function (e) {
    e.preventDefault();
    $(".file-upload-input").click();
  });

  $("body").on("click", "#remove_image_button", function (e) {
    e.preventDefault();
    removeUpload();
  });

  function removeUpload() {
    $(".file-upload-input").replaceWith($(".file-upload-input").clone());
    $(".file-upload-input").val("");
    $(".file-upload-content").hide();
    $(".image-upload-wrap").show();
  }
  $(".image-upload-wrap").bind("dragover", function () {
    $(".image-upload-wrap").addClass("image-dropping");
  });
  $(".image-upload-wrap").bind("dragleave", function () {
    $(".image-upload-wrap").removeClass("image-dropping");
  });
  //images

  //document upload
  // $('#doc_upload').on('submit',function(e){
  //     e.preventDefault();
  //     // console.log($(this).serializeArray());
  //     $.ajax({
  //         //url: BASE_URL+'employee/insertUpdateEmployeeDocument',
  //         // data: data,
  //         method: 'post'
  //     }).done(function(res) {
  //         console.log(res);
  //     }).fail(function(xhr){

  //     })
  // })

  //add edit education here
  $(".add_new_edu").on("click", function (e) {
    //initialize here as it is dynamic
    $("#ef").val("");
    $("#qualification").val("");
    $("#institution").val("");
    $("#eduStartDate").val("");
    $("#eduCompleteDate").val("");
    initEduDate();
    //initialize here as it is dynamic
    $("#educationModal").modal("show");
  });
  $(".edit_edu").on("click", function (e) {
    let jData = JSON.parse(this.dataset.json);
    //initialize here as it is dynamic
    $("#ef").val("");
    //initialize here as it is dynamic
    $("#qualification").val(jData[2]);
    $("#institution").val(jData[3]);
    $("#eduStartDate").val(jData[4].split("T")[0]);
    $("#eduCompleteDate").val(jData[5].split("T")[0]);
    $("#ef").val(jData.allP);
    initEduDate();
    $("#educationModal").modal("show");
  });

  function initEduDate() {
    $("#eduStartDate,#eduCompleteDate").daterangepicker({
      locale: {
        format: "YYYY-MM-DD",
      },
      singleDatePicker: true,
      calender_style: "picker_4",
      timePickerSeconds: true,
    });
  }
  // educationModal
  //add edit education here

  //addressModal

  $(".add_new_addre").on("click", function (e) {
    //initialize here as it is dynamic
    $("#ef").val("");
    $("#qualification").val("");
    $("#institution").val("");
    $("#eduStartDate").val("");
    $("#eduCompleteDate").val("");
    initEduDate();
    //initialize here as it is dynamic
    $("#addressModal").modal("show");
  });

  $(".edit_addre").on("click", function (e) {
    let jData = JSON.parse(this.dataset.json);
    //initialize here as it is dynamic
    // console.log(jData);
    $('input[name="ef"]').val(jData[0]);
    //initialize here as it is dynamic
    $("#AddressType").val(jData[1]);
    $("#StateId").val(jData[4]);
    $("#DistrictId").val(jData[5]);
    $("#VDCMunId").val(jData[6]);
    $("#LocalAddress").val(jData[7]);

    $("#PostalCode").val(jData[8]);
    $("#ef").val(jData.allP);
    // initEduDate()
    $.ajax({
      url: `${BASE_URL}employee/ajaxGetDistrictsByStateId/` + jData[4],
      method: "post",
      success: function (response) {
        let json1 = JSON.parse(response);
        var html = '<option value="">Select District </option>';
        for (i = 0; i < json1.GetDistrictsByStateId.length; i++) {
          html +=
            "<option value =" +
            json1.GetDistrictsByStateId[i].Id +
            ">" +
            json1.GetDistrictsByStateId[i].Name +
            "</option>";
        }

        $("#DistrictId").html(html);
        $("#DistrictId")
          .find('option[value="' + jData[5] + '"]')
          .prop("selected", true);
      },
    });
    // alert(empid);
    $.ajax({
      url: `${BASE_URL}employee/ajaxGetMunicipalitiesByDistrictId/` + jData[5], //for super agent name load through agent id
      method: "post",
      success: function (response) {
        console.log(response);
        let json2 = JSON.parse(response);
        console.log(json2.GetMunicipalitiesByDistrictId);

        var html = '<option value="">Select Municipality/VDC </option>';
        for (i = 0; i < json2.GetMunicipalitiesByDistrictId.length; i++) {
          html +=
            "<option value =" +
            json2.GetMunicipalitiesByDistrictId[i].Id +
            ">" +
            json2.GetMunicipalitiesByDistrictId[i].Name +
            "</option>";
        }

        $("#VDCMunId").html(html);
        $("#VDCMunId")
          .find('option[value="' + jData[6] + '"]')
          .prop("selected", true);
      },
    });

    $("#addressModal").modal("show");
  });

  //getdistrictthroughstate;
  $("#StateId").on("change", function (e) {
    let stateId = $(this).val();
    alert(stateId);
  });

  //add edit experice
  $(".add_new_exp").on("click", function (e) {
    //initialize here as it is dynamic
    //initialize here as it is dynamic
    $("#skills").val("");
    $("#experiences").val("");
    $("#exf").val("");
    $("#experienceModal").modal("show");
  });

  $(".edit_exp").on("click", function (e) {
    let jData = JSON.parse(this.dataset.json);
    $("#skills").val(jData[2]);
    $("#experiences").val(jData[3]);
    $("#exf").val(jData["allP"]);
    $("#experienceModal").modal("show");
  });

  //add edit experice

  //add edit refrences
  $(".add_new_ref").on("click", function (e) {
    $("#rname").val("");
    $("#relation").val("");
    $("#homePhone").val("");
    $("#mobilePhone").val("");
    $("#officePhone").val("");
    $("#Designation").val("");
    $("#ecf").val("");
    $("#refModal").modal("show");
  });
  $(".edit_ref").on("click", function (e) {
    let jData = JSON.parse(this.dataset.json);
    $("#rname").val(jData[2]);
    $("#relation").val(jData[3]);
    $("#homePhone").val(jData[4]);
    $("#mobilePhone").val(jData[5]);
    $("#officePhone").val(jData[6]);
    $("#Designation").val(jData[7]);
    $("#ecf").val(jData["allP"]);
    $("#refModal").modal("show");
  });
  //refrences

  //jobs
  $(".add_new_job").on("click", function (e) {
    $("#companyId").val("");
    $("#departmentId").val("");
    $("#designationId").val("");
    $("#position").val("");
    $("#supervisorId").val("");
    $("#reportingManager").val("");
    $("#basicSalary").val("");
    $("input[name=isactive][value='1']").prop("checked", true);
    $("#ejf").val("");
    $("#jobModal").modal("show");
  });

  $(".designation_edit").on("click", function (e) {
    let jData = JSON.parse(this.dataset.json);
    // console.log(jData);
    $("#companyId").val(jData[2]);
    $("#departmentId").val(jData[3]);
    $("#designationId").val(jData[4]);
    $("#position").val(jData[5]);
    $("#supervisorId").val(jData[6]);
    $("#reportingManager").val(jData[7]);
    $("#basicSalary").val(jData[8]);
    if (jData[10] == true) {
      $("input[name=isactive][value='1']").prop("checked", true);
    } else {
      $("input[name=isactive][value='0']").prop("checked", true);
    }
    $("#yearDetails").val(jData[12]);
    // $('#levelDetails').val();
    $("#levelDetails")
      .find('option[value="' + jData[13] + '"]')
      .prop("selected", true);
    $("#ejf").val(jData["allP"]);
    if (jData[4] == 6) {
      $("#customerCodeId").show();
      $("#sagent").show();
      $("#agent").show();
      $.ajax({
        url: `${BASE_URL}employee/ajaxLoadSuperAgentNameById/` + 3, //for agent name load
        method: "post",
        success: function (response) {
          // console.log(response);
          let json1 = JSON.parse(response);
          // console.log(json1.EmpDetail);

          var html = '<option value="">Select Marketing Officer </option>';
          for (i = 0; i < json1.EmpDetail.length; i++) {
            html +=
              "<option value =" +
              json1.EmpDetail[i].EId +
              ">" +
              json1.EmpDetail[i].EmployeeName +
              "</option>";
          }
          $("#reportingManager").html(html);
          $("#reportingManager")
            .find('option[value="' + jData[7] + '"]')
            .prop("selected", true);
        },
      });

      $.ajax({
        url: `${BASE_URL}employee/ajaxLoadSuperAgentNameById/` + 2, //for super agent name load through agent id
        method: "post",
        success: function (response) {
          // console.log(response);
          let json1 = JSON.parse(response);
          // console.log(json1.EmpDetail, "Saurey");

          var html =
            '<option value="">Select Chief Marketing Officer  </option>';
          for (i = 0; i < json1.EmpDetail.length; i++) {
            html +=
              "<option value =" +
              json1.EmpDetail[i].EId +
              ">" +
              json1.EmpDetail[i].EmployeeName +
              "</option>";
          }
          $("#supervisorId").html(html);
          $("#supervisorId")
            .find('option[value="' + jData[6] + '"]')
            .prop("selected", true);
        },
      });
    } else if (jData[4] == 3) {
      // $('#agent').hide();
      $("#sagent").show();
      $.ajax({
        url: `${BASE_URL}employee/ajaxLoadSuperAgentNameById/` + 2, //for super agent name load through designation id
        method: "post",
        success: function (response) {
          // console.log(response);let json1 = JSON.parse(response)

          var html =
            '<option value="">Select Chief Marketing Officer </option>';
          for (i = 0; i < json1.EmpDetail.length; i++) {
            html +=
              "<option value =" +
              json1.EmpDetail[i].EId +
              ">" +
              json1.EmpDetail[i].EmployeeName +
              "</option>";
          }
          $("#supervisorId").html(html);
          $("#supervisorId")
            .find('option[value="' + jData[6] + '"]')
            .prop("selected", true);
        },
      });
    } else {
      $("#sagent").hide();
      $("#agent").hide();
    }
    $("#reportingManager").on("change", function (e) {
      var agnetId = $(this).val();
      $.ajax({
        url: `${BASE_URL}employee/ajaxLoadSuperAgentNameByAgentId/` + agnetId, //for super agent name load through agent id
        method: "post",
        success: function (response) {
          // console.log(response);
          let json1 = JSON.parse(response);
          //    console.log(json1.EmpDetail,"Saurey");

          var html =
            '<option value="">Select Chief Marketing Officer </option>';
          for (i = 0; i < json1.EmpDetail.length; i++) {
            html +=
              "<option value =" +
              json1.EmpDetail[i].EId +
              ">" +
              json1.EmpDetail[i].EmployeeName +
              "</option>";
          }
          $("#supervisorId").html(html);
          $("#supervisorId")
            .find('option[value="' + jData[6] + '"]')
            .prop("selected", true);
        },
      });
    });
    $("#jobModal").modal("show");
  });

  // change in agent
  // $('#designationId').on('change', function(e){
  //    let color = $(this).find("option:selected");
  //    console.log(color);
  //  });

  //upload documents
  $(".upload_doc").on("click", function (e) {
    $("#documentModal").modal("show");
  });

  $("body").on("submit", "#documentForm", function (e) {
    e.preventDefault();
    $("#saveDocBtn").attr("disabled", true);
    dashboard_e.prepend(loaderElem);
    let formData = new FormData(this);
    let fullData = $(this).serializeArray();

    let did = $("#did").val();
    let dimg = $("#document_attachment").val();

    formData.append(
      "document_attachment",
      $("#document_attachment")[0].files[0]
    );
    // formData.append('did', 1);
    // formData.append('doc_name', $('#doc_name').val())

    if (did != "") {
      uploadDoc(formData, did);
    } else {
      if (dimg == "") {
        submitDocPath(dimg, formData);
      } else {
        submitDocPath(dimg, formData, false);
      }
    }
  });

  function uploadDoc(formData, did = "") {
    formData.append("did", did);
    $.ajax({
      url: BASE_URL + "employee/AjaxUploadDocument",
      data: formData,
      method: "post",
      dataType: "json",
      processData: false,
      contentType: false,
    })
      .done(function (res) {
        if (res.filename) {
          did = {
            name: "did",
            value: did,
          };
          submitDocPath(res, formData, true, did);
        } else {
          $("#saveDocBtn").removeAttr("disabled");
          loaderElem.remove();
        }
      })
      .fail(function (xhr) {
        $("#saveDocBtn").removeAttr("disabled");
        loaderElem.remove();
      });
  }

  function submitDocPath(fpath = "", formData, isJusIns = true, did = "") {
    let data = $("#documentForm").serializeArray();
    if (did != "") {
      data.push(did);
    }

    if (fpath != "") {
      data.push({
        name: "document_attachment",
        value: fpath["filename"],
      });
    }
    $.ajax({
      url: BASE_URL + "employee/insertUpdateEmployeeDocument",
      data: data,
      method: "post",
      dataType: "json",
    })
      .done(function (res) {
        if (res.e > 0) {
          if (isJusIns == false) {
            uploadDoc(formData, res.did);
          } else {
            location.reload();
          }
        }
      })
      .fail(function (xhr) {
        loaderElem.remove();
      });
  }

  //bank details
  $(".add_new_bak").on("click", function (e) {
    $("#bank_name").val("");
    $("#bank_branch").val("");
    $("#bank_account_no").val("");
    $("#bankModal").modal("show");
  });

  $("body").on("click", ".edit_bankdet", function (e) {
    $("#bbi").val("");

    let dataJson = JSON.parse(this.dataset.json);

    $("#bbi").val(dataJson["allP"]);
    $("#bank_name").val(dataJson[2]);
    $("#bank_branch").val(dataJson[3]);
    $("#bank_account_no").val(dataJson[4]);

    if (dataJson[7] == true) {
      $("#bank_isactive").prop("checked", true);
    } else {
      $("#bank_isactive").prop("checked", false);
    }

    $("#bankModal").modal("show");
  });
  //bank details

  //salary lookup details
  const ALLDA = $("#allValDa").val();
  $(".add_new_sal").on("click", async function (e) {
    $("#marital_stat").val("");
    $("#basic_salary").val("");
    $("#festival_bonus").val("");
    $("#allowance").val("");
    $("#others").val("");
    $("#provident_fund").val("");
    $("#citizen_investment").val("");
    $("#insurance").val("");
    $("#other_fund").val("");
    $("#tds").val("");
    $("#total_payable").val("");

    $("#salModal").modal("show");
    //add new call here
    const res = await loadAutoNewSalary(ALLDA);
    if (res && res.length > 0) {
      $("#basic_salary").val(res[0].BasicSalary);
      $("#festival_bonus").val(res[0].FestivalBonus);
      $("#allowance").val(res[0].Allowance);
      $("#others").val(res[0].Others);
      $("#provident_fund").val(res[0].ProvidentFund);
      $("#citizen_investment").val(res[0].CitizenInvestmentTrust);
      $("#insurance").val(res[0].Insurane);
      $("#other_fund").val(res[0].OtherFund);
      $("#tds").val(res[0].TDS);
      $("#total_payable").val(res[0].TotalPayable);
    }
  });

  $("body").on("click", ".edit_saldet", function (e) {
    $("#ssbi").val("");

    let dataJson = JSON.parse(this.dataset.json);

    $("#ssbi").val(dataJson["allP"]);

    if (dataJson[2] == 2) {
      $('input[name="marital_stat"][value=2]').prop("checked", true);
    } else {
      $('input[name="marital_stat"][value=1]').prop("checked", true);
    }

    $("#basic_salary").val(dataJson[3]);
    $("#festival_bonus").val(dataJson[4]);
    $("#allowance").val(dataJson[5]);
    $("#others").val(dataJson[6]);
    $("#provident_fund").val(dataJson[7]);
    $("#citizen_investment").val(dataJson[8]);
    $("#insurance").val(dataJson[9]);
    $("#other_fund").val(dataJson[10]);
    $("#tds").val(dataJson[11]);
    $("#total_payable").val(dataJson[12]);

    if (dataJson[15] == true) {
      $("#sal_isactive").prop("checked", true);
    } else {
      $("#sal_isactive").prop("checked", false);
    }

    $("#salModal").modal("show");
  });
  //salary lookup details

  function loadAutoNewSalary(ALLDA = "") {
    const spData = ALLDA.split("|");
    const newData = {
      dep: spData[0],
      des: spData[1],
      lev: spData[2],
      yea: spData[3],
    };
    return new Promise((resolve) => {
      $.ajax({
        url: `${BASE_URL}employee/ajaxAutoLoadSalary`,
        data: newData,
        dataType: "json",
        method: "post",
      })
        .done((res) => resolve(res))
        .fail((res) => resolve(false));
    });
  }
})(jQuery);

function readURL(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function (e) {
      $(".image-upload-wrap").hide();

      $(".file-upload-image").attr("src", e.target.result);
      $(".file-upload-content").show();

      $(".image-title").html(input.files[0].name);
    };

    reader.readAsDataURL(input.files[0]);
  } else {
    removeUpload();
  }
}
// change in agent
function changevalue() {
  // alert('a');
  var x = document.getElementById("designationId").value;
  if (x == 2) {
    const sagent = document.getElementById("sagent");
    const agent = document.getElementById("agent");
    const customerCodeId = document.getElementById("customerCodeId");
    $("#supervisorId").find("option").not(":first").remove();
    $("#reportingManager").find("option").not(":first").remove();
    sagent.style.display = "none";
    agent.style.display = "none";
    customerCodeId.style.display = "none";
    $("#supervisorId").removeAttr("required");
  } else if (x == 3) {
    const sagent = document.getElementById("sagent");
    const agent = document.getElementById("agent");
    const customerCodeId = document.getElementById("customerCodeId");
    $("#reportingManager").find("option").not(":first").remove();
    var getEmployeeId = document.getElementById("eje").value;
    console.log(getEmployeeId);
    const data = {
      getEmployeeId: getEmployeeId,
    };
    sagent.style.display = "block";
    agent.style.display = "none";
    customerCodeId.style.display = "none";
    $.ajax({
      url: `${BASE_URL}employee/ajaxLoadSuperAgentNameById/` + 2, //for super agent
      method: "post",
      data: data,
      // dataType: 'json',
      success: function (response) {
        var json = JSON.parse(response);
        console.log(json.EmpDetail);

        var html = '<option value="">Select Chief Marketing Officer</option>';
        for (i = 0; i < json.EmpDetail.length; i++) {
          html +=
            "<option value =" +
            json.EmpDetail[i].EId +
            ">" +
            json.EmpDetail[i].EmployeeName +
            "</option>";
        }

        $("#supervisorId").html(html);
      },
    });
  } else {
    // alert(a);
    const sagent = document.getElementById("sagent");
    const agent = document.getElementById("agent");
    const customerCodeId = document.getElementById("customerCodeId");

    sagent.style.display = "block";
    agent.style.display = "block";
    customerCodeId.style.display = "block";

    // const tempdata={
    //     tempdata1:tempdata1
    // }

    $("#supervisorId").find("option").not(":first").remove();
    $.ajax({
      url: `${BASE_URL}employee/ajaxLoadEmployeeName/` + 2, //for agent name load
      method: "post",

      success: function (response) {
        console.log(response);
        let json1 = JSON.parse(response);
        console.log(json1.EmpDetail);

        var html = '<option value="">Select Chief Marketing Officer </option>';
        for (i = 0; i < json1.EmpDetail.length; i++) {
          html +=
            "<option value =" +
            json1.EmpDetail[i].EId +
            ">" +
            json1.EmpDetail[i].EmployeeName +
            "</option>";
        }

        $("#supervisorId").html(html);
      },
    });

    $.ajax({
      url: `${BASE_URL}employee/ajaxLoadSuperAgentNameById/` + 3, //for agent name load
      method: "post",

      success: function (response) {
        console.log(response);
        let json1 = JSON.parse(response);
        console.log(json1.EmpDetail);

        var html = '<option value="">Select Marketing Officer </option>';
        for (i = 0; i < json1.EmpDetail.length; i++) {
          html +=
            "<option value =" +
            json1.EmpDetail[i].EId +
            ">" +
            json1.EmpDetail[i].EmployeeName +
            "</option>";
        }

        $("#reportingManager").html(html);
      },
    });

    $("#reportingManager").on("change", function (e) {
      var empid = $(this).val();
      $.ajax({
        url: `${BASE_URL}employee/ajaxLoadSuperAgentNameByAgentId/` + empid, //for super agent name load through agent id
        method: "post",
        success: function (response) {
          console.log(response);
          let json1 = JSON.parse(response);
          console.log(json1.EmpDetail);

          var html =
            '<option value="">Select Chief Marketing Officer </option>';
          for (i = 0; i < json1.EmpDetail.length; i++) {
            html +=
              "<option value =" +
              json1.EmpDetail[i].EId +
              ">" +
              json1.EmpDetail[i].EmployeeName +
              "</option>";
          }

          $("#supervisorId").html(html);
        },
      });
    });
  }
}

function changestate() {
  var x = document.getElementById("StateId").value;
  $.ajax({
    url: `${BASE_URL}employee/ajaxGetDistrictsByStateId/` + x,
    method: "post",
    success: function (response) {
      let json1 = JSON.parse(response);
      var html = '<option value="">Select District </option>';
      for (i = 0; i < json1.GetDistrictsByStateId.length; i++) {
        html +=
          "<option value =" +
          json1.GetDistrictsByStateId[i].Id +
          ">" +
          json1.GetDistrictsByStateId[i].Name +
          "</option>";
      }

      $("#DistrictId").html(html);
    },
  });

  $("#DistrictId").on("change", function (e) {
    var districtId = $(this).val();
    // alert(empid);
    $.ajax({
      url:
        `${BASE_URL}employee/ajaxGetMunicipalitiesByDistrictId/` + districtId, //for super agent name load through agent id
      method: "post",
      success: function (response) {
        console.log(response);
        let json2 = JSON.parse(response);
        console.log(json2.GetMunicipalitiesByDistrictId);

        var html = '<option value="">Select Municipality/VDC </option>';
        for (i = 0; i < json2.GetMunicipalitiesByDistrictId.length; i++) {
          html +=
            "<option value =" +
            json2.GetMunicipalitiesByDistrictId[i].Id +
            ">" +
            json2.GetMunicipalitiesByDistrictId[i].Name +
            "</option>";
        }

        $("#VDCMunId").html(html);
      },
    });
  });
}
