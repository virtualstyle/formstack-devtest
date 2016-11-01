<?php
/**
 * PdoDatabase object unit tests.
 */

namespace Virtualstyle\FormstackDevtest\Domain\Repository\Database\Pdo;

/**
 *  PdoDatabase object unit test class.
 */
class PdoDatabaseTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Variable to hold the test database.
     *
     * @var PdoDatabase
     */
    protected $pdo_db;

    /**
     * Setup the DB connection for tests.
     *
     * @method setUp
     */
    protected function setUp()
    {
        $this->pdo_db = new PdoDatabase();

        $pdo_connection = new PdoConnection();
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
        $this->assertInstanceOf(PdoConnection::class, $this->pdo_db->getConnection());
    }

    /**
     * Test statement prepare.
     *
     * @method testPrepare
     */
    public function testPrepare()
    {
        $this->setUp();
        $this->pdo_db->prepare('SELECT * FROM user', array());
        $this->assertInstanceOf(\PDOStatement::class, $this->pdo_db->getStatement());
    }

    /**
     * Test statement execute and fetch.
     *
     * @method testExecuteAndFetch
     */
    public function testExecuteAndFetch()
    {
        $this->setUp();
        $this->pdo_db->prepare('SELECT id FROM user WHERE id = 1', array());
        $this->pdo_db->execute(array());
        $row = $this->pdo_db->fetch();
        $this->assertTrue(is_array($row));
        $this->assertEquals(array('id' => 1), $row);
    }

    /**
     * Test fetch all.
     *
     * @method testFetchAll
     */
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

    /**
     * Test insert, update, and delete.
     *
     * @method testInsertAndUpdateAndDelete
     */
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

    /**
     * Test the various fetch options.
     *
     * @method testFetchOptions
     */
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

    /**
     * Test the fecthAll fetch mode option.
     *
     * @method testFetchAllOptions
     */
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
