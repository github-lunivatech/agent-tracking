(function ($) {

    $('#fromDate, #toDate').daterangepicker({
        locale: {
            format: 'YYYY-MM-DD'
        },
        singleDatePicker: true,
        calender_style: "picker_4",
        "timePickerSeconds": true,
        // "minDate": today
    })

    var chartColors = {
        orange: '#e95926',
        yellow: '#ffd800',
        lightgreen: '#90ee90',
        blue: '#316ea2',
        darkyellow: '#9A7D0A',
        purple: 'rgb(153, 102, 255)',
        red: '#a94442',
        green: '#7baba6',
        lightred: '#EC7063',
        lightblue: '#85C1E9',
        lightorange: '#E59866',
        brown: '#9A7D0A',
        darkgreen: '#0B5345',
        offblue: '#3300FF',
        lightpurple: '#A795EF',
        lightpink: '#D476D5',
        pink: '#FF33FF',
    }
    var onlyVal = Array();
    for (const key in chartColors) {
        if (Object.hasOwnProperty.call(chartColors, key)) {
            const element = chartColors[key];
            onlyVal.push(element);
        }
    }

    // draw background
    var backgroundColor = 'white';
    Chart.plugins.register({
        beforeDraw: function (c) {
            var ctx = c.chart.ctx;
            ctx.fillStyle = backgroundColor;
            ctx.fillRect(0, 0, c.chart.width, c.chart.height);
        }
    })

    ctx = document.getElementById('salesChart').getContext('2d');
    salesGraph = new Chart(ctx);

    function plotLiner(res) {
        if (salesGraph) {
            salesGraph.destroy()
        }

        //let here
        let xDa = res.cLead,
            datasett = [],
            colorId = 0,
            convArr = [],
            achivArr = [],
            notArr = [],
            setArr = [];
        for (const k in xDa) {
            if (Object.hasOwnProperty.call(xDa, k)) {
                const ele = xDa[k];
                convArr.push(ele['Conv'].length);
                let achiver = ele['Ach'][0] != undefined ? ele['Ach'][0] : 0
                achivArr.push(achiver);

                let notter = ele['Not'][0] != undefined ? ele['Not'][0] : 0
                notArr.push(notter);

                let setter = ele['Set'][0] != undefined ? ele['Set'][0] : 0
                setArr.push(setter);
            }
        }

        let convGoal = {
            data: convArr,
            label: 'Converted',
            borderColor: onlyVal[colorId],
            backgroundColor: onlyVal[colorId++],
            fill: false,
        },
            achiveGoals = {
                data: achivArr,
                label: 'Achieved',
                borderColor: onlyVal[colorId],
                backgroundColor: onlyVal[colorId++],
                fill: false,
            },
            notAchiveGoals = {
                data: notArr,
                label: 'Not Achieved',
                borderColor: onlyVal[colorId],
                backgroundColor: onlyVal[colorId++],
                fill: false,
            },
            setGoals = {
                data: setArr,
                label: 'Set',
                borderColor: onlyVal[colorId],
                backgroundColor: onlyVal[colorId++],
                fill: false,
            }
        // colorId++;
        datasett.push(convGoal, achiveGoals, notAchiveGoals, setGoals);
        //let here

        ctx = document.getElementById('salesChart').getContext('2d');
        salesGraph = new Chart(ctx, {
            type: 'line',
            //data
            data: {
                labels: Object.keys(res.cLead),
                datasets: datasett
            },
            //data
            options: {
                elements: {
                    line: {
                        tension: 0
                    }
                },
                animation: {
                    onComplete: function () {
                        // var a = $('#tot_a').attr('href', total_chart.toBase64Image());
                    }
                },
                responsive: true,
                title: {
                    display: true,
                    text: 'Sales',
                    position: 'bottom'
                },
            }
        })

    }

    // startHere()

    async function startHere() {
        const res = await plotter();
        // if ($('#customerId').val() == 0) {
            forBar(res)
        // } else {
        //     plotLiner(res)
        // }
    }

    function plotter() {
        // let urler = ''
        // if ($('#customerId').val() == 0) {
            let urler = BASE_URL + 'crm/ajaxBarPlotter'
        // } else {
        //     urler = BASE_URL + 'crm/ploter'
        // }
        return new Promise(resolve => {
            $.ajax({
                url: urler,
                data: { pro: $('#customerId').val(), from: $('#fromDate').val(), to: $('#toDate').val() },
                method: 'post',
                dataType: 'json'
            }).done(function (res) {
                resolve(res)
            }).fail(function (res) {
                resolve(false)
            })
        })
    }

    $('#searchApp').on('submit', function (e) {
        e.preventDefault();
        startHere();
    })

    function forBar(res) {
        if (salesGraph) {
            salesGraph.destroy()
        }

        let newRes = res[0],
            newCon = res[1],
            actCon = res[2],
            lineBarr = [],
            fullDataSets = [],
            colorId = 0;

        makeTable(res)

        for (const l in actCon) {
            if (Object.hasOwnProperty.call(actCon, l)) {
                const el = actCon[l];
                lineBarr.push(el.length)
            }
        }

        fullDataSets.push({
            type: 'line',
            label: 'Actual Converted',
            data: lineBarr,
            borderColor: onlyVal[colorId],
            backgroundColor: onlyVal[colorId++],
            fill: false
        });

        for (const kk in newCon) {
            if (Object.hasOwnProperty.call(newCon, kk)) {
                const el = newCon[kk];
                let newArr = []
                el.forEach(ele => {
                    newArr.push(ele.LeadCount)
                });
                const isAllZero = el.every(item => item === 0);
                if (!isAllZero) {

                    fullDataSets.push({
                        type: 'bar',
                        label: kk,
                        backgroundColor: onlyVal[colorId++],
                        data: el,
                    })
                }

            }
        }

        ctx = document.getElementById('salesChart').getContext('2d');
        salesGraph = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: newRes,
                datasets: fullDataSets,
            },
            //options
            options: {
                //barvalue
                barValueSpacing: 20,
                responsive: true,
                //barvalue
                //scales
                scales: {
                    yAxes: [{
                        ticks: {
                            min: 0,
                        },
                        // stacked: true
                    }]
                },
                //scales
                //title
                title: {
                    display: true,
                    text: 'Sales',
                    position: 'bottom'
                },
                //title
            }
            //options
        });
    }

    function makeTable(res) {
        $('.salesTable thead, .salesTable tbody').empty();
        let newRes = res[3],
            tableHead = '',
            tH = '',
            isCreate = false
        newRes.forEach(element => {
            let tableBody = '<tr>'
            for (const k in element) {
                // const isAllZero = element.every(item => item === 0);
                // console.log(isAllZero);
                if (Object.hasOwnProperty.call(element, k)) {
                    if (!isCreate) {
                        tH += `<th>${k}</th>`;
                    }
                    const el = element[k];
                    tableBody += `<td>${el}</td>`;
                }
            }
            isCreate = true
            tableBody += '</tr>'
            tableHead += tableBody;
        });
        $('.salesTable thead').append(tH);
        $('.salesTable tbody').append(tableHead);
    }

})(jQuery)