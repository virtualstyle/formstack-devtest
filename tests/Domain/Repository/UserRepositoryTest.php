<?php
/**
 * This file is part of virtualstyle/formstack-devtest.
 * https://github.com/virtualstyle/formstack-devtest.
 *
 * @license https://opensource.org/licenses/MIT MIT
 */

namespace Virtualstyle\FormstackDevtest\Domain\Repository;

use Virtualstyle\FormstackDevtest\Domain\Repository\Database\Pdo as DB;
use Virtualstyle\FormstackDevtest\Domain\User as App;

/**
 * User repository object unit tests.
 */
class UserRepositoryTest extends \PHPUnit_Framework_TestCase
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
     * Test the repository findAll and findById.
     *
     * @method testFindAllAndFindById
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

        $this->setUp();
        $user_repo = new UserRepository();
        $user_repo->setDatabase($this->pdo_db);
        $collection = $user_repo->findAll(array('id' => 1, 'id' => 2), true);

        foreach ($collection as $user) {
            $check_user = $user_repo->findById($user->getId());
            $this->assertEquals($check_user, $user);
        }
    }

    /**
     * Test the insert, delete, and update functions.
     *
     * @method testInsertAndDeleteAndUpdate
     */
    public function testInsertAndDeleteAndUpdate()
    {
        $this->setUp();
        $user_repo = new UserRepository();
        $user_repo->setDatabase($this->pdo_db);

        $data = array('username' => 'testInsert',
            'password' => 'passwordTEST',
            'email' => 'email@test.com',
            'firstname' => 'firstname',
            'lastname' => 'lastname', );

        $user = new App\User($data);
        $user->setRepo($user_repo);

        $new_id = $user_repo->insert($user);
        $check_user = $user_repo->findById($new_id);
        $this->assertEquals($check_user->getVars(false), $user->getVars(false));
        $check_user = $user_repo->findById($user->getId());
        $this->assertEquals($check_user->getVars(false), $user->getVars(false));

        $user->setUsername('TESTUPDATE');
        $test_password = 'password';
        $user->setPassword($test_password);
        $user_repo->update($user);
        $check_user = $user_repo->findById($user->getId());
        $this->assertEquals($check_user->getVars(false), $user->getVars(false));

        $user->setUsername('TESTUPDATE2');
        $user->setPassword('changepassword');
        $user_repo->update($user, true);
        $check_user = $user_repo->findById($user->getId());
        $this->assertEquals($check_user->getVars(false), $user->getVars(false));

        $delete = $user_repo->delete($user->getId());
        $this->assertTrue($delete === 1);
        $this->assertFalse($user_repo->findById($user->getId()));

        $check_user = $user_repo->findById(1);
        $delete = $user_repo->delete($check_user);
        $this->assertTrue($delete === 1);
        $this->assertFalse($user_repo->findById($user->getId()));
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
        $this->assertInstanceOf(DB\PdoDatabase::class, $user_repo->getDatabase());
        $this->assertInstanceOf(DB\PdoConnection::class, $user_repo
            ->getDatabase()
            ->getConnection());
    }
}
