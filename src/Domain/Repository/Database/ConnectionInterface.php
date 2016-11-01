<?php
/**
 * This file is part of virtualstyle/formstack-devtest.
 * https://github.com/virtualstyle/formstack-devtest.
 *
 * @license https://opensource.org/licenses/MIT MIT
 */

namespace Virtualstyle\FormstackDevtest\Domain\Repository\Database;

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
