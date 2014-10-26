var amqp = require('amqp');

var conn = amqp.createConnection({ url: "amqp://guest:guest@localhost:5672" });

// Wait for connection to become established.
conn.on('ready', function () {
    // Use the default 'amq.topic' exchange
    conn.queue('my-queue', function (q) {
        // Catch all messages
        q.bind('#');

        // Receive messages
        q.subscribe(function (message) {
            // Print messages to stdout
            console.log(message);
        });
    });
});
