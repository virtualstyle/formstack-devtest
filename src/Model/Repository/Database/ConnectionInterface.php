<?php
/**
 * DatabaseConnection provides an interface for abstracting
 * and reusing data server connections as shared dependencies.
 */
namespace Virtualstyle\FormstackDevtest\Model\Repository\Database;

/**
 * DatabaseConnection provides an interface for abstracting
 * and reusing data server connections as shared dependencies.
 */
interface ConnectionInterface
{
    /**
     * Setter injection for configuration.
     *
     * @method setConfig
     *
     * @param mixed $options A loosely typed carrier of config options
     */
    public function setConfig($options);

    /**
     * Setter injection for connection.
     *
     * @method setConnection
     *
     * @param mixed $connection A loosely typed holder of a DB connection
     */
    public function setConnection($connection);

    /**
     * Expose the connection for reuse/sharing.
     *
     * @method getConnection
     *
     * @return mixed
     */
    public function getConnection();
}
