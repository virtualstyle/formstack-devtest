<?php
/**
 * An abstract base class for mysql repositories.
 *
 * An independent, persistence-agnostic repository responsible for defining
 * clearly the interactions between the entities of a system through data
 * and behavior.
 */
namespace Virtualstyle\FormstackDevtest\Model;

/*
 * PDO is fairly mature and stable, and offers parameterized queries.
 */
use PDO;

/**
 * Due to the restrictions of the project,
 * this isn't REALLY outside the webroot.
 * But that's the idea here.
 */
require_once dirname(__FILE__).'/../../db/dbconfig.php';

/**
 * A base class for mysql repositories.
 */
abstract class MysqlRepository
{
    /**
     * Variable to hold the PDO connection object.
     *
     * @var PDO
     */
    private $connection;

    /**
     * Constructor for the class, initialize connection here.
     *
     * @method __construct
     *
     * @param PDO $connection Optional existing PDO connection object
     */
    public function __construct(PDO $connection = null)
    {
        $this->connection = $connection;

        if ($this->connection === null) {
            $this->connection = new PDO(
                'mysql:host='.DB_HOST.';dbname='.DB_NAME.'',
                DB_USER,
                DB_PASS
            );
            $this->connection->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
          );
        }
    }

    /**
     * Return this object's PDO connection.
     *
     * @method getConnection
     *
     * @return PDO
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * Commit this object's state to persistent storage.
     *
     * @method save
     *
     * @return bool
     */
    public function save()
    {
        $set_string = '';

        if (!isset($data['id']) || is_null($data['id'])) {
            $sql = 'INSERT INTO '.$table.' SET ';
            unset($data['id']);
        } else {
            $sql = 'UPDATE '.$table.' SET ';
        }

        foreach ($data as $field => $value) {
            $set_string .= $field.' = :'.$field.', ';
        }

        $set_string = trim($set_string, ', ');

        $sql .= $set_string;
        die($sql);
        //$statement = $connection->prepare($sql);
    }

    /**
     * Delete a User object from persistent storage.
     *
     * @method delete
     *
     * @return bool
     */
    public function delete()
    {
    }
}
