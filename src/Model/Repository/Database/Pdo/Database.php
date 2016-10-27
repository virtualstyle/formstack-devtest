<?php
/**
 * PDODatabase implements the Database interface with PDO.
 */
namespace FormstackDevtest\Model\Repository\Database\Pdo;

/**
 * PDODatabase provides a concrete implementation of the Database interface
 * using the flexibility of PDO.
 */
class Database implements \FormstackDevtest\Model\Repository\Database\Database
{
    /**
     * The PDO database connection.
     *
     * @var Database\Connection
     */
    protected $connection;

    /**
     * PDO statement holder.
     *
     * @var \PDO\Statement
     */
    protected $statement;

    /**
     * Cursor Orientation default to next record.
     *
     * @var \PDO\const
     */
    protected $cursorOrientation = \PDO::FETCH_ORI_NEXT;

    /**
     * Cursor offset default to 0.
     *
     * @var int
     */
    protected $cursorOffset = 0;

    /**
     * Fetching mode default to associative array.
     *
     * @var \PDO\const
     */
    protected $fetchMode = \PDO::FETCH_ASSOC;

    /**
     * Inject a Database\Connection.
     *
     * @method setConnection
     *
     * @param Database\Connection $connection
     *                                        Inject a connection interface implementer implemented object
     */
    public function setConnection(
        \FormstackDevtest\Model\Repository\Database\Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Expose the Database\Connection for reuse/sharing.
     *
     * @method getConnection
     *
     * @return Database\Connection
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * Expose the statement for reuse/sharing.
     *
     * @method getStatement
     *
     * @return \PDOStatement
     */
    public function getStatement()
    {
        return $this->statement;
    }

    /**
     * Wrapper for \PDOStatement::prepare().
     *
     * @method prepare
     *
     * @param mixed $sql     SQL string or object
     * @param array $options An array of options
     *
     * @return Pdo\Database
     */
    public function prepare($sql, array $options = array())
    {
        $this->statement = $this->connection->getConnection()->prepare($sql, $options);

        return $this;
    }

    /**
     * Wrapper for \PDOStatement::execute().
     *
     * @method execute
     *
     * @param array $parameters Array of parameters and SQL logic operators
     *
     * @return PDOResult
     */
    public function execute(array $parameters = array())
    {
        $this->getStatement()->execute($parameters);

        return $this;
    }

    /**
     * Retrieve an entity from the data store.
     *
     * @method fetch
     *
     * @param array $options Array or retrieval options
     *
     * @return array
     */
    public function fetch(array $options = array())
    {
        if (isset($options['fetchMode']) && !empty($options['fetchMode'])) {
            $this->fetchMode = $options['fetchMode'];
        }
        if (isset($options['cursorOrientation']) && !empty($options['cursorOrientation'])) {
            $this->cursorOrientation = $options['cursorOrientation'];
        }
        if (isset($options['cursorOffset']) && !empty($options['cursorOffset'])) {
            $this->cursorOffset = $options['cursorOffset'];
        }

        return $this->getStatement()->fetch($this->fetchMode, $this->cursorOrientation, $this->cursorOffset);
    }

    /**
     * Retrieve all entities from the data store.
     *
     * @method fetchAll
     *
     * @param array $options Array or retrieval options
     *
     * @return array
     */
    public function fetchAll(array $options = array())
    {
        if (isset($options['fetchMode']) && !empty($options['fetchMode'])) {
            $this->fetchMode = $options['fetchMode'];
        }

        return $this->getStatement()->fetchAll($this->fetchMode);
    }

    /**
     * Insert an entity into the data store.
     *
     * @method insert
     *
     * @param array $options Array or retrieval options
     *
     * @return array
     */
    public function insert($table, array $parameters = array())
    {
    }
}
