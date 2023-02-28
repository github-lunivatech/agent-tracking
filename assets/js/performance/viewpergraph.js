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

    $('#searchApp').on('submit', function (e) {
        e.preventDefault();
        herePlot();
    })

    async function herePlot() {
        let newArr = [];
        const res = await plot()
        forBar(res)
        // for (const k in res) {
        //     if (Object.hasOwnProperty.call(res, k)) {
        //         const el = res[k][0];
        //         newArr.push(k);
        //     }
        // }
    }

    function plot() {
        return new Promise(resolve => {
            $.ajax({
                url: BASE_URL + 'performance/ajaxReview',
                data: { jobId: $('#customerId').val(), from: $('#fromDate').val(), to: $('#toDate').val() },
                method: 'post',
                dataType: 'json'
            }).done(function (res) {
                resolve(res)
            }).fail(function (res) {
                resolve(false)
            })
        })
    }

    function forBar(res) {
        if (salesGraph) {
            salesGraph.destroy()
        }

        let fullDataSets = [],
            labell = [],
            colorId = 0,
            newRes = res[0],
            newRess = res[1],
            labells = Object.keys(newRes);

            for (const k in newRess) {
                if (Object.hasOwnProperty.call(newRess, k)) {
                    const el = newRess[k];
                    console.log(el);
                    fullDataSets.push({
                        label: k,
                        data: el[0],
                        borderColor: onlyVal[colorId],
                        backgroundColor: onlyVal[colorId++],
                        fill: false
                    })
                    
                }
            }

        // for (const k in newRes) {
        //     if (Object.hasOwnProperty.call(newRes, k)) {
        //         const ele = newRes[k];
        //         labell.push(ele)
        //         // console.log(ele);
        //         // fullDataSets.push({
        //         //     // type: 'line',
        //         //     label: k,
        //         //     data: ele,
        //         //     borderColor: onlyVal[colorId],
        //         //     backgroundColor: onlyVal[colorId++],
        //         //     fill: false
        //         // });
        //     }
        // }

        // console.log(labell);

        ctx = document.getElementById('salesChart').getContext('2d');
        salesGraph = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labells,
                datasets: fullDataSets,
            },
            //options
            options: {
                elements: {
                    line: {
                        tension: 0
                    }
                },
                //barvalue
                // barValueSpacing: 20,
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

})(jQuery)