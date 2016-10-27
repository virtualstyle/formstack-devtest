<?php
/**
 * User object repository interface.
 */
namespace FormstackDevtest\Model\Repository;

/**
 * Interface between user data storage and application objects.
 */
interface UserRepository
{
    public function save(User $user);
    public function delete(User $user);
}
