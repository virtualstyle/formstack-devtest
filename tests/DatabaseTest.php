<?php
/**
 * PdoDatabaseConnection object unit tests.
 */
namespace FormstackDevtest\Model\Repository\Database\Pdo;

/**
 *  PdoDatabaseConnection object unit test class.
 */
class PdoDatabaseTest extends \PHPUnit_Framework_TestCase
{
    protected $pdo_db;

    protected function setUp()
    {
        $this->pdo_db = new Database();

        $pdo_connection = new Connection();
        $pdo_connection->setConfig(
            array('dsn' => PDO_DSN, 'user' => PDO_USER, 'password' => PDO_PASS,
                'driverOptions' => array(),
            )
        );
        $pdo_connection->setConnection();
        $this->pdo_db->setConnection($pdo_connection);
    }

    /**
     * Test setConnection.
     *
     * @method testConstructor
     */
    public function testSetConnection()
    {
        $this->setUp();
        $this->assertTrue($this->pdo_db->getConnection() instanceof Connection);
    }

    public function testPrepare()
    {
        $this->setUp();
        $this->pdo_db->prepare('SELECT * FROM user', array());
        $this->assertTrue($this->pdo_db->getStatement() instanceof \PDOStatement);
    }

    public function testExecuteAndFetch()
    {
        $this->setUp();
        $this->pdo_db->prepare('SELECT id FROM user WHERE id = 1', array());
        $this->pdo_db->execute(array());
        $row = $this->pdo_db->fetch();
        $this->assertTrue(is_array($row));
        $this->assertEquals(array('id' => 1), $row);
    }

    public function testFetchAll()
    {
        $this->setUp();
        $this->pdo_db->prepare('SELECT id FROM user WHERE id IN(1,2,3) ORDER BY ID', array());
        $this->pdo_db->execute(array());
        $rows = $this->pdo_db->fetchAll();
        $this->assertTrue(is_array($rows));
        $this->assertEquals(array(array('id' => 1), array('id' => 2), array('id' => 3)), $rows);
    }

    public function testInsert()
    {
        $this->setUp();
        $this->pdo_db->insert('user', array('id' => array('bool'=>null, 'value' => 1)));
    }
}
