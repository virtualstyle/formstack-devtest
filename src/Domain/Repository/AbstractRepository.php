<?php
/**
 * This file is part of virtualstyle/formstack-devtest.
 * https://github.com/virtualstyle/formstack-devtest.
 *
 * @license https://opensource.org/licenses/MIT MIT
 */

namespace Virtualstyle\FormstackDevtest\Domain\Repository;

/**
 * An abstract class for base bidirectional abstract storage functions.
 */
abstract class AbstractRepository
{
    /**
     * Store an implemented Database interface.
     *
     * @var DatabaseInterface
     */
    protected $database;

    /**
     * Store collection name or object.
     *
     * @var mixed
     */
    protected $collection;

    /**
     * Repository setter injection of DatabaseInterface.
     *
     * @method setDatabase
     *
     * @param DatabaseInterface $database A DatabaseInterface implementation
     */
    public function setDatabase(Database\DatabaseInterface $database)
    {
        $this->database = $database;
    }

    /**
     * Retrun a reference to this object's database.
     *
     * @method getDatabase
     *
     * @return DatabaseInterface
     */
    public function getDatabase()
    {
        return $this->database;
    }

    /**
     * Find an object in the repository by its ID.
     *
     * @method findById
     *
     * @param mixed  $id      The id we're looking for
     * @param string $columns SQL column list
     *
     * @return mixed
     */
    public function findById($id, $columns = '*')
    {
        $this->database->select($this->collection_name,
            array('id' => $id), false, $columns = 'id, username, email, firstname, lastname');

        if (!$data = $this->database->fetch()) {
            return false;
        }

        return $this->createObject($data);
    }

    /**
     * Return all repository objects of current type.
     *
     * @method findAll
     *
     * @param array  $conditions Criteria/parameters for repository search
     * @param bool   $or         A flag to indicate use of 'OR' rather than 'AND'
     * @param string $columns    SQL column list
     *
     * @return mixed
     */
    public function findAll(array $conditions = array(), bool $or = false,
        $columns = '*')
    {
        echo $columns.PHP_EOL;

        $collection = array();
        $this->database->select($this->collection_name, $conditions, $or,
            $columns);
        $result = $this->database->fetchAll();

        if ($result) {
            foreach ($result as $data) {
                $collection[] = $this->createObject($data);
            }
        }

        return $collection;
    }

    /**
     * Create an object instance
     * (implementation delegated to concrete implementers).
     *
     * @method createObject
     *
     * @param array $data An array of object data
     *
     * @return mixed
     */
    abstract protected function createObject(array $data);
}
