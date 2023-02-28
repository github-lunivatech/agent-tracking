(function ($) {
  var base_url = `${BASE_URL}`;
  let installmentlist = $("#installmentlist").DataTable({
    columns: [
      {
        data: "MId",
        render: function (row, meta, data) {
          return data.MId;
        },
      },
      {
        data: "EmployeeName",
        render: function (row, meta, data) {
          return data.EmployeeName;
        },
      },

      {
        data: "InstallmentType",
        render: function (row, meta, data) {
          return data.InstallmentType;
        },
      },
      {
        data: "EntryDate",
        render: function (row, meta, data) {
          return data.EntryDate;
        },
      },
      {
        data: "PaidAmount",
        render: function (row, meta, data) {
          return "Rs." + data.PaidAmount;
        },
      },

      // {
      //     'data': '', width: "%", render: function (row, meta, data) {
      //         // option = '<a  href="' + BASE_URL + 'employee/editGoodsOut?&q=' + data.urlparam + '" class="btn btn-info btn-sm emp_button" target="_blank">Edit</a></td>'
      //         // return option;
      //     }
      // }
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
        .column(4)
        .data()
        .reduce(function (a, b) {
          return intVal(a) + intVal(b);
        }, 0);
      // console.log(total);
      // Total over this page
      pageTotal = api
        .column(4, { page: "current" })
        .data()
        .reduce(function (a, b) {
          return intVal(a) + intVal(b);
        }, 0);

      // Update footer
      $(api.column(4).footer()).html("Rs." + total);
    },

    // order: [[1, 'desc'], [2, 'desc'], [0, 'desc']],
    responsive: true,
    autoWidth: false,
    pageLength: 25,
    dom: "Blfrtip",
    buttons: [
      {
        extend: "excelHtml5",
        text: '<i class="fa fa-file-excel-o"></i> Excel',
        exportOptions: {
          columns: [0, 1, 2, 3, 4],
        },
      },
      // {
      //     extend: 'csvHtml5',
      //     exportOptions: {
      //         columns: [0, 1, 2, 3]
      //     }
      // }
    ],

    createdRow: function (row) {
      $(row).find(".tooltip-init").tooltip();
    },
  });
  $("#saver").on("click", function (e) {
    e.preventDefault();
    var fromDate = $('input[name="fromDate"]').val();
    var toDate = $('input[name="toDate"]').val();
    var data = {
      fromdate: fromDate,
      toDate: toDate,
    };
    $.ajax({
      url: base_url + "employee/ajaxGetInstallmentPaymentByDaterange",
      method: "post",
      data: data,
      success: function (res) {
        // console.log(res.length);
        var json = JSON.parse(res);
        // console.log(json);
        $(".installmentlists tbody tr").remove();

        if (res.length == 0) {
          "#installmentlist".DataTable().fnSettings().oLanguage.sEmptyTable =
            "No data available";
          installmentlist.clear().draw(false);
        }

        installmentlist.clear();
        installmentlist.rows.add(json).draw();
      },
      error: function (xhr) {
        $("#installmentlist").DataTable().fnSettings().oLanguage.sEmptyTable =
          "Something went wrong with the server !! Please try again later.";
        installmentlist.clear().draw(false);
      },
    });
  });
})(jQuery);
