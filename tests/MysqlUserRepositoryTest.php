<?php
/**
 * Testing user repository object.
 *
 * @package Virtualstyle_FormstackDevtest
 */

namespace Virtualstyle\FormstackDevtest\Model;

use PHPUnit_Framework_TestCase;

/**
 *  MysqlUserRepository object unit test class.
 */
class MysqlUserRepositoryTest extends PHPUnit_Framework_TestCase
{
    /**
     * Testing constructor and getConnection functions.
     * @method testConstructorAndGetConnection
     */
    public function testConstructorAndGetConnection()
    {
        $repo = new MysqlUserRepository();

        $this->assertTrue( $repo->getConnection() instanceof \PDO );

        $connection = new \PDO(
            'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . '',
            DB_USER,
            DB_PASS
        );

        $repo = new MysqlUserRepository($connection);

        $this->assertTrue( $repo->getConnection() instanceof \PDO );
    }

    /**
     * Persist User object state in repository
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

    }
}
