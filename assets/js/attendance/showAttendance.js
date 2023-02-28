var input = document.getElementById('input')
input.addEventListener('change', async function () {

    if (getExtension(input.files[0].name) == 'xlsx') {
        console.log('loading');
        const rows = await viewDynamic();
        if (rows.length > 0) {
            let the = '';
            rows[0].forEach(el => {
                the += '<th>' + el + '</th>'
            });
            $('#attendanceTbl thead').html(the)

            $('#attendanceTbl tbody').html('')
            for (let i = 0; i < rows.length; i++) {
                if (i != 0) {
                    let curObject = rows[i];
                    let tbo = '<tr>';

                    curObject.forEach(ele => {
                        tbo += '<td>' + ele + '</td>';
                    });

                    tbo += '</tr>';
                    $('#attendanceTbl tbody').append(tbo)
                }
            }
        }
        console.log('loaded');
    } else {
        toastr.warning('Only file with .xlxs can be viewed. Other excels file can still be uploaded')
    }

})

function viewDynamic() {
    return new Promise(resolve => {
        readXlsxFile(input.files[0]).then(function (rows) {
            // `rows` is an array of rows
            // each row being an array of cells.
            resolve(rows)
        })
    })
}

function getExtension(filename) {
    var parts = filename.split('.');
    return parts[parts.length - 1];
}