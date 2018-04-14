<?php
use Migrations\AbstractMigration;

class AddItem extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
        $this->table('item')
            ->addColumn('name', 'string', ['limit' => 100])
            ->addColumn('price', 'float', ['limit' => 10])
            ->addColumn('description', 'string', ['limit' => 100])
            ->addColumn('created', 'datetime', ['default' => null, 'null' => true])
            ->addColumn('modified', 'datetime', ['default' => null, 'null' => true])
            ->create();

        $this->table('basket')
            ->addColumn('cookieuser', 'string', ['limit' => 255])
            ->addColumn('item_id', 'integer', ['default' => null, 'limit' => 11, 'null' => false])
            ->addColumn('price', 'float', ['limit' => 20])
            ->addColumn('created', 'datetime', ['default' => null, 'null' => true])
            ->addColumn('modified', 'datetime', ['default' => null, 'null' => true])
            ->addForeignKey('item_id', 'item', 'id', array('delete'=> 'CASCADE', 'update'=> 'NO_ACTION'))
            ->create();

        $this->table('user')
           ->addColumn('firstname', 'string', ['limit' => 30])
           ->addColumn('lastname', 'string', ['limit' => 30])
           ->addColumn('address', 'string', ['limit' => 100])
           ->addColumn('email', 'string', ['limit' => 30])
           ->addColumn('password', 'string', ['limit' => 255])
           ->addColumn('created', 'datetime', ['default' => null, 'null' => true])
           ->addColumn('modified', 'datetime', ['default' => null, 'null' => true])
           ->create();

        $this->table('orders')
            ->addColumn('user_id', 'integer', ['default' => null, 'limit' => 11, 'null' => false])
            ->addColumn('item_id', 'integer', ['default' => null, 'limit' => 11, 'null' => false])
            ->addColumn('quantity', 'float', ['limit' => 5])
            ->addColumn('price', 'float', ['limit' => 15])
            ->addColumn('amount', 'float', ['limit' => 15])
            ->addColumn('created', 'datetime', ['default' => null, 'null' => true])
            ->addColumn('modified', 'datetime', ['default' => null, 'null' => true])
            ->addForeignKey('user_id', 'user', 'id', array('delete'=> 'CASCADE', 'update'=> 'NO_ACTION'))
            ->addForeignKey('item_id', 'item', 'id', array('delete'=> 'CASCADE', 'update'=> 'NO_ACTION'))
            ->create();
    }

}
