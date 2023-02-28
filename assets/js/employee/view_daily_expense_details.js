(function ($) {
    var base_url = `${BASE_URL}`;
    let viewdailyexpensesdetails = $('#viewdailyexpensesdetails').DataTable({
        columns: [
            {
                'data': '', width: "5%", render: function (row, meta, data) {
                    return data.TId;
                }
            },
            {
                'data': 'Expenses', width: "5%", render: function (row, meta, data) {
                    return data.Expenses;
                }
            },
            {
                'data': 'ExpensesDesc', width: "5%", render: function (row, meta, data) {
                    return data.ExpensesDesc;
                }
            },
            {
                'data': 'ExpensesAmount', width: "5%", render: function (row, meta, data) {
                    return data.ExpensesAmount;
                }
            },
            {
                'data': 'DiscountAmount', width: "5%", render: function (row, meta, data) {
                    return data.DiscountAmount;
                }
            },
            {
                'data': 'TotalExpenses', width: "5%", render: function (row, meta, data) {
                    return data.TotalExpenses;
                }
            },
            {
                'data': 'EntryDate', width: "5%", render: function (row, meta, data) {
                    return data.EntryDate;
                }
            },

            {
                'data': '', width: "10%", render: function (row, meta, data) {
                    option = '<a  href="' + BASE_URL + 'employee/edit_daily_expenses?&q=' + data.urlparam + '" class="btn btn-info btn-sm emp_button" target="_blank">Edit</a></td>'
                    return option;
                }
            }
        ],
        // order: [[1, 'desc'], [2, 'desc'], [0, 'desc']],
        responsive: true,
        autoWidth: false,
        pageLength: 25,
        // dom: 'Blfrtip',
        // buttons: [
        //     // {
        //     //     extend: 'excelHtml5',
        //     //     text: '<i class="fa fa-file-excel-o"></i> Excel',
        //     //     exportOptions: {
        //     //         columns: [0, 1, 2, 3]
        //     //     }
        //     // },
        //     {
        //         extend: 'csvHtml5',
        //         exportOptions: {
        //             columns: [0, 1, 2, 3]
        //         }
        //     }
        // ],

        createdRow: function (row) {
            $(row).find('.tooltip-init').tooltip();
        }
    });
    $('#saver').on('click', function (e) {
        e.preventDefault();
        var fromDate = $('input[name="fromDate"]').val();
        var toDate = $('input[name="toDate"]').val();
        var data = {
            fromDate: fromDate,
            toDate: toDate
        }
        $.ajax({
            url: base_url + 'employee/ajaxGetExpensesDetailsByDateRange',
            method: 'post',
            data: data,
            success: function (res) {
                // console.log(res);
                var json = JSON.parse(res);
                // console.log(json);
                $('.viewdailyexpenses tbody tr').remove();

                if (res.length == 0) {
                    ('#viewdailyexpensesdetails').DataTable().fnSettings().oLanguage.sEmptyTable = 'No data  available';
                    viewdailyexpensesdetails.clear().draw(false);
                }

                viewdailyexpensesdetails.clear();
                viewdailyexpensesdetails.rows.add(json).draw();
            },
            error: function (xhr) {
                $('#viewdailyexpensesdetails').dataTable().fnSettings().oLanguage.sEmptyTable = 'Something went wrong with the server !! Please try again later.';
                viewdailyexpensesdetails.clear().draw(false);
            }
        })

    })
})(jQuery);