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
    protected $collection_name = 'user';

    public function insert(AppUser\UserInterface $user)
    {
        $post->id =
            $this->adapter->insert($this->collection_name,
                array('username' => $post->username,
                    'password' => $post->password,
                    'email' => $post->email,
                    'firstname' => $post->firstname,
                    'lastname' => $post->lastname, )
            );

        return $post->id;
    }

    public function delete(AppUser\UserInterface $user)
    {
    }

    protected function createObject(array $data)
    {
        $user = new AppUser\User($data);
        $user->setRepo($this);

        return $user;
    }
}
