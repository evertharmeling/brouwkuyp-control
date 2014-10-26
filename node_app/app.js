// load modules
var nconf = require('nconf');
nconf.file('settings.json');
var debug = nconf.get('debug');
var amqp = require('amqp');
var _ = require('underscore');
var util = require("util");

// intialize connection with AMQP server
var conn = amqp.createConnection({
        host: nconf.get('amqp:host'),
        port: nconf.get('amqp:port'),
        login: nconf.get('amqp:user'),
        password: nconf.get('amqp:pass')
    }, {
        defaultExchangeName : nconf.get('amqp:exchangeTopic')
    }
);

// on connect
conn.on('connect', function () {
    console.log('Connected to AMQP server');
    console.log('Listening to AMQP messages...');
});

// on ready
conn.on('ready', function () {
    // Use the default 'amq.topic' exchange
    conn.queue('my-queue', { durable: true }, function (q) {
        // Catch all messages
        q.bind(nconf.get('amqp:routingKey'));

        // Receive messages
        q.subscribe(function (message, headers, deliveryInfo, messageObject) {
            console.log('Node AMQP: received topic "' + deliveryInfo.routingKey + '", message: "' + message.data.toString() + '"');
        });
    });
});

// on error
conn.on('error', function (err) {
    console.error(util.inspect(err, {depth: null}));
});

// on close
conn.on('close', function () {
    console.log('AMQP connection closed...');
});
