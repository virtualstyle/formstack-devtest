<?php
/**
 * User object unit tests.
 */

namespace Virtualstyle\FormstackDevtest\Domain\User;

use Virtualstyle\FormstackDevtest\Domain\Repository\UserRepository;
use Virtualstyle\FormstackDevtest\Domain\Repository\Database\Pdo as DB;
use PHPUnit_Framework_TestCase;

/**
 *  User object unit test class.
 */
class UserTest extends PHPUnit_Framework_TestCase
{
    /**
     * Variable to hold a database.
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
     * Test the repository setter injection.
     *
     * @method testSetRepo
     */
    public function testSetRepo()
    {
        $test_data = array(
            'username' => 'testuser',
            'password' => 'password',
            'email' => 'testuser@test.com',
            'firstname' => 'test',
            'lastname' => 'user',
        );
        $user = new User($test_data);
        $user->setRepo(new UserRepository());
        $this->assertInstanceOf(UserRepository::class, $user->getRepo());
    }

    /**
     * Test the save method.
     *
     * @method testSave
     */
    public function testSave()
    {
        $test_data = array(
            'username' => 'testuser',
            'password' => 'password',
            'email' => 'testuser@test.com',
            'firstname' => 'test',
            'lastname' => 'user',
        );
        $user = new User($test_data);
        $user->setRepo(new UserRepository());
        $user->getRepo()->setDatabase($this->pdo_db);
        $user->getRepo()->insert($user);
        $user->setUsername('NEWNAME');
        $this->assertEquals($user->getUsername(), 'NEWNAME');
        $user->setPassword('NEWPASSWORD');
        $this->assertAttributeEquals('NEWPASSWORD', 'password', $user);
        $user->setEmail('NEWEMAIL@EMAIL.COM');
        $this->assertEquals($user->getEmail(), 'NEWEMAIL@EMAIL.COM');
        $user->setFirstname('NEWFIRSTNAME');
        $this->assertEquals($user->getFirstname(), 'NEWFIRSTNAME');
        $user->setLastname('NEWLASTNAME');
        $this->assertEquals($user->getLastname(), 'NEWLASTNAME');

        $user->save();
        $check_user = $user->getRepo()->findById($user->getId());
        $this->assertEquals($check_user->getVars(false), $user->getVars(false));
        $this->assertEquals($check_user->getUsername(), 'NEWNAME');

        $user = new User($test_data);
        $user->setRepo(new UserRepository());
        $user->getRepo()->setDatabase($this->pdo_db);
        $new_id = $user->save();
        $check_user = $user->getRepo()->findById($user->getId());
        $this->assertEquals($check_user->getVars(false), $user->getVars(false));
    }

    /**
     * Testing the constructor branch that takes an object rather than an id.
     *
     * @method testConstructorBranch
     */
    public function testConstructorBranch()
    {
        $test_data = array(
            'username' => 'testuser',
            'password' => 'password',
            'email' => 'testuser@test.com',
            'firstname' => 'test',
            'lastname' => 'user',
            'updated' => false,
        );
        $user = new User($test_data);
        $user->setRepo(new UserRepository());
        $this->assertInstanceOf(UserRepository::class, $user->getRepo());
    }

    /**
     * Testing the constructor fail for invalid data.
     *
     * @method testConstructorFail
     * @expectedException InvalidArgumentException
     */
    public function testConstructorFail()
    {
        $test_data = array(
            'username' => '',
            'password' => '',
            'email' => '',
            'firstname' => '',
            'lastname' => '',
        );

        $user = new User($test_data);
    }

    /**
     * Check that constructor rejects empty data array.
     *
     * Tests input cases to trigger validation rules
     * and throw InvalidArgumentExceptions
     *
     * @method testEmptyUserData
     *
     * @param array $test_data An array of test data
     *
     * @dataProvider validateDataTestDataProvider
     * @expectedException InvalidArgumentException
     */
    public function testValidateData($test_data)
    {
        $user = new User($test_data);
    }

    /**
     * Data provider for User data validation cases.
     *
     * @method validateDataTestDataProvider
     *
     * @return array
     */
    public function validateDataTestDataProvider()
    {
        return array(
            //Empty user data array
            array(array()),
            //Unset username
            array(
                array(
                    'password' => 'password',
                    'email' => 'testuser@test.com',
                    'firstname' => 'test',
                    'lastname' => 'user',
                ),
            ),
            //Empty username
            array(
                array(
                    'username' => '',
                    'password' => 'password',
                    'email' => 'testuser@test.com',
                    'firstname' => 'test',
                    'lastname' => 'user',
                ),
            ),
            //Username too long
            array(
                array(
                    'username' => '12345678901234567890123456789012345678901234567890123456789012345',
                    'password' => 'password',
                    'email' => 'testuser@test.com',
                    'firstname' => 'test',
                    'lastname' => 'user',
                ),
            ),
            //Unset password
            array(
                array(
                    'username' => 'testuser',
                    'email' => 'testuser@test.com',
                    'firstname' => 'test',
                    'lastname' => 'user',
                ),
            ),
            //Empty password
            array(
                array(
                    'username' => 'testuser',
                    'password' => '',
                    'email' => 'testuser@test.com',
                    'firstname' => 'test',
                    'lastname' => 'user',
                ),
            ),
            //Password too long
            array(
                array(
                    'username' => 'testuser',
                    'password' => '123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789',
                    'email' => 'testuser@test.com',
                    'firstname' => 'test',
                    'lastname' => 'user',
                ),
            ),
            //Unset email
            array(
                array(
                    'username' => 'testuser',
                    'password' => 'password',
                    'firstname' => 'test',
                    'lastname' => 'user',
                ),
            ),
            //Empty email
            array(
                array(
                    'username' => 'testuser',
                    'password' => 'password',
                    'email' => '',
                    'firstname' => 'test',
                    'lastname' => 'user',
                ),
            ),
            //Email alias too long
            array(
                array(
                    'username' => 'testuser',
                    'password' => 'password',
                    'email' => '12345678901234567890123456789012345678901234567890123456789012345@123456789012345678901234567890123456789012345678901234567890123.us',
                    'firstname' => 'test',
                    'lastname' => 'user',
                ),
            ),
            //Email domain too long
            array(
                array(
                    'username' => 'testuser',
                    'password' => 'password',
                    'email' => '1234567890123456789012345678901234567890123456789012345678901234@1234567890123456789012345678901234567890123456789012345678901234.us',
                    'firstname' => 'test',
                    'lastname' => 'user',
                ),
            ),
            //Unset firstname
            array(
                array(
                    'username' => 'testuser',
                    'password' => 'password',
                    'email' => 'valid@email.com',
                    'lastname' => 'user',
                ),
            ),
            //Empty firstname
            array(
                array(
                    'username' => 'testuser',
                    'password' => 'password',
                    'email' => 'valid@email.com',
                    'firstname' => '',
                    'lastname' => 'user',
                ),
            ),
            //Firstname too long
            array(
                array(
                    'username' => 'testuser',
                    'password' => 'password',
                    'email' => 'valid@email.com',
                    'firstname' => '123456789012345678901234567890123',
                    'lastname' => 'user',
                ),
            ),
            //Unset lastname
            array(
                array(
                    'username' => 'testuser',
                    'password' => 'password',
                    'email' => 'valid@email.com',
                    'firstname' => 'test',
                ),
            ),
            //Empty lastname
            array(
                array(
                    'username' => 'testuser',
                    'password' => 'password',
                    'email' => 'valid@email.com',
                    'firstname' => 'test',
                    'lastname' => '',
                ),
            ),
            //Lastname too long
            array(
                array(
                    'username' => 'testuser',
                    'password' => 'password',
                    'email' => 'valid@email.com',
                    'firstname' => 'test',
                    'lastname' => '123456789012345678901234567890123',
                ),
            ),
        );
    }
}
