<?php
/**
 * User repository object unit tests.
 */
namespace Virtualstyle\FormstackDevtest\Model\Repository;

use Virtualstyle\FormstackDevtest\Model\Repository\Database\Pdo as DB;

/**
 * User repository object unit tests.
 */
class UserRepositoryTest extends \PHPUnit_Framework_TestCase
{
    protected $pdo_db;

    protected function setUp()
    {
        $this->pdo_db = new DB\PdoDatabase();

        $pdo_connection = new DB\PdoConnection();
        $pdo_connection->setConfig(
            array('dsn' => PDO_DSN, 'user' => PDO_USER, 'password' => PDO_PASS,
                'driverOptions' => array(),
            )
        );
        $pdo_connection->setConnection();
        $this->pdo_db->setConnection($pdo_connection);
    }

    /**
     * Test the database setter injection.
     *
     * @method testSetDatabase
     */
    public function testFindAllAndFindById()
    {
        $this->setUp();
        $user_repo = new UserRepository();
        $user_repo->setDatabase($this->pdo_db);
        $collection = $user_repo->findAll();

        foreach ($collection as $user) {
            $check_user = $user_repo->findById($user->getId());
            $this->assertEquals($check_user, $user);
        }
    }

    /**
     * Test the database setter injection.
     *
     * @method testSetDatabase
     */
    public function testSetDatabase()
    {
        $this->setUp();
        $user_repo = new UserRepository();
        $user_repo->setDatabase($this->pdo_db);
        $this->assertTrue($user_repo->getDatabase() instanceof DB\PdoDatabase);
        $this->assertTrue($user_repo
            ->getDatabase()
            ->getConnection() instanceof DB\PdoConnection);
    }
}
