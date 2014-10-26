
$(document).ready(function() {
    var ws = new SockJS("http://192.168.2.132:15674/stomp");
    var client = Stomp.over(ws);

    // RabbitMQ SockJS does not support heartbeats so disable them
    client.heartbeat.incoming = 0;
    client.heartbeat.outgoing = 0;

    client.debug = onDebug;

    // Make sure the user has limited access rights
    client.connect("guest", "guest", onConnect, onError, "/");

    Highcharts.setOptions({
        global: {
            useUTC: false
        }
    });

    $('#graph').highcharts({
        chart: {
            type: 'spline',
            animation: Highcharts.svg, // don't animate in old IE
            marginRight: 10
        },
        title: {
            text: 'Live temperatures'
        },
        xAxis: {
            type: 'datetime'
        },
        yAxis: {
            title: {
                text: 'Temperature °C'
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        tooltip: {
            formatter: function() {
                return '<b>'+ this.series.name +'</b><br/>'+
                'Time: ' + Highcharts.dateFormat('%H:%M:%S', this.x) +'<br/>'+
                'Temp: ' + Highcharts.numberFormat(this.y, 2) + '°C';
            }
        },
        legend: {
            enabled: false
        },
        exporting: {
            enabled: false
        },
        series: [
            {
                name: 'HLT',
                data: []
            },
            {
                name: 'MLT',
                data: []
            },
            {
                name: 'BLT',
                data: []
            }
        ]
    });

    function onConnect() {
        var hlt = client.subscribe("/topic/brewery.brewhouse01.masher.hlt.curr_temp", function (d) {
            addToGraph(0, parseFloat(d.body));
        });
        var mlt = client.subscribe("/topic/brewery.brewhouse01.masher.mlt.curr_temp", function (d) {
            addToGraph(1, parseFloat(d.body));
        });
        var blt = client.subscribe("/topic/brewery.brewhouse01.masher.blt.curr_temp", function (d) {
            addToGraph(2, parseFloat(d.body));
        });
    }

    function onError(e) {
        console.log("STOMP ERROR", e);
    }

    function onDebug(m) {
        //console.log("STOMP DEBUG", m);
    }

    function addToGraph(serie, temp) {
        var date = new Date();
        var time = date.getTime();
        $('#graph').highcharts().series[serie].addPoint([time, temp]);
    }
});
