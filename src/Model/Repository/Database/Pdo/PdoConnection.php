<?php
/**
 * PDODatabaseConnection implements the DatabaseConnection interface
 * for PDO.
 */
namespace Virtualstyle\FormstackDevtest\Model\Repository\Database\Pdo;

use Virtualstyle\FormstackDevtest\Model\Repository as Repository;

/**
 * PDODatabaseConnection provides a concrete implementation of the
 * DatabaseConnection interface using the flexibility of PDO.
 */
class PdoConnection implements Repository\Database\ConnectionInterface
{
    /**
     * Our connection configuration data will be stored here in an array.
     *
     * @var array
     */
    protected $config = array();

    /**
     * Our PDO connection reference will be stored here.
     *
     * @var [type]
     */
    protected $connection;

    /**
     * A method to accept an array of configuration items as local config.
     *
     * @method setConfig
     *
     * @param mixed $options Loosely typed, extensible object for config
     */
    public function setConfig($options)
    {
        $this->config = $options;
    }

    /**
     * If passed a PDO connection, save it, otherwise, create a PDO connection.
     *
     * @method setConnection
     *
     * @param mixed $connection Loosely typed connection opbject
     */
    public function setConnection($connection = null)
    {
        //Type enforcement on the connection type, since
        if ($connection instanceof \PDO) {
            // If we are passed a valid PDO connection, use it.
            $this->connection = $connection;
        } elseif (!$this->connection instanceof \PDO) {
            // If there is not a valid PDO connection set already, create one.
            $this->connection = new \PDO(
                $this->config['dsn'],
                $this->config['user'],
                $this->config['password'],
                $this->config['driverOptions']
            );
            $this->connection->setAttribute(\PDO::ATTR_ERRMODE,
                \PDO::ERRMODE_EXCEPTION);
            $this->connection->setAttribute(
                \PDO::ATTR_EMULATE_PREPARES, false);
        }

        return $this->connection;
    }

    /**
     * Return a reference to our connection object.
     *
     * @method getConnection
     *
     * @return mixed
     */
    public function getConnection()
    {
        return $this->connection;
    }
}
