<?php
/**
 * PDO Connection object unit tests.
 */
namespace FormstackDevtest\Model\Repository\Database\Pdo;

/**
 * PDO Connection object unit tests.
 */
class ConnectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test the object constructor.
     *
     * @method testConstructor
     */
    public function testSetConfigAndSetConnectionAndGetConnection()
    {
        /**
         * Due to the restrictions of the project, this isn't REALLY outside
         * the webroot, but that's the idea here. This is a rough
         * implementation, and should really be worked into an application
         * configuration scheme to define all various constants and config
         * in one place for each runtime instance.
         */
        require_once dirname(__FILE__).'/../src/pdo_config.php';

        // Test setConfig
        $pdo_connection = new Connection();
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
        $this->assertTrue($pdo_connection->getConnection() instanceof \PDO);

        // Test setConnection passing a connection object.
        $test_connection = new \PDO(
            PDO_DSN,
            PDO_USER,
            PDO_PASS,
            array()
        );
        $pdo_connection = new Connection();
        $pdo_connection->setConfig(
            array('dsn' => PDO_DSN, 'user' => PDO_USER, 'password' => PDO_PASS,
                'driverOptions' => array(),
            )
        );
        $pdo_connection->setConnection($test_connection);
        $this->assertTrue($pdo_connection->getConnection() instanceof \PDO);
    }
}
