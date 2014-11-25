/*----------------------------------------------------------------------------*\
 $CONSOLE
 Prevents error when console methods are not available
 Reference: paulirish.com/2009/log-a-lightweight-wrapper-for-consolelog/
 \*----------------------------------------------------------------------------*/

(function() {
    var method;
    var noop = function noop() {};
    var methods = [
        'assert', 'clear', 'count', 'debug', 'dir', 'dirxml', 'error',
        'exception', 'group', 'groupCollapsed', 'groupEnd', 'info', 'log',
        'markTimeline', 'profile', 'profileEnd', 'table', 'time', 'timeEnd',
        'timeStamp', 'trace', 'warn'
    ];
    var length = methods.length;
    var console = (window.console = window.console || {});

    while (length--) {
        method = methods[length];

        // Only stub undefined methods.
        if (!console[method]) {
            console[method] = noop;
        }
    }
}());

$(document).ready(function(){
    chart.init();
    client.init();
    pumpSwitches.init();
});

var chart = {
    init: function () {
        var $el = $('#graph'),
            $data = $el.data();

        var $hltLogs = [],
            $mltLogs = [],
            $bltLogs = [];

        $.ajax({
            url: $data.url,
            async: false,
            success: function(response) {
                $(response.data).each(function (key, log) {
                    var $value = parseFloat(log.value);

                    switch (log.topic) {
                        case $data.topicHltCurr:
                            $hltLogs[$hltLogs.length] = [log.time, $value];
                            break;
                        case $data.topicMltCurr:
                            $mltLogs[$mltLogs.length] = [log.time, $value];
                            break;
                        case $data.topicBltCurr:
                            $bltLogs[$bltLogs.length] = [log.time, $value];
                            break;
                        default:
                            break;
                    }
                });

                $el.highcharts('StockChart', {
                    rangeSelector: {
                        inputEnabled: false,
                        buttons: [
                            {
                                type: 'minute',
                                count: 5,
                                text: '5m'
                            },
                            {
                                type: 'minute',
                                count: 30,
                                text: '30m'
                            },
                            {
                                type: 'hour',
                                count: 1,
                                text: '1h'
                            },
                            {
                                type: 'all',
                                text: 'all'
                            }
                        ]
                    },
                    title: {
                        text: 'Live temperaturen'
                    },
                    xAxis: {
                        type: 'time'
                    },
                    yAxis: {
                        title: {
                            text: 'Temperatuur °C'
                        },
                        plotLines: [{
                            value: 64,
                            dashStyle: 'shortdash',
                            width: 2,
                            color: '#088A68',
                            label: {
                                text: 'Alpha amylase'
                            }
                        }, {
                            value: 72,
                            dashStyle: 'shortdash',
                            width: 2,
                            color: '#088A68',
                            label: {
                                text: 'Beta amylase'
                            }
                        }, {
                            value: 78,
                            dashStyle: 'shortdash',
                            width: 2,
                            color: '#808080',
                            label: {
                                text: 'Stop'
                            }
                        }]
                    },
                    tooltip: {
                        formatter: function() {
                            return 'Tijd: ' + Highcharts.dateFormat('%H:%M:%S', this.x) +'<br/>'+
                            'Temp: ' + Highcharts.numberFormat(this.y, 2) + '°C';
                        }
                    },
                    legend: {
                        enabled: true
                    },
                    exporting: {
                        enabled: false
                    },
                    global: {
                        useUTC: false
                    },
                    series: [
                        {
                            name: 'HLT',
                            data: $hltLogs
                        },
                        {
                            name: 'MLT',
                            data: $mltLogs
                        },
                        {
                            name: 'BLT',
                            data: $bltLogs
                        }
                    ]
                });
            }
        });
    }
};

var client = {
    init: function () {
        var $el = $('#graph'),
            $data = $el.data(),
            $client = Stomp.over(new SockJS("http://" + $data.rabbitMqHost + ":15674/stomp"));

        // RabbitMQ SockJS does not support heartbeats so disable them
        $client.heartbeat.incoming = 0;
        $client.heartbeat.outgoing = 0;

        $client.debug = this.onDebug;

        // Make sure the user has limited access rights
        $client.connect("guest", "guest", onConnect, this.onError, "/");

        function onConnect() {
            $data = $el.data();

            // HLT
            $client.subscribe("/topic/" + $data.topicHltCurr, function (d) {
                var $value = parseFloat(d.body);
                addToGraph($el, 0, $value);
                updateTemperature('hlt', $value);
            });
            // MLT
            $client.subscribe("/topic/" + $data.topicMltCurr, function (d) {
                var $value = parseFloat(d.body);
                addToGraph($el, 1, $value);
                updateTemperature('mlt', $value);
            });
            $client.subscribe("/topic/" + $data.topicMltSet, function (d) {
                var $value = parseFloat(d.body);
                updateTemperature('mlt', $value, 'set');
                // @todo store set temps and be able to add plotBands (maisch steps)
            });
            // BLT
            $client.subscribe("/topic/" + $data.topicBltCurr, function (d) {
                var $value = parseFloat(d.body);
                addToGraph($el, 2, $value);
                updateTemperature('blt', $value);
            });
            // PUMP
            $client.subscribe("/topic/" + $data.topicPumpCurrMode, function (d) {
                var $value = (d.body == 'automatic');
                updatePumpMode($value);
            });
            $client.subscribe("/topic/" + $data.topicPumpCurrState, function (d) {
                var $value = (d.body == 'true');
                updatePumpState($value);
            });
        }

        function addToGraph($el, $sensor, $temperature) {
            var date = new Date();
            $el.highcharts().series[$sensor].addPoint([date.getTime(), $temperature]);
        }

        function updateTemperature($sensor, $temperature, $action) {
            $action = typeof $action !== 'undefined' ? $action : 'curr';
            $('#temp-' + $action + '-' + $sensor).text($temperature + ' °C');
        }

        function updatePumpMode($state) {
            var $el = $('#pump_automatic');
            if ($state) {
                $el.prop('checked', true);
            } else {
                $el.prop('checked', false);
            }
        }

        function updatePumpState($state) {
            $el = $('#pump');
            if ($state) {
                $el.prop('checked', true);
            } else {
                $el.prop('checked', false);
            }
        }
    },

    onError: function(e) {
        console.log("STOMP ERROR", e);
    },

    onDebug: function(m) {
        //console.log("STOMP DEBUG", m);
    }
};

var pumpSwitches = {
    init: function () {
        var $pumpAutomatic = $('#pump_automatic'),
            $pump = $('#pump'),
            $pumpData = $pump.data();

        $pumpAutomatic.on('click', function(e) {
            $('.toggle-pump').toggle();
            if ($pumpAutomatic.is(':checked')) {
                $.post(
                    $pumpData.url,
                    {
                        'pump_state': 'automatic'
                    },
                    function(response) {
                        //console.log(response);
                    }
                );
            }
        });

        $pump.on('click', function(e) {
            $.post(
                $pumpData.url,
                {
                    'pump_state': $pump.is(':checked')
                },
                function(response) {
                    //console.log(response);
                }
            );
        });
    }
};
