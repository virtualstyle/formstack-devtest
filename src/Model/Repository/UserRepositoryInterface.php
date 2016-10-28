<?php
/**
 * User object repository interface.
 */
namespace Virtualstyle\FormstackDevtest\Model\Repository;

use Virtualstyle\FormstackDevtest\Model\User as AppUser;

/**
 * Interface between user data storage and application objects.
 */
interface UserRepositoryInterface
{
    public function setDatabase(Database\DatabaseInterface $database);
    public function findById($id);
    public function findAll(array $conditions = array());
    public function insert(AppUser\UserInterface $user);
    public function delete(AppUser\UserInterface $user);
}
