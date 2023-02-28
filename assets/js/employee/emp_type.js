(function ($) {
  $(".createcust").on("click", function (e) {
    console.log(e);
    $("#customercreate1").modal("show");
  });

  let appTab = $("#empdatatable").DataTable({
    columns: [
      {
        data: "EmpCode",
        width: "5%",
        render: function (row, meta, data) {
          return data.EmpCode;
        },
      },
      {
        data: "EmployeeName",
        width: "5%",
        render: function (row, meta, data) {
          return data.EmployeeName;
        },
      },
      {
        data: "Total",
        width: "15%",
        render: function (row, meta, data) {
          if (
            data.Designation == "Chief Marketing Officer" ||
            data.Designation == "Marketing Officer"
          ) {
            return data.Total;
          } else {
            return data.EmployeeAddress;
          }
        },
      },
      {
        data: "EmployeeMobileNumber",
        width: "10%",
        render: function (row, meta, data) {
          return data.EmployeeMobileNumber;
        },
      },
      {
        data: "Designation",
        width: "10%",
        render: function (row, meta, data) {
          return data.Designation;
        },
      },

      {
        data: "SuperAgent",
        width: "10%",
        render: function (row, meta, data) {
          return data.SuperAgent;
        },
      },
      {
        data: "Agent",
        width: "10%",
        render: function (row, meta, data) {
          return data.Agent;
        },
      },
      {
        data: "",
        width: "10%",
        render: function (row, meta, data) {
          // option+='<a href="'+BASE_URL+'leave/leaveGroup?q='+data.urlpram+'" class="btn btn-success btn-sm emp_button">Edit</a>'
          if (
            data.Designation == "Chief Marketing Officer" ||
            data.Designation == "Marketing Officer"
          ) {
            option =
              '<a href="' +
              BASE_URL +
              "employee/emprofile?q=" +
              data.urlpram +
              '" class="btn btn-info btn-sm emp_button" target="_blank">View</a>';
            option +=
              '<a href="' +
              BASE_URL +
              "employee/getClientdetailsByEmployeeId?&q=" +
              data.urlpram +
              "&desid=" +
              data.DesignationId +
              "&name=" +
              data.EmployeeName +
              '" class="btn btn-info btn-sm emp_button" target="_blank">Client</a>';
          }
          if (data.Designation == "Customer") {
            option =
              '<a href="' +
              BASE_URL +
              "employee/getListofMonthlyInstallmentPayment?&q=" +
              data.urlpram +
              "&desid=" +
              data.DesignationId +
              "&name=" +
              data.EmployeeName +
              '" class="btn btn-primary btn-sm emp_button" target="_blank">View Installment</a>';
            option +=
              '<a  href="' +
              BASE_URL +
              "employee/installment_payment?&q=" +
              data.urlpram +
              "&desid=" +
              data.DesignationId +
              '" class="btn btn-info btn-sm emp_button" target="_blank">Create Installment</a></td>';
          }
          // option+='<a href="" class="btn btn-primary btn-sm emp_button">Payment</a>'
          return option;
        },
      },
    ],
    // order: [[4, 'desc'], [5, 'desc'], [0, 'desc']],
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
    ],
    createdRow: function (row) {
      $(row).find(".tooltip-init").tooltip();
    },
  });
  var base_url = `${BASE_URL}`;
  $("#emp_type").on("change", function (e) {
    var emp_type = $(this).val();
    getEmployeeData(emp_type);
  });

  function getEmployeeData(data) {
    // $('#empdatatable').dataTable().fnSettings().oLanguage.sEmptyTable = '<img src="' +base_url + '/assests/ajax-loader/loader.gif">';
    appTab.clear().draw(false);

    $.ajax({
      url: `${BASE_URL}employee/ajaxLoadEmployeeType/ ` + data,
      dataType: "json",
      //   data: $('#ipdsearch').serializeArray(),
      method: "post",
      success: function (res) {
        console.log(res);
        $(".emptype tbody tr").remove();
        if (res.length == 0) {
          $("#empdatatable").dataTable().fnSettings().oLanguage.sEmptyTable =
            "No data  available";
          appTab.clear().draw(false);
        }

        appTab.clear();
        appTab.rows.add(res).draw();
      },
      error: function (xhr) {
        $("#empdatatable").dataTable().fnSettings().oLanguage.sEmptyTable =
          "Something went wrong with the server !! Please try again later.";
        appTab.clear().draw(false);
      },
    });
  }
  //   var name = $("#customername").text();
  //   console.log(name);
  //   var customerinstallmentslist = $(".customerinstallmentslist").DataTable({
  //     columns: [
  //       {
  //         data: "MId",
  //         width: "5%",
  //         render: function (row, meta, data) {
  //           return data.MId;
  //         },
  //       },
  //       {
  //         data: "PaidAmount",
  //         width: "15%",
  //         render: function (row, meta, data) {
  //           return "Rs." + data.PaidAmount;
  //         },
  //       },
  //       {
  //         data: "InstallmentType",
  //         width: "10%",
  //         render: function (row, meta, data) {
  //           return data.InstallmentType;
  //         },
  //       },
  //       {
  //         data: "Date",
  //         width: "10%",
  //         render: function (row, meta, data) {
  //           option = data.EntryDate;
  //           return option;
  //         },
  //       },
  //       {
  //         data: "Date",
  //         width: "10%",
  //         render: function (row, meta, data) {
  //           option =
  //             '<button class="btn btn-warning btn-sm mb-3 print">Print</button> ';

  //           return option;
  //         },
  //       },
  //     ],
  //     footer: true,
  //     footerCallback: function (row, data, start, end, display) {
  //       var api = this.api();

  //       // Remove the formatting to get integer data for summation
  //       var intVal = function (i) {
  //         return typeof i === "string"
  //           ? i.replace(/[\$,]/g, "") * 1
  //           : typeof i === "number"
  //           ? i
  //           : 0;
  //       };

  //       // Total over all pages
  //       total = api
  //         .column(1)
  //         .data()
  //         .reduce(function (a, b) {
  //           return intVal(a) + intVal(b);
  //         }, 0);

  //       // Total over this page
  //       pageTotal = api
  //         .column(1, { page: "current" })
  //         .data()
  //         .reduce(function (a, b) {
  //           return intVal(a) + intVal(b);
  //         }, 0);

  //       // Update footer
  //       $(api.column(3).footer()).html("Total: Rs." + total);
  //     },
  //     scrollY: "200px",
  //     scrollCollapse: true,
  //     orientation: "landscape",
  //     lengthChange: false,
  //     order: [
  //       [1, "desc"],
  //       [2, "desc"],
  //       [0, "desc"],
  //     ],
  //     responsive: true,
  //     autoWidth: false,
  //     // pageLength: 25,
  //     dom: "Blfrtip",
  //     buttons: [
  //       {
  //         extend: "excelHtml5",
  //         text: '<i class="fa fa-file-excel-o"></i> Excel',
  //         filename: name,
  //         exportOptions: {
  //           columns: [0, 1, 2, 3],
  //         },
  //       },
  //     ],
  //   });
  //   $(".emptype").on("click", ".emp_button", function (e) {
  //     var empid = $(this).data("empid");
  //     var empname = $(this).data("empname");
  //     $("#customername").text(empname);
  //     // console.log(empid);

  //     $.ajax({
  //       url: base_url + "employee/ajaxGetInstallment/" + empid,
  //       method: "post",
  //       success: function (res) {
  //         var json = JSON.parse(res);
  //         // console.log(json.length);
  //         $(".customerinstallmentlist tbody tr").remove();
  //         if (res.length == 0) {
  //           $(".customerinstallmentslist")
  //             .dataTable()
  //             .fnSettings().oLanguage.sEmptyTable = "No data  available";
  //           customerinstallmentslist.clear().draw(false);
  //         }

  //         customerinstallmentslist.clear();
  //         customerinstallmentslist.rows.add(json).draw();
  //       },
  //       error: function (xhr) {
  //         $("#empdatatable").dataTable().fnSettings().oLanguage.sEmptyTable =
  //           "Something went wrong with the server !! Please try again later.";
  //         // customerinstallmentlist.clear().draw(false);
  //       },
  //     });
  //     $("#viewInstalllistmentModal").modal("show");
  //   });
})(jQuery);
function exportData() {
  /* Get the HTML data using Element by Id */
  var table = document.getElementById("empdatatable");

  /* Declaring array variable */
  var rows = [];

  //iterate through rows of table
  for (var i = 0, row; (row = table.rows[i]); i++) {
    //rows would be accessed using the "row" variable assigned in the for loop
    //Get each cell value/column from the row
    // if (row.cell[0].innerText == "" && row.cell[0].innerText == null) {
    //     alert('Could Not Print the empty cell')
    // }
    column1 = row.cells[0].innerText;
    column2 = row.cells[1].innerText;
    column3 = row.cells[2].innerText;
    column4 = row.cells[3].innerText;
    column5 = row.cells[4].innerText;
    column6 = row.cells[5].innerText;

    /* add a new records in the array */
    rows.push([column1, column2, column3, column4, column5, column6]);
  }
  csvContent = "data:text/csv;charset=utf-8,";
  /* add the column delimiter as comma(,) and each row splitted by new line character (\n) */
  rows.forEach(function (rowArray) {
    row = rowArray.join(",");
    csvContent += row + "\r\n";
  });

  /* create a hidden <a> DOM node and set its download attribute */
  var encodedUri = encodeURI(csvContent);
  var link = document.createElement("a");
  link.setAttribute("href", encodedUri);
  link.setAttribute("download", "SmartAbhiyan.csv");
  document.body.appendChild(link);
  /* download the data file named "Stock_Price_Report.csv" */
  link.click();
}
