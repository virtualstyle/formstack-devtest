<?php
/**
 * This file is part of virtualstyle/formstack-devtest.
 * https://github.com/virtualstyle/formstack-devtest.
 *
 * @license https://opensource.org/licenses/MIT MIT
 */

namespace Virtualstyle\FormstackDevtest;

/**
 * Testing the cli framework.
 */
class CliInterfaceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Run a test on the cli and check output.
     *
     * @method testCli
     */
    public function testCli()
    {
        $console = dirname(__DIR__).'/index.php';
        $actual = preg_replace('/^[a-zA-Z]/i', '', shell_exec("php {$console} "));
        $expect = preg_replace('/^[a-zA-Z]/i', '', 'help
    Gets the available commands, or the help for one command.
user
    Lists user data selected by unique id from repository.
Argument (integer id)
user-create
    Create and store a user. Follow the prompts or:
Argument format: usernametest password email@emailtest.com firstnametest lastnametest
JSON format: \'{"username":"usernametest","password":"password","email":"email@emailtest.com","firstname":"firstnametest","lastname":"lastnametest"}\'
user-delete
    Deletes user data selected by unique id from repository.
Argument (integer id)
user-password
    Updates a user password by unique id in repository. Follow the prompts or use arguments: id password.
user-update
    Save data to an existing user. Follow the prompts or:
Argument format: id usernametest password email@emailtest.com firstnametest lastnametest
JSON format: \'{"id":5,"username":"usernametest","password":"password","email":"email@emailtest.com","firstname":"firstnametest","lastname":"lastnametest"}\'
users
    Lists all user data from the user repository. (No arguments)

');
        $this->assertSame($expect, $actual);
    }
}
