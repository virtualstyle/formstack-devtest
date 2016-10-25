<?php

use Phinx\Migration\AbstractMigration;

class FormstackMigration extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        
        // create the table
        $table = $this->table('user');
        $table->addColumn('username',  'string', array('limit' => 64, 'null' => false))
            ->addColumn('password',  'string', array('limit' => 41, 'null' => false))
            ->addColumn('email',  'string', array('limit' => 128, 'null' => false))
            ->addColumn('firstname',  'string', array('limit' => 32, 'null' => false))
            ->addColumn('lastname',  'string', array('limit' => 32, 'null' => false))
            ->create();

    }
}
