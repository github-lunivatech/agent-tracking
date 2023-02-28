(function ($) {
  let totals = 0;
  let installmentlist = $("#installment_list").DataTable({
    responsive: true,
    autoWidth: false,
    pageLength: 25,

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
        .column(4)
        .data()
        .reduce(function (a, b) {
          return intVal(a) + intVal(b);
        }, 0);

      // Total over this page
      pageTotal = api
        .column(4, { page: "current" })
        .data()
        .reduce(function (a, b) {
          return intVal(a) + intVal(b);
        }, 0);

      // Update footer
      var x = $(api.column(5).footer()).html("Rs." + totals);
      console.log(x);
    },
    dom: "Blfrtip",
    buttons: [
      {
        extend: "excelHtml5",
        text: '<i class="fa fa-file-excel-o"></i> Excel',
        exportOptions: {
          columns: [0, 1, 2, 3, 4],
        },
        customize: function (xlsx) {
          var sheet = xlsx.xl.worksheets["sheet1.xml"];

          // Get the total for column 5
          var total = 0;
          for (var i = 0; i < sheet.rows.length; i++) {
            total += parseFloat(sheet.rows[i].cells[4].value);
          }

          // Add a custom footer for column 5
          var footerRow = sheet.rows.length + 1;
          sheet.rows[footerRow] = {
            cells: [
              { value: "" },
              { value: "" },
              { value: "" },
              { value: "Total" },
              { value: total },
            ],
          };
        },
      },
    ],

    createdRow: function (row, data, dataIndex) {
      $(row).find(".tooltip-init").tooltip();
    },
  });

  installmentlist.rows().every(function () {
    let data = this.data();
    totals += parseFloat(data[5]);
  });
})(jQuery);
