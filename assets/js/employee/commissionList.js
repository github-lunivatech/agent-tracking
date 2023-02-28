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
        data: "EId",
        // width: "10%",
        render: function (row, meta, data) {
          return data.EId;
        },
      },
      {
        data: "Customer",
        width: "15%",
        render: function (row, meta, data) {
          return data.Customer;
        },
      },
      {
        data: "ComPercentage",
        // width: "5%",
        render: function (row, meta, data) {
          return data.ComPercentage;
        },
      },
      {
        data: "CommissionAmount",
        // width: "5%",
        render: function (row, meta, data) {
          return data.CommissionAmount;
        },
      },

      {
        data: "PaidAMount",
        // width: "10%",
        render: function (row, meta, data) {
          return data.PaidAMount;
        },
      },

      {
        data: "Comname",
        // width: "10%",
        render: function (row, meta, data) {
          return data.Comname;
        },
      },
      {
        data: "InstallmentType",
        // width: "10%",
        render: function (row, meta, data) {
          return data.InstallmentType;
        },
      },
      {
        data: "EntryDate",
        // width: "10%",
        render: function (row, meta, data) {
          return data.EntryDate;
        },
      },
    ],
    responsive: true,
    autoWidth: false,
    pageLength: 25,
    dom: "Blfrtip",
    buttons: [
      {
        extend: "excelHtml5",
        text: '<i class="fa fa-file-excel-o"></i> Export Excel',
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5, 6, 7],
        },
      },
      {
        extend: "print",
        text: '<i class="fa fa-print"></i> Print',
        title: "",
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5, 6, 7],
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
      url: base_url + "employee/getcommissionlist",
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
