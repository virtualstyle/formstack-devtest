<?php
/**
 * PDO Connection object unit tests.
 */

namespace Virtualstyle\FormstackDevtest\Domain\Repository\Database\Pdo;

/**
 * PDO Connection object unit tests.
 */
class PdoConnectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test the object constructor.
     *
     * @method testConstructor
     */
    public function testSetConfigAndSetConnectionAndGetConnection()
    {
        // Test setConfig
        $pdo_connection = new PdoConnection();
        $pdo_connection->setConfig(
            array('dsn' => PDO_DSN, 'user' => PDO_USER, 'password' => PDO_PASS,
                'driverOptions' => array(),
            )
        );

        $this->assertAttributeEquals(
            array('dsn' => PDO_DSN, 'user' => PDO_USER,
                'password' => PDO_PASS, 'driverOptions' => array(),
            ),
            'config',
            $pdo_connection
        );

        // Test setConnection
        $pdo_connection->setConnection();
        $this->assertInstanceOf(\PDO::class, $pdo_connection->getConnection());

        // Test setConnection passing a connection object.
        $test_connection = new \PDO(
            PDO_DSN,
            PDO_USER,
            PDO_PASS,
            array()
        );
        $pdo_connection = new PdoConnection();
        $pdo_connection->setConfig(
            array('dsn' => PDO_DSN, 'user' => PDO_USER, 'password' => PDO_PASS,
                'driverOptions' => array(),
            )
        );
        $pdo_connection->setConnection($test_connection);
        $this->assertInstanceOf(\PDO::class, $pdo_connection->getConnection());
    }
}
