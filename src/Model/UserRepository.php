<?php
/**
 * User object repository interface.
 */
namespace Virtualstyle\FormstackDevtest\Model;

/**
 * Interface between user data storage and application objects.
 */
interface UserRepository
{
    public function save();
    public function delete();
}
