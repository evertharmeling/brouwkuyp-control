<?php

namespace Brouwkuyp\Bundle\ServiceBundle\Test\AMQP;

use PhpAmqpLib\Connection\AMQPStreamConnection;

/**
 * @author Evert Harmeling <evertharmeling@gmail.com>
 */
class AMQPTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @var AMQPStreamConnection
     */
    protected $conn;

    /**
     * Creation of a AMQP connection
     */
    protected function setUp()
    {
        $this->conn = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
    }
}
