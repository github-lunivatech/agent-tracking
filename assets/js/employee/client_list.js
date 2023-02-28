(function ($) {
  var base_url = `${BASE_URL}`;
  let appTab = $(".clientlist").DataTable({
    responsive: true,
    autoWidth: false,
    pageLength: 25,
    dom: "Blfrtip",
    buttons: [
      {
        extend: "excelHtml5",
        text: '<i class="fa fa-file-excel-o"></i> Export Excel',
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5],
        },
      },
      // {
      //     extend: 'csvHtml5',
      //     exportOptions: {
      //         columns: [0, 1, 2, 3]
      //     }
      // }
    ],
  });
  let customerinstallmentlist = $(".customerinstallmentlist").DataTable({
    columns: [
      {
        data: "MId",
        width: "5%",
        render: function (row, meta, data) {
          return data.MId;
        },
      },
      {
        data: "PaidAmount",
        width: "15%",
        render: function (row, meta, data) {
          return data.PaidAmount;
        },
      },
      {
        data: "InstallmentType",
        width: "10%",
        render: function (row, meta, data) {
          return data.InstallmentType;
        },
      },
      {
        data: "Date",
        width: "10%",
        render: function (row, meta, data) {
          option = data.EntryDate;
          return option;
        },
      },
      {
        data: "Date",
        width: "10%",
        render: function (row, meta, data) {
          option =
            '<button class="btn btn-warning btn-sm mb-3 print">Print</button> ';

          return option;
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
      total = api
        .column(1)
        .data()
        .reduce(function (a, b) {
          return intVal(a) + intVal(b);
        }, 0);

      // Total over this page
      pageTotal = api
        .column(1, { page: "current" })
        .data()
        .reduce(function (a, b) {
          return intVal(a) + intVal(b);
        }, 0);

      // Update footer
      $(api.column(3).footer()).html("Total: Rs." + total);
    },
    scrollY: "200px",
    scrollCollapse: true,
    order: [
      [1, "desc"],
      [2, "desc"],
      [0, "desc"],
    ],
    responsive: true,
    autoWidth: false,
    pageLength: 25,
    dom: "Blfrtip",
    buttons: [
      //   {
      //     extend: "excelHtml5",
      //     text: '<i class="fa fa-file-excel-o"></i> Excel',
      //     exportOptions: {
      //       columns: [0, 1, 2, 3, 4, 5],
      //     },
      //   },
      // {
      //     extend: 'csvHtml5',
      //     exportOptions: {
      //         columns: [0, 1, 2, 3]
      //     }
      // }
    ],
  });

  // customerinstallmentlist

  $(".clientlist").on("click", ".add_new_installment1", function (e) {
    // $empid = $('#emp_type').val();
    var empid = $(this).data("empid");
    var encryptid = $(this).data("encrypt");
    $("#empidencrypt").val(encryptid);
    console.log(empid);
    // alert($name);
    $.ajax({
      url: base_url + "employee/ajaxGetInstallment/" + empid,
      method: "post",
      success: function (res) {
        // console.log(res);
        var json = JSON.parse(res);
        // console.log(json.length);
        $(".customerinstallmentlist tbody tr").remove();
        if (json.length == 0) {
          $(".customerinstallmentlist")
            .dataTable()
            .fnSettings().oLanguage.sEmptyTable = "No data  available";
          customerinstallmentlist.clear().draw(false);
        }

        customerinstallmentlist.clear();
        customerinstallmentlist.rows.add(json).draw();
      },
      error: function (xhr) {
        $("#empdatatable").dataTable().fnSettings().oLanguage.sEmptyTable =
          "Something went wrong with the server !! Please try again later.";
        customerinstallmentlist.clear().draw(false);
      },
    });
    $("#viewInstallmentModal").modal("show");
  });

  $(".customerinstallmentlist").on("click", ".print", function () {
    var encryptempid = $('input[name="empidencrypt"]').val();
    console.log(encryptempid);
    window.open(
      base_url + "employee/customerInstallmentPrint?q=" + encryptempid,
      "_blank",
      "resizable,scrollbars,status,height=" +
        window.outerHeight +
        "px,width=" +
        window.outerWidth +
        "px"
    );
  });

  $(".clientlist").on("click", ".add_new_installment2", function (e) {
    // $empid = $('#emp_type').val();
    var empid = $(this).data("empid");
    var encryptid = $(this).data("encrypt");
    $("#empidencrypt").val(encryptid);
    console.log(empid);
    // alert($name);
    $.ajax({
      url: base_url + "employee/ajaxGetInstallment/" + empid,
      method: "post",
      success: function (res) {
        // console.log(res);
        var json = JSON.parse(res);
        console.log(json.length);
        $(".customerinstallmentlist tbody tr").remove();
        if (json.length == 0) {
          $(".customerinstallmentlist")
            .dataTable()
            .fnSettings().oLanguage.sEmptyTable = "No data  available";
          customerinstallmentlist.clear().draw(false);
        }

        customerinstallmentlist.clear();
        customerinstallmentlist.rows.add(json).draw();
      },
      error: function (xhr) {
        $("#empdatatable").dataTable().fnSettings().oLanguage.sEmptyTable =
          "Something went wrong with the server !! Please try again later.";
        customerinstallmentlist.clear().draw(false);
      },
    });
    $("#viewInstallmentModal").modal("show");
  });
})(jQuery);
