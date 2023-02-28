(function ($) {
  var base_url = `${BASE_URL}`;
  var text = $("#maintitle").text();
  console.log(text);
  // $("#maintitle").remove();
  $(".buttons-print").on("click", function (e) {
    var text = $("#maintitle").text();
    console.log(text);
  });
  let tblBulk = $("#tblBulk").DataTable({
    columns: [
      {
        data: "EmpId",
        // width: "10%",
        render: function (row, meta, data) {
          return data.EmpId;
        },
      },
      {
        data: "EmployeeName",
        width: "35%",
        render: function (row, meta, data) {
          return data.EmployeeName;
        },
      },
      {
        data: "Commission",
        // width: "5%",
        render: function (row, meta, data) {
          return data.Commission;
        },
      },
    ],
    footer: true,
    footerCallback: function (row, data, start, end, display) {
      var api = this.api();

      // Remove the formatting to get integer data for summation
      var intVal = function (i) {
        return typeof i === "string"
          ? i.replace(/[\$,]/g, "") * 1
          : typeof i === "number"
          ? i
          : 0;
      };

      // Total over all pages
      totals = api
        .column(2)
        .data()
        .reduce(function (a, b) {
          return intVal(a) + intVal(b);
        }, 0);

      // Total over this page
      pageTotal = api
        .column(2, { page: "current" })
        .data()
        .reduce(function (a, b) {
          return intVal(a) + intVal(b);
        }, 0);

      // Update footer
      var x = $(api.column(2).footer()).html("Rs." + totals);
      console.log(x);
    },
    responsive: true,
    autoWidth: false,
    pageLength: 25,
    dom: "Blfrtip",
    buttons: [
      {
        extend: "excelHtml5",
        text: '<i class="fa fa-file-excel-o"></i> Export Excel',
        exportOptions: {
          columns: [0, 1, 2],
        },
      },
      {
        extend: "print",
        text: '<i class="fa fa-print"></i> Print',
        title: "",
        exportOptions: {
          columns: [0, 1, 2],
        },
      },
    ],
    createdRow: function (row) {
      $(row).find(".tooltip-init").tooltip();
    },
  });
  $("#searchcommission").on("click", function (e) {
    e.preventDefault();
    let fromDate = $('input[name="from"]').val();
    let toDate = $("input[name='to']").val();
    let empTypeId = $("#empTypeId option:selected").val();
    let empId = $("#empid option:selected").val();
    if (empTypeId == 1) {
      empId = 0;
      empTypeId = 0;
    }
    const data = {
      fromDate: fromDate,
      toDate: toDate,
      empTypeId: empTypeId,
      empId: empId,
    };

    console.log(data);

    // if (formvalidate()) {
    tblBulk.clear().draw(false);
    $.ajax({
      url: base_url + "employee/getcommissionsummarylist",
      data: data,
      method: "post",
      success: function (res) {
        $(".commissionlist tbody tr").remove();
        console.log(res);
        var json = JSON.parse(res);
        console.log(json);
        if (res.length == 0) {
          $("#tblBulk").dataTable().fnSettings().oLanguage.sEmptyTable =
            "No data  available";
          tblBulk.clear().draw(false);
        }
        tblBulk.clear();
        tblBulk.rows.add(json).draw();
      },
      error: function (xhr) {
        $("#tblBulk").dataTable().fnSettings().oLanguage.sEmptyTable =
          "Something went wrong with the server !! Please try again later.";
        tblBulk.clear().draw(false);
      },
    });
    // }
  });

  $("#from,#to").daterangepicker({
    singleDatePicker: true,
  });
  $("#empTypeId").on("change", function (e) {
    var empid = $(this).val();
    // console.log(empid);
    getEmployeeData(empid);
  });

  function getEmployeeData(data) {
    // $('#empdatatable').dataTable().fnSettings().oLanguage.sEmptyTable = '<img src="' +base_url + '/assests/ajax-loader/loader.gif">';
    // appTab.clear().draw(false);

    $.ajax({
      url: `${BASE_URL}employee/ajaxLoadEmployeeType/ ` + data,
      dataType: "json",
      //   data: $('#ipdsearch').serializeArray(),
      method: "post",
      success: function (res) {
        console.log(res);
        if (res.length > 0) {
          option = "<option>Select Employee Name </option>";
          for (i = 0; i < res.length; i++) {
            // console.log(res[i].EId);
            option +=
              '<option value="' +
              res[i].EId +
              '">' +
              res[i].EmployeeName +
              " </option>";
          }
          $("#empid").html(option);
        }
      },
    });
  }
})(jQuery);
