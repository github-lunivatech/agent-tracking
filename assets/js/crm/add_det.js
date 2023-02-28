let stat = $('#cust_state'),
    dis = $('#cust_district'),
    mun = $('#cust_municipality'),
    cdis = $('#cdis'),
    cmun = $('#cmun');

changeHandler()

async function changeHandler(callDis = true) {
    mun.empty()
    if (callDis) {
        dis.empty()
        const res = await getDisList(stat.val());
        res.forEach(ele => {
            let isSel = '';
            if(cdis.val() == ele.Id) isSel = 'selected';
            dis.append(`<option ${isSel} value="${ele.Id}">${ele.Name}</option>`);
        });
    }
    const muna = await getMunList(dis.val());
    muna.forEach(ele => {
        let isSel = '';
        if(cmun.val() == ele.Id) isSel = 'selected';
        mun.append(`<option ${isSel} value="${ele.Id}">${ele.Name}</option>`);
    });
}

stat.on('change', function (e) {
    changeHandler();
})

dis.on('change', function (e) {
    changeHandler(false);
})

function getDisList(dist = 1) {
    return new Promise(resolve => {
        $.ajax({
            url: `${BASE_URL}crm/ajaxGetDistrict`,
            method: 'post',
            data: { dist: dist },
            dataType: 'json'
        }).done(function (res) {
            resolve(res)
        }).fail(function (res) {
            resolve(false)
        })
    })
}

function getMunList(muni = 1) {
    return new Promise(resolve => {
        $.ajax({
            url: `${BASE_URL}crm/ajaxGetMun`,
            method: 'post',
            data: { muni: muni },
            dataType: 'json'
        }).done(function (res) {
            resolve(res)
        }).fail(function (res) {
            resolve(false)
        })
    })
}