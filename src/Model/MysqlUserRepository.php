<?php
/**
 * MysqlRepository User table extension to implement UserRepository data object.
 *
 * An independent, persistence-agnostic repository responsible for defining clearly
 * the interactions between the entities of a system through data and behavior.
 */
namespace Virtualstyle\FormstackDevtest\Model;

/**
 * MysqlUserRepository abstracts user data/domain layer from app layer.
 */
class MysqlUserRepository extends MysqlRepository implements UserRepository
{
    /**
     * Class constructor and parent constructor call.
     *
     * @method __construct
     *
     * @param PDO $connection A valid PDO connection object
     */
    public function __construct(\PDO $connection = null)
    {
        parent::__construct($connection);
    }
}
