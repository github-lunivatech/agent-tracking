jQuery(function () {
    
    $('#salEmpTbl').DataTable({
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excel',
                text: 'Excel Export'
            },
            {
                extend: 'print',
                customize: function (doc) {
                    var printDoc = doc.document;

                    let data_table = printDoc.getElementsByTagName('table')[0];
                    data_table.classList.remove('collapsed');
                }
            }
        ],
        responsive: true,
        autoWidth: false,
    })

})