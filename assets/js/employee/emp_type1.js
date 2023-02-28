
(function ($) {
  $('.createcust').on('click', function (e) {
    console.log(e);
    //initialize here as it is dynamic
    // $('#ef').val('');
    // $('#qualification').val('')
    // $('#institution').val('')
    // $('#eduStartDate').val('')
    // $('#eduCompleteDate').val('')
    // initEduDate()
    //initialize here as it is dynamic

    $('#customercreate1').modal('show');
  })

  let appTab = $('#empdatatable').DataTable({
    columns: [
      {
        'data': 'EmployeeName', width: "5%", render: function (row, meta, data) {
          return data.EmployeeName;
        }
      },
      {
        'data': 'EmployeeAddress', width: "15%", render: function (row, meta, data) {
          return data.EmployeeAddress;
        }
      },
      {
        'data': 'EmployeeMobileNumber', width: "10%", render: function (row, meta, data) {
          return data.EmployeeMobileNumber;
        }
      },
      {
        'data': 'Designation', width: "10%", render: function (row, meta, data) {
          return data.Designation;
        }
      },

      {
        'data': 'SuperAgent', width: "10%", render: function (row, meta, data) {

          return data.SuperAgent;

        }
      },
      {
        'data': 'Agent', width: "10%", render: function (row, meta, data) {
          return data.Agent;
        }
      },
      {
        'data': '', width: "10%", render: function (row, meta, data) {
          option = '<a href="' + BASE_URL + 'employee/emprofile?q=' + data.urlpram + '" class="btn btn-info btn-sm emp_button">View</a>'
          // option+='<a href="'+BASE_URL+'leave/leaveGroup?q='+data.urlpram+'" class="btn btn-success btn-sm emp_button">Edit</a>'
          if (data.Designation == 'Chief Marketing Officer' || data.Designation == 'Marketing Officer') {
            option += '<a href="' + BASE_URL + 'employee/getClientdetailsByEmployeeId?&q=' + data.urlpram + '&desid=' + data.DesignationId + '" class="btn btn-info btn-sm emp_button">Client</a>'
          }
          if (data.Designation == 'Customer') {

            option += '<a  href="' + BASE_URL + 'employee/installment_payment?&q=' + data.urlpram + '&desid=' + data.DesignationId + '" class="btn btn-info btn-sm emp_button">Create Installment</a></td>'

          }
          // option+='<a href="" class="btn btn-primary btn-sm emp_button">Payment</a>' 
          return option;
        }
      },
    ],
    order: [[4, 'desc'], [5, 'desc'], [0, 'desc']],
    responsive: true,
    autoWidth: false,
    pageLength: 25,
    dom: 'Blfrtip',
    buttons: [
      {
        extend: 'excelHtml5',
        text: '<i class="fa fa-file-excel-o"></i> Excel',
        exportOptions: {
          columns: [0, 1, 2, 3, 4, 5, 6]
        }
      },
      {
        extend: 'csvHtml5',
        exportOptions: {
          columns: [0, 1, 2, 3]
        }
      }
    ],

    // createdRow: function (row) {
    //   $(row).find('.tooltip-init').tooltip();
    // }

  });
  var base_url = `${BASE_URL}`;
  $('#emp_type').on('change', function (e) {
    var emp_type = $(this).val();
    getEmployeeData(emp_type);
  })

  function getEmployeeData(data) {
    // $('#empdatatable').dataTable().fnSettings().oLanguage.sEmptyTable = '<img src="' +base_url + '/assests/ajax-loader/loader.gif">';
    appTab.clear().draw(false);

    $.ajax({
      url: `${BASE_URL}employee/ajaxLoadEmployeeType/ ` + data,
      dataType: 'json',
      //   data: $('#ipdsearch').serializeArray(),
      method: 'post',
      success: function (res) {
        console.log(res);
        $('.emptype tbody tr').remove();
        if (res.length == 0) {

          $('#empdatatable').dataTable().fnSettings().oLanguage.sEmptyTable = 'No data  available';
          appTab.clear().draw(false);
        }

        appTab.clear();
        appTab.rows.add(res).draw();
      },
      error: function (xhr) {
        $('#empdatatable').dataTable().fnSettings().oLanguage.sEmptyTable = 'Something went wrong with the server !! Please try again later.';
        appTab.clear().draw(false);
      }
    });
  }


})(jQuery)