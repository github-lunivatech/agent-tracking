jQuery(function () {
  let dashboard_e = document.getElementById("app-main");
  let loaderElem = ecrm.loaderElement;

  let filtType = $("#custId option:selected").text();
  let fromDate = $("#fromDate").val();
  let toDate = $("#toDate").val();
  let filtName = $("#filName").val();

  $("#fromDate, #toDate").daterangepicker({
    locale: {
      format: "YYYY-MM-DD",
    },
    singleDatePicker: true,
    calender_style: "picker_4",
    timePickerSeconds: true,
  });

  $("#ider, #custId").select2({});

  let table = $("#salEmpTbl").DataTable({
    dom: "Bfrtip",
    buttons: [
      {
        extend: "excel",
        text: "Excel Export",
      },
      {
        extend: "print",
        customize: function (doc) {
          let printDoc = doc.document;
          let cssStyle = document.createElement("style");
          cssStyle.innerHTML = `
                    @page{size:A4 landscape;}
                    table{font-size: 12px}
                    body{background:none}
                    table.dataTable thead tr th:last-child,table.dataTable tbody tr td:last-child
                    {display:none;}
                    `;
          printDoc.getElementsByTagName("head")[0].appendChild(cssStyle);

          let heading = printDoc.querySelector("h1");
          heading.innerHTML = "Complain Track Report";
          heading.style.textAlign = "center";

          let cmpAddress2_ = document.createElement("div");

          let cmpAddress_ = document.createElement("span");
          cmpAddress_.style.textAlign = "left";
          cmpAddress_.innerText = `From Date: ${fromDate}- To Date: ${toDate}`;

          let cmpAddress1_ = document.createElement("span");
          cmpAddress1_.style.float = "right";
          cmpAddress1_.innerText = `${filtType}: ${filtName}`;

          cmpAddress2_.append(cmpAddress_);
          cmpAddress2_.append(cmpAddress1_);
          heading.after(cmpAddress2_);

          let data_table = printDoc.getElementsByTagName("table")[0];
          data_table.classList.remove("collapsed");
        },
      },
    ],
    responsive: true,
    autoWidth: false,
  });

  $(".add_com").on("click", function (e) {
    let da = this.dataset;
    $("#comp_stat_id").val(da.stid);
    $("#comp_stat_comment").val(da.stat);
    // $('#remarks_comment').val(da.rem)
    $("#add_comment").modal("show");
  });

  $("#complainForm").on("submit", async function (e) {
    e.preventDefault();
    $("#post").attr("disabled", true);
    const res = await complainSubmit();
    if (res) {
      if (res.coid > 0) {
        swaler("success", "Complain Status Changed", false);
        setTimeout(() => {
          location.reload();
        }, 500);
      } else {
        swaler("warning", "Complain Status Not Changed");
      }
    } else {
      swaler("error", "Something went wrong");
    }
  });

  function swaler(iconer = "error", texter = "", disabler = true) {
    Swal.fire({
      icon: iconer,
      text: texter,
      showConfirmButton: false,
      timer: 1000,
    });
    if (disabler) $("#post").removeAttr("disabled");
  }

  function complainSubmit() {
    return new Promise((resolve) => {
      $.ajax({
        url: BASE_URL + "complain/ajaxUpdateComplainStatus",
        method: "post",
        data: $("#complainForm").serializeArray(),
        dataType: "json",
      })
        .done(function (res) {
          resolve(res);
        })
        .fail(function (res) {
          resolve(false);
        });
    });
  }

  $("#custId").on("change", function (e) {
    showOptions(this.value);
  });

  showOptions($("#custId").val());

  $("#ider").on("change", function (e) {
    $("#filName").val(this.options[this.selectedIndex].text);
  });

  async function showOptions(value) {
    //loader start
    dashboard_e.prepend(loaderElem);
    $(".search_btn").attr("disabled", true);

    $("#ider").empty();
    let options = '<option value="0">All</option>';
    if (value == "status") {
      const stat = await getStatus();
      stat.forEach((ele) => {
        options += `<option value="${ele.CSId}">${ele.ChangeStatus}</option>`;
      });
    } else if (value == "employee") {
      const stat = await getEmployee();
      stat.forEach((ele) => {
        options += `<option value="${ele.EId}">${ele.EmployeeName}</option>`;
      });
    } else if (value == "customer") {
      const stat = await getCustomer();
      stat.forEach((ele) => {
        options += `<option value="${ele.CId}">${ele.CustomerName}</option>`;
      });
    } else if (value == "projectname") {
      const stat = await getProject();
      stat.forEach((ele) => {
        options += `<option value="${ele.PId}">${ele.ProductName}</option>`;
      });
    } else if (value == "complainid") {
      const stat = await getComplainType();
      stat.forEach((ele) => {
        options += `<option value="${ele.CId}">${ele.ComplainTitle}</option>`;
      });
    }
    $("#ider").append(options);

    $("#ider").val($("#huders").val());
    //loader remove
    loaderElem.remove();
    $(".search_btn").removeAttr("disabled");
  }

  function ajaxPriority() {
    return new Promise((resolve) => {
      $.ajax({
        url: BASE_URL + "complain/ajaxPriority",
        data: "",
        method: "post",
        dataType: "json",
      })
        .done(function (res) {
          resolve(res);
        })
        .fail(function (res) {
          resolve(false);
        });
    });
  }

  function getStatus() {
    return new Promise((resolve) => {
      $.ajax({
        url: BASE_URL + "complain/ajaxChangeStat",
        data: "",
        method: "post",
        dataType: "json",
      })
        .done(function (res) {
          resolve(res);
        })
        .fail(function (res) {
          resolve(false);
        });
    });
  }

  function getEmployee() {
    return new Promise((resolve) => {
      $.ajax({
        url: BASE_URL + "complain/ajaxGetEmployee",
        data: "",
        method: "post",
        dataType: "json",
      })
        .done(function (res) {
          resolve(res);
        })
        .fail(function (res) {
          resolve(false);
        });
    });
  }

  function getCustomer() {
    return new Promise((resolve) => {
      $.ajax({
        url: BASE_URL + "complain/ajaxGetCustomerDetails",
        data: "",
        method: "post",
        dataType: "json",
      })
        .done(function (res) {
          resolve(res);
        })
        .fail(function (res) {
          resolve(false);
        });
    });
  }

  function getProject() {
    return new Promise((resolve) => {
      $.ajax({
        url: BASE_URL + "complain/ajaxProducts",
        data: "",
        method: "post",
        dataType: "json",
      })
        .done(function (res) {
          resolve(res);
        })
        .fail(function (res) {
          resolve(false);
        });
    });
  }

  function getComplainType() {
    return new Promise((resolve) => {
      $.ajax({
        url: BASE_URL + "complain/ajaxGetComType",
        data: "",
        method: "post",
        dataType: "json",
      })
        .done(function (res) {
          resolve(res);
        })
        .fail(function (res) {
          resolve(false);
        });
    });
  }

  // tblStatFilter
  // on load load this
  plotFilter();
  async function plotFilter() {
    $("#tblAllPatientTypesFilter").empty();
    $("#tblStatFilter").empty();

    let options = '<option value="">All</option>',
        options2 = '<option value="">All</option>';

    const prio = await ajaxPriority();
    const stat = await getStatus();

    prio.forEach((ele) => {
      options2 += `<option value="${ele.PriorityDetails}">${ele.PriorityDetails}</option>`;
    });

    $("#tblAllPatientTypesFilter").append(options2);

    stat.forEach((ele) => {
      options += `<option value="${ele.ChangeStatus}">${ele.ChangeStatus}</option>`;
    });

    $("#tblStatFilter").append(options);
  }

  //for priority
  var patientTypeFilter = $("#tblAllPatientTypesFilter");
  patientTypeFilter.on("change", function () {
    table.columns(3).search(this.value).draw();
  });

  if (patientTypeFilter != "") patientTypeFilter.trigger("change");
  //for priority
  //for status
  var tblStatFilter = $("#tblStatFilter");
  tblStatFilter.on("change", function () {
    table.columns(5).search(this.value).draw();
  });

  if (tblStatFilter != "") tblStatFilter.trigger("change");
  //for status
});
