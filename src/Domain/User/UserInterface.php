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
     * Return object variables.
     *
     * @method getVars
     *
     * @return array
     */
    public function getVars();
}
