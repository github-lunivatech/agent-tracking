(function ($) {
  var base_url = `${BASE_URL}`;

  let customerinstallmentlist = $("#customerlist").DataTable({
    responsive: true,
    autoWidth: false,
    pageLength: 25,
    dom: "Blfrtip",
    buttons: [
      {
        extend: "excelHtml5",
        text: '<i class="fa fa-file-excel-o"></i> Excel',
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5],
        },
      },
    ],
  });
})(jQuery);
