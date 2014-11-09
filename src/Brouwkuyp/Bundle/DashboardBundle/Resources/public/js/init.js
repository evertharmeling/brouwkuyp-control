jQuery(document).ready(function() {
    chart.init();
    preFetchData.init();
    client.init();
});

var chart = {
    init: function () {
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
    }
};

var preFetchData = {
    init: function() {
        var $el = $('#graph'),
            $data = $el.data();

        $.ajax({
            url: $data.url,
            success: function(response) {
                $(response.data).each(function (key, log) {
                    var $line = -1;
                    switch (log.topic) {
                        case $data.topicHlt:
                            $line = 0;
                            break;
                        case $data.topicMlt:
                            $line = 1;
                            break;
                        case $data.topicBlt:
                            $line = 2;
                            break;
                        default:
                            break;
                    }

                    if ($line >= 0) {
                        $el.highcharts().series[$line].addPoint([log.time, parseFloat(log.value)]);
                    }
                });
            }
        });
    }
};

var client = {
    init: function () {
        var $el = $('#graph'),
            $data = $el.data(),
            $ws = new SockJS("http://" + $data.rabbitMqHost + ":15674/stomp"),
            $client = Stomp.over($ws);

        // RabbitMQ SockJS does not support heartbeats so disable them
        $client.heartbeat.incoming = 0;
        $client.heartbeat.outgoing = 0;

        $client.debug = this.onDebug;

        // Make sure the user has limited access rights
        $client.connect("guest", "guest", this.onConnect, this.onError, "/");
    },

    onConnect: function() {
        // HLT
        $client.subscribe("/topic/" + $data.topicHlt, function (d) {
            this.addToGraph($el, 0, parseFloat(d.body));
            this.updateTemperature('hlt', parseFloat(d.body))
        });
        // MLT
        $client.subscribe("/topic/" + $data.topicMlt, function (d) {
            this.addToGraph($el, 1, parseFloat(d.body));
            this.updateTemperature('mlt', parseFloat(d.body))
        });
        $client.subscribe("/topic/" + $data.topicMlt, function (d) {
            this.updateTemperature('mlt', parseFloat(d.body), 'set')
        });
        // BLT
        $client.subscribe("/topic/" + $data.topicBlt, function (d) {
            this.addToGraph($el, 2, parseFloat(d.body));
            this.updateTemperature('blt', parseFloat(d.body))
        });
    },

    onError: function(e) {
        console.log("STOMP ERROR", e);
    },

    onDebug: function(m) {
        console.log("STOMP DEBUG", m);
    },

    addToGraph: function (el, sensor, temperature) {
        var date = new Date();
        el.highcharts().series[sensor].addPoint([date.getTime(), temperature]);
    },

    updateTemperature: function (sensor, temperature, action) {
        action = typeof action !== 'undefined' ? action : 'curr';
        $('#temp-' + action + '-' + sensor).text(temperature + ' °C');
    }
};
