<?php
/**
 * This file is part of virtualstyle/formstack-devtest.
 * https://github.com/virtualstyle/formstack-devtest.
 *
 * @license https://opensource.org/licenses/MIT MIT
 */

namespace Virtualstyle\FormstackDevtest\Domain\User;

use Virtualstyle\FormstackDevtest\Domain\Repository\UserRepository;

/**
 * UserInterface specifies the required behavior of a User implementation.
 */
interface UserInterface
{
    /**
     * Inject a repository interface.
     *
     * @method setRepo
     *
     * @param UserRepository $repo UserRepository interface
     */
    public function setRepo(UserRepository $repo);

    /**
     * Expose the repository interface.
     *
     * @method getRepo
     *
     * @return UserRepository
     */
    public function getRepo();

    /**
     * Set the id data member.
     *
     * @method setId
     *
     * @param mixed $id An id to set this object's id
     */
    public function setId($id);

    /**
     * Expose the id data member.
     *
     * @method getId
     *
     * @return int
     */
    public function getId();

    /**
     * Set the username data member.
     *
     * @method setUsername
     *
     * @param string $username A string to set username data member
     */
    public function setUsername($username);

    /**
     * Expose the username data member.
     *
     * @method getUsername
     *
     * @return int
     */
    public function getUsername();

    /**
     * Set the password data member.
     *
     * @method setUsername
     *
     * @param string $password A string to set password data member
     */
    public function setPassword($password);

    /**
     * Set the email data member.
     *
     * @method setEmail
     *
     * @param string $email A string to set email data member
     */
    public function setEmail($email);

    /**
     * Expose the email data member.
     *
     * @method getEmail
     *
     * @return int
     */
    public function getEmail();

    /**
     * Set the firstname data member.
     *
     * @method setFirstname
     *
     * @param string $firstname A string to set firstname data member
     */
    public function setFirstname($firstname);

    /**
     * Expose the firstname data member.
     *
     * @method getFirstname
     *
     * @return int
     */
    public function getFirstname();

    /**
     * Set the lastname data member.
     *
     * @method setLastname
     *
     * @param string $lastname A string to set lastname data member
     */
    public function setLastname($lastname);

    /**
     * Expose the lastname data member.
     *
     * @method getLastname
     *
     * @return int
     */
    public function getLastname();

    /**
     * Return object variables.
     *
     * @method getVars
     *
     * @return array
     */
    public function getVars(bool $return_password = true);

    /**
     * Save this user in the data store.
     *
     * @method save
     */
    public function save();

    /**
     * Validate User object data state.
     *
     * @method validateData
     *
     * @param array $data              An array of values indexed by field name
     * @param bool  $validate_password A flag indicating to validate password
     *
     * @return bool
     */
    public function validateData(array $data, bool $validate_password = true);
}
