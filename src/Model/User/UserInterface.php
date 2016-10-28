<?php
/**
 * User object business logic.
 */
namespace Virtualstyle\FormstackDevtest\Model\User;

use Virtualstyle\FormstackDevtest\Model\Repository as Repository;

/**
 * User object handles the application facing side of the data model.
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
    public function setRepo(Repository\UserRepository $repo);

    /**
     * Expose the repository interface.
     *
     * @method getRepo
     *
     * @return UserRepository
     */
    public function getRepo();

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
