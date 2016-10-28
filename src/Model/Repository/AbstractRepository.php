<?php
/**
 * An abstract class for base bidirectional abstract storage functions.
 */
namespace Virtualstyle\FormstackDevtest\Model\Repository;

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
     * @param mixed $id The id we're looking for
     *
     * @return mixed
     */
    public function findById($id)
    {
        $this->database->select($this->collection_name,
            array('id' => $id));

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
     * @param array $conditions Criteria/parameters for repository search
     *
     * @return mixed
     */
    public function findAll(array $conditions = array())
    {
        $collection = array();
        $this->database->select($this->collection_name, $conditions);
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
