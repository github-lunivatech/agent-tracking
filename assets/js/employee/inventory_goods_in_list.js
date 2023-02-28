(function ($) {
  var base_url = `${BASE_URL}`;
  let inventoryGoodsInList = $("#inventoryGoodsInList").DataTable({
    columns: [
      {
        data: "",
        width: "5%",
        render: function (row, meta, data) {
          return data.GId;
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
        data: "Quantity",
        width: "5%",
        render: function (row, meta, data) {
          return data.Quantity;
        },
      },
      {
        data: "GoodsInDate",
        width: "15%",
        render: function (row, meta, data) {
          return data.GoodsInDate;
        },
      },
      {
        data: "VerifiedBy",
        width: "10%",
        render: function (row, meta, data) {
          return data.VerifiedBy;
        },
      },

      {
        data: "",
        width: "10%",
        render: function (row, meta, data) {
          option =
            '<a  href="' +
            BASE_URL +
            "employee/editGoodsIn?&q=" +
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
      url: base_url + "employee/ajaxGetInventoryGoodsInbyDaterange",
      method: "post",
      data: data,
      success: function (res) {
        // console.log(res);
        var json = JSON.parse(res);
        console.log(json);
        $(".goodsInList tbody tr").remove();
        if (res.length == 0) {
          "#inventoryGoodsInList"
            .DataTable()
            .fnSettings().oLanguage.sEmptyTable = "No data  available";
          inventoryGoodsInList.clear().draw(false);
        }

        inventoryGoodsInList.clear();
        inventoryGoodsInList.rows.add(json).draw();
      },
      error: function (xhr) {
        $("#inventoryGoodsInList")
          .dataTable()
          .fnSettings().oLanguage.sEmptyTable =
          "Something went wrong with the server !! Please try again later.";
        inventoryGoodsInList.clear().draw(false);
      },
    });
  });
})(jQuery);
