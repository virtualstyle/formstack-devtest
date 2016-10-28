<?php
/**
 * User object repository implementation.
 */
namespace Virtualstyle\FormstackDevtest\Model\Repository;

use Virtualstyle\FormstackDevtest\Model\User as AppUser;

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
        $new_id = $this->database->insert($this->collection_name,
            $user->getVars());
        $user->setId($new_id);

        return $new_id;
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
        $user = new AppUser\User($data);
        $user->setRepo($this);

        return $user;
    }
}
