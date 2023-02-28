jQuery(function () {
    sn = 1;
    let viewMaxTestEdit = $('.viewMaxTestEdit').DataTable({
        columns: [
            { 'data': '', render: (row) => {
                return sn++
            }},
            { 'data': 'UserRight' },
            { 'data': 'RightDescription' },
            {
                'data': 'RId', render: (row, meta, data) => {
                    return `<button class="btn btn-primary btn-sm editTestCount">Edit</button>`
                }
            },
        ]
    })

    plotRole()

    async function plotRole() {

        const res = await getListRoles()
        if (res && res.length != 0) {
            sn = 1;
            viewMaxTestEdit.rows.add(res).draw()
        }
    }

    function getListRoles() {
        return new Promise(resolve => {
            $.ajax({
                url: `${BASE_URL}/user/ajaxGetListRights`,
                method: 'post',
                dataType: 'json',
                data: ''
            }).done(function (res) {
                resolve(res)
            }).fail(function (res) {
                resolve(false)
            })
        })
    }

    $('body').on('click', '.editTestCount', function (e) {
        e.preventDefault();
        var data = viewMaxTestEdit.row($(this).parents('tr')).data();
        $('#roid').val(data.RId)
        $('#user_right').val(data.UserRight)
        $('#right_description').val(data.RightDescription)
        document.getElementById('saver').innerText = 'Update'
        window.scrollTo({ top: 0, behavior: 'smooth' });
    })

    $('#resetter').on('click', function(e){
        $('#roid').val('')
        document.getElementById('saver').innerText = 'Save'
    })

    $('#addRightsDetForm').on('submit', (e) => {
        $('#saver').attr('disabled', true)
    })

})