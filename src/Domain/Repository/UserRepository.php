<?php
/**
 * This file is part of virtualstyle/formstack-devtest.
 * https://github.com/virtualstyle/formstack-devtest.
 *
 * @license https://opensource.org/licenses/MIT MIT
 */

namespace Virtualstyle\FormstackDevtest\Domain\Repository;

use Virtualstyle\FormstackDevtest\Domain\User as AppUser;

/**
 * User object repository implementation.
 */
class UserRepository extends AbstractRepository implements UserRepositoryInterface
{
    /**
     * The name of the collection where User objects are stored.
     *
     * @var string
     */
    protected $collection_name = 'user';

    /**
     * Insert an obect into the repository.
     *
     * @method insert
     *
     * @param UserInterface $user A valid UserInterface implementation
     *
     * @return mixed
     */
    public function insert(AppUser\UserInterface $user)
    {
        $parameters = $user->getVars();
        $parameters['password'] = $this->database->hashPassword($parameters['password']);
        $new_id = $this->database->insert($this->collection_name,
            $parameters);
        $user->setId($new_id);

        return $new_id;
    }

    /**
     * Update an obect in the repository.
     *
     * @method update
     *
     * @param UserInterface $user            A valid UserInterface implementation
     * @param bool          $update_password A flag to indicate to update the password
     *
     * @return mixed
     */
    public function update(AppUser\UserInterface $user, bool $update_password = false)
    {
        $parameters = $user->getVars($update_password);
        if ($update_password) {
            $parameters['password'] =
                $this->database->hashPassword($parameters['password']);
        } else {
            unset($parameters['password']);
        }
        $this->database->update($this->collection_name,
            $parameters, 'id = '.$user->getId());
    }

    /**
     * Delete an obect from the repository.
     *
     * @method delete
     *
     * @param mixed $id The data store id of the object we want to delete
     *
     * @return int
     */
    public function delete($id)
    {
        if ($id instanceof AppUser\UserInterface) {
            $id = $id->getId();
        }

        return $this->database->delete($this->collection_name, "id = $id");
    }

    /**
     * Create a User object with the data returned from the data store.
     *
     * @method createObject
     *
     * @param array $data An array of object data
     *
     * @return User
     */
    protected function createObject(array $data)
    {
        $data['validate_password'] = false;
        $user = new AppUser\User($data);
        $user->setRepo($this);

        return $user;
    }
}
