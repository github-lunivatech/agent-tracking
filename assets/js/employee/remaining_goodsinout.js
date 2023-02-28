(function ($) {
  var base_url = `${BASE_URL}`;
  let remaininggoodsinout = $("#remaininggoodsinout").DataTable({
    columns: [
      {
        data: "ItemId",
        width: "5%",
        render: function (row, meta, data) {
          return data.ItemId;
        },
      },
      {
        data: "ItemName",
        width: "5%",
        render: function (row, meta, data) {
          return data.ItemName;
        },
      },
      {
        data: "GoodsIn",
        width: "5%",
        render: function (row, meta, data) {
          return data.GoodsIn;
        },
      },
      {
        data: "GoodsOut",
        width: "15%",
        render: function (row, meta, data) {
          return data.GoodsOut;
        },
      },
      {
        data: "Remaining",
        width: "10%",
        render: function (row, meta, data) {
          return data.Remaining;
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
  console.log("s");
  $("#saver").on("click", function (e) {
    e.preventDefault();
    var fromDate = $('input[name="fromDate"]').val();
    var toDate = $('input[name="toDate"]').val();
    var data = {
      fromdate: fromDate,
      toDate: toDate,
    };
    $.ajax({
      url: base_url + "employee/ajaxGetRemainingGoodsInOut",
      method: "post",
      data: data,
      success: function (res) {
        // console.log(res);
        var json = JSON.parse(res);
        console.log(json);
        $(".goodsInOutList tbody tr").remove();
        if (res.length == 0) {
          "#remaininggoodsinout"
            .DataTable()
            .fnSettings().oLanguage.sEmptyTable = "No data  available";
          remaininggoodsinout.clear().draw(false);
        }

        remaininggoodsinout.clear();
        remaininggoodsinout.rows.add(json).draw();
      },
      error: function (xhr) {
        $("#remaininggoodsinout")
          .dataTable()
          .fnSettings().oLanguage.sEmptyTable =
          "Something went wrong with the server !! Please try again later.";
        inventoryGoodsInList.clear().draw(false);
      },
    });
  });
})(jQuery);
