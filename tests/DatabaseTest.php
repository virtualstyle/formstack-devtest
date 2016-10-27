<?php
/**
 * PdoDatabaseConnection object unit tests.
 */
namespace FormstackDevtest\Model\Repository\Database\Pdo;

/**
 *  PdoDatabaseConnection object unit test class.
 */
class DatabaseTest extends \PHPUnit_Framework_TestCase
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
        $this->pdo_db->prepare(
            'SELECT id FROM user WHERE id IN(1,2,3) ORDER BY ID', array());
        $this->pdo_db->execute(array());
        $rows = $this->pdo_db->fetchAll();
        $this->assertTrue(is_array($rows));
        $this->assertEquals(
            array(array('id' => 1), array('id' => 2), array('id' => 3)), $rows);
    }

    public function testInsertAndUpdateAndDelete()
    {
        $this->setUp();
        $id = $this->pdo_db->insert('user', array('username' => 'testInsert'));
        $this->pdo_db->prepare(
            'SELECT username FROM user WHERE id = :id', array());
        $this->pdo_db->execute(array('id' => $id));
        $rows = $this->pdo_db->fetchAll();
        $this->assertTrue(is_array($rows));
        $this->assertEquals(array(array('username' => 'testInsert')), $rows);

        $this->pdo_db->update('user', array('username' => 'TESTUPDATE'), 'id = '.$id);
        $this->pdo_db->prepare(
            'SELECT username FROM user WHERE id = :id', array());
        $this->pdo_db->execute(array('id' => $id));
        $rows = $this->pdo_db->fetchAll();
        $this->assertTrue(is_array($rows));
        $this->assertEquals(array(array('username' => 'TESTUPDATE')), $rows);

        $this->pdo_db->delete('user', 'id = '.$id);
        $this->pdo_db->prepare(
            'SELECT username FROM user WHERE id = :id', array());
        $this->pdo_db->execute(array('id' => $id));
        $rows = $this->pdo_db->fetchAll();
        $this->assertTrue(is_array($rows));
        $this->assertTrue(empty($rows));
        $this->assertEquals(array(), $rows);
    }

    public function testFetchOptions()
    {
        $this->setUp();
        $this->pdo_db->prepare(
            'SELECT id FROM user WHERE id IN(1,2,3) ORDER BY ID', array());
        $this->pdo_db->execute(array());
        $rows = $this->pdo_db->fetch(
            array(
                'fetchMode' => \PDO::FETCH_ASSOC,
                'cursorOrientation' => \PDO::FETCH_ORI_NEXT,
                'cursorOffset' => 0,
            )
        );
        $this->assertTrue(is_array($rows));
        $this->assertEquals(
            array('id' => 1), $rows);
    }

    public function testFetchAllOptions()
    {
        $this->setUp();
        $this->pdo_db->prepare(
            'SELECT id FROM user WHERE id IN(1,2,3) ORDER BY ID', array());
        $this->pdo_db->execute(array());
        $rows = $this->pdo_db->fetchAll(array('fetchMode' => \PDO::FETCH_ASSOC));
        $this->assertTrue(is_array($rows));
        $this->assertEquals(
            array(array('id' => 1), array('id' => 2), array('id' => 3)), $rows);
    }
}
