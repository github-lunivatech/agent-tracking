(function ($) {
  var base_url = `${BASE_URL}`;
  let inventoryGoodsOutList = $("#inventoryGoodsOutList").DataTable({
    columns: [
      {
        data: "OId",
        width: "5%",
        render: function (row, meta, data) {
          return data.OId;
        },
      },
      {
        data: "ProductName",
        width: "5%",
        render: function (row, meta, data) {
          return data.ProductName;
        },
      },
      {
        data: "GoodsOutQuantity",
        width: "5%",
        render: function (row, meta, data) {
          return data.GoodsOutQuantity;
        },
      },
      {
        data: "GoodsInDate",
        width: "15%",
        render: function (row, meta, data) {
          return data.GoodsOutDate;
        },
      },
      {
        data: "VerifiedBy",
        width: "10%",
        render: function (row, meta, data) {
          return data.ReceivedBy;
        },
      },

      {
        data: "",
        width: "10%",
        render: function (row, meta, data) {
          option =
            '<a  href="' +
            BASE_URL +
            "employee/editGoodsOut?&q=" +
            data.urlparam +
            '" class="btn btn-info btn-sm emp_button" target="_blank">Edit</a></td>';
          return option;
        },
      },
    ],
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
          columns: [0, 1, 2, 3, 4, 5, 6],
        },
      },
      {
        extend: "csvHtml5",
        exportOptions: {
          columns: [0, 1, 2, 3],
        },
      },
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
      url: base_url + "employee/ajaxGetInventoryGoodsOutbyDaterange",
      method: "post",
      data: data,
      success: function (res) {
        // console.log(res);
        var json = JSON.parse(res);
        // console.log(json);
        $(".goodsInList tbody tr").remove();

        if (res.length == 0) {
          "#inventoryGoodsOutList"
            .DataTable()
            .fnSettings().oLanguage.sEmptyTable = "No data  available";
          inventoryGoodsOutList.clear().draw(false);
        }

        inventoryGoodsOutList.clear();
        inventoryGoodsOutList.rows.add(json).draw();
      },
      error: function (xhr) {
        $("#inventoryGoodsInList")
          .dataTable()
          .fnSettings().oLanguage.sEmptyTable =
          "Something went wrong with the server !! Please try again later.";
        inventoryGoodsOutList.clear().draw(false);
      },
    });
  });
})(jQuery);
