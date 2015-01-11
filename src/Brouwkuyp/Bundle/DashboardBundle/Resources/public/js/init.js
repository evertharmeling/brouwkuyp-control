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
            $bltLogs = [],
            $verticalLines = [];

        $.ajax({
            url: $data.urlLogs,
            async: false,
            success: function(response) {
                $(response.data).each(function (key, log) {
                    var $value = parseFloat(log.value);

                    if (!isNaN($value)) {
                        switch (log.topic) {
                            case $data.topicHltCurrTemp:
                                $hltLogs[$hltLogs.length] = [log.time, $value];
                                break;
                            case $data.topicMltCurrTemp:
                                $mltLogs[$mltLogs.length] = [log.time, $value];
                                break;
                            case $data.topicBltCurrTemp:
                                $bltLogs[$bltLogs.length] = [log.time, $value];
                                break;
                            default:
                                break;
                        }
                    }

                    if (log.type == 'pump' && new RegExp('[a-z\\.]+(set_state|set_mode)').test(log.topic)) {
                        $verticalLines.push({
                            value: log.time,
                            width: 1,
                            color: 'red',
                            dashStyle: 'dash',
                            label: {
                                text: log.topic + ' : ' + log.value
                            }
                        });
                    } else if(log.type == 's88' && new RegExp('[a-z]+\\.[a-z]+').test(log.topic)) {
                        $verticalLines.push({
                            value: log.time,
                            width: 1,
                            color: 'purple',
                            dashStyle: 'dash',
                            label: {
                                text: log.topic
                            }
                        });
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
                        type: 'time',
                        plotLines: $verticalLines
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
                                text: 'Beta amylase'
                            }
                        }, {
                            value: 72,
                            dashStyle: 'shortdash',
                            width: 2,
                            color: '#088A68',
                            label: {
                                text: 'Alpha amylase'
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
                        useUTC: false,
                        timezoneOffset: 60
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
            $data = $el.data();

        if ($data.rabbitMqHost) {

            $client = Stomp.over(new SockJS("http://" + $data.rabbitMqHost + ":15674/stomp"));

            // RabbitMQ SockJS does not support heartbeats so disable them
            $client.heartbeat.incoming = 0;
            $client.heartbeat.outgoing = 0;

            $client.debug = this.onDebug;

            // Make sure the user has limited access rights
            $client.connect("guest", "guest", onConnect, this.onError, "/");

            function onConnect() {
                $data = $el.data();
                var $baseUrl = "/topic/";

                // HLT
                $client.subscribe($baseUrl + $data.topicHltCurrTemp, function (d) {
                    var $value = parseFloat(d.body);
                    addToGraph($el, 0, $value);
                    updateTemperature('hlt', $value);
                });

                // MLT
                $client.subscribe($baseUrl + $data.topicMltCurrTemp, function (d) {
                    var $value = parseFloat(d.body);
                    addToGraph($el, 1, $value);
                    updateTemperature('mlt', $value);
                });
                $client.subscribe($baseUrl + $data.topicMltSetTemp, function (d) {
                    var $value = parseFloat(d.body);
                    updateTemperature('mlt', $value, 'set');
                    // @todo store set temps and be able to add plotBands (maisch steps)
                });

                // BLT
                $client.subscribe($baseUrl + $data.topicBltCurrTemp, function (d) {
                    var $value = parseFloat(d.body);
                    addToGraph($el, 2, $value);
                    updateTemperature('blt', $value);
                });

                // PUMP
                $client.subscribe($baseUrl + $data.topicPumpCurrMode, function (d) {
                    if (d.body == 'automatic') {
                        toggleCheckbox($('#pump_mode'), true);
                        $('.toggle-pump').hide();
                    } else {
                        toggleCheckbox($('#pump_mode'), false);
                        $('.toggle-pump').show();
                    }
                });
                $client.subscribe($baseUrl + $data.topicPumpCurrState, function (d) {
                    toggleCheckbox($('#pump_state'), (d.body == 'on'));
                });

                // BROADCASTING
                $client.subscribe($baseUrl + $data.topicBroadcastDialog, function (d) {
                    message = JSON.parse(d.body);
                    bootbox.dialog({
                        title: message.title,
                        message: message.text,
                        buttons: {
                            cancel: {
                                label: "Cancel",
                                className: "btn-cancel",
                                callback: function (result) {
                                    // @todo fix message.identifier, message keeps being overwritten when prompting multiple dialogs
                                    $.post(
                                        $data.urlLog,
                                        {'log': {'topic': message.identifier, 'value': 'cancelled'}},
                                        function (response) {
                                            //console.log(response);
                                        }
                                    );
                                }
                            },
                            confirm: {
                                label: "Confirm",
                                className: "btn-success",
                                data: message,
                                callback: function (result) {
                                    // @todo fix message.identifier, message keeps being overwritten when prompting multiple dialogs
                                    $.post(
                                        $data.urlLog,
                                        {'log': {'topic': message.identifier, 'value': 'confirmed'}},
                                        function (response) {
                                            //console.log(response);
                                        }
                                    );
                                }
                            }
                        }
                    });
                });
                $client.subscribe($baseUrl + $data.topicBroadcastLog, function (d) {
                    $('#log-list').prepend('<li><span>' + d.body + '</span></li>');
                });
            }
        }

        function addToGraph($el, $sensor, $temperature) {
            var date = new Date();
            $el.highcharts().series[$sensor].addPoint([date.getTime(), $temperature]);
        }

        function updateTemperature($sensor, $temperature, $action) {
            $action = typeof $action !== 'undefined' ? $action : 'curr';
            $('#temp-' + $action + '-' + $sensor).text($temperature.toFixed(2) + ' °C');
        }

        function toggleCheckbox($el, $state) {
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
        var $pumpMode = $('#pump_mode'),
            $pumpState = $('#pump_state'),
            $pumpModeData = $pumpMode.data(),
            $pumpStateData = $pumpState.data(),
            $postData = {};

        $pumpMode.on('click', function(e) {
            if ($pumpMode.is(':checked')) {
                $postData = { 'mode': 'automatic' };
                $('.toggle-pump').hide();
            } else {
                $postData = { 'mode': 'manual' };
                $('.toggle-pump').show();
            }

            $.post(
                $pumpModeData.url,
                $postData,
                function(response) {
                    //console.log(response);
                }
            );
        });

        $pumpState.on('click', function(e) {
            if ($pumpState.is(':checked')) {
                $postData = { 'state': 'on' };
            } else {
                $postData = { 'state': 'off' };
            }

            $.post(
                $pumpStateData.url,
                $postData,
                function(response) {
                    //console.log(response);
                }
            );
        });
    }
};
