<?php
/**
 * This file is part of virtualstyle/formstack-devtest.
 * https://github.com/virtualstyle/formstack-devtest.
 *
 * @license https://opensource.org/licenses/MIT MIT
 */

namespace Virtualstyle\FormstackDevtest\Domain\Repository;

use Virtualstyle\FormstackDevtest\Domain\User\UserInterface;

/**
 * Interface between user data storage and application objects.
 */
interface UserRepositoryInterface
{
    /**
     * Set the DatabaseInterface implementation for this repository.
     *
     * @method setDatabase
     *
     * @param DatabaseInterface $database A valid DatabaseInterface implementation
     */
    public function setDatabase(Database\DatabaseInterface $database);

    /**
     * Get an object from the data store by ID.
     *
     * @method findById
     *
     * @param mixed $id The data store id of the object we want
     *
     * @return mixed
     */
    public function findById($id);

    /**
     * Get a collection of objects from the data store by criteria.
     *
     * @method findAll
     *
     * @param array $conditions An array of condition to search the repository by
     *
     * @return array
     */
    public function findAll(array $conditions = array());

    /**
     * Insert an obect into the repository.
     *
     * @method insert
     *
     * @param UserInterface $user A valid UserInterface implementation
     *
     * @return mixed
     */
    public function insert(UserInterface $user);

    /**
     * Update an obect in the repository.
     *
     * @method update
     *
     * @param UserInterface $user A valid UserInterface implementation
     *
     * @return mixed
     */
    public function update(UserInterface $user);

    /**
     * Delete an obect from the repository.
     *
     * @method delete
     *
     * @param mixed $id The data store id of the object we want to delete
     *
     * @return int
     */
    public function delete($id);
}
