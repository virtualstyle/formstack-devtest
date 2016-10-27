<?php
/**
 * An interface for interacting with databases.
 */
namespace FormstackDevtest\Model\Repository\Database;

/**
 * An interface for interacting with databases.
 */
interface Database
{
    /**
     * Set the connection to a DatabaseConnection interface.
     *
     * @method setConnection
     *
     * @param Connection $connection A valid Connection object
     */
    public function setConnection(Connection $connection);

    /**
     * Get the DatabaseConnection interface.
     *
     * @method getConnection
     *
     * @return DatabaseConnection
     */
    public function getConnection();

    /**
     * Prepare a sql statement/object for execution.
     *
     * @method prepare
     *
     * @param mixed $sql     A sql statement or object
     * @param array $options An array of options
     *
     * @return mixed
     */
    public function prepare($sql, array $options = array());

    /**
     * Execute a prepared statement.
     *
     * @method execute
     *
     * @param array $parameters Array of parameters and other data
     *
     * @return mixed
     */
    public function execute(array $parameters = array());

    /**
     * Fetch an entity from the data store.
     *
     * @method fetch
     *
     * @param array $options Array of implementation options
     *
     * @return mixed
     */
    public function fetch(array $options = array());

    /**
     * Fetch All entities from the data store.
     *
     * @method fetchAll
     *
     * @param array $options Array of implementation options
     *
     * @return mixed
     */
    public function fetchAll(array $options = array());

    /**
     * Insert an entity into the data store.
     *
     * @method insert
     *
     * @param mixed $table      Table name or object
     * @param array $parameters Array of field => value
     *
     * @return int
     */
    public function insert($table, array $parameters = array());

    /**
     * Update an entity in the data store.
     *
     * @method update
     *
     * @param mixed $table      Table name or object
     * @param array $parameters Array of field => value
     * @param mixed $where      Where clause string or object
     *
     * @return int
     */
    public function update($table, array $parameters, $where = '');

    /**
     * Delete an entity from the data store.
     *
     * @method delete
     *
     * @param mixed $table Table name or object
     * @param mixed $where Where clause string or object
     *
     * @return int
     */
    public function delete($table, $where = '');
}
