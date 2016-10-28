<?php
/**
 * User object unit tests.
 */
namespace Virtualstyle\FormstackDevtest\Model\User;

use Virtualstyle\FormstackDevtest\Model\Repository as Repository;
use PHPUnit_Framework_TestCase;

/**
 *  User object unit test class.
 */
class UserTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test the repository setter injection.
     *
     * @method testSetRepo
     *
     * @return bool
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
        $user->setRepo(new Repository\UserRepository());
        $this->assertTrue($user->getRepo() instanceof Repository\UserRepository);
    }

    /**
     * Testing the constructor branch that takes an object rather than an id.
     *
     * @method testConstructorBranch
     *
     * @return bool
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
        $user->setRepo(new Repository\UserRepository());
        $this->assertTrue($user->getRepo() instanceof Repository\UserRepository);
    }

    /**
     * Check that constructor rejects empty data array.
     *
     * Tests input cases to trigger validation rules
     * and throw InvalidArgumentExceptions
     *
     * @method testEmptyUserData
     *
     * @dataProvider validateDataTestDataProvider
     * @expectedException InvalidArgumentException
     */
    public function testValidateData($test_data)
    {
        $user = new User($test_data);
        $user->setRepo(new Repository\UserRepository());

        die(print_r($user));
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
