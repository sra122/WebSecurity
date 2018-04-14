<?php
use Migrations\AbstractMigration;

class Addcookies extends AbstractMigration
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
        $this->table('cookie')
            ->addColumn('cookieuser', 'string', ['limit' => 255])
            ->addColumn('user_id', 'integer', ['default' => null, 'limit' => 11, 'null' => false])
            ->addColumn('logged_in', 'boolean', ['default' => false])
            ->addColumn('login_expire', 'datetime', ['null' => true, 'default' => null])
            ->addColumn('created', 'datetime', ['default' => null, 'null' => true])
            ->addColumn('modified', 'datetime', ['default' => null, 'null' => true])
            ->addForeignKey('user_id', 'user', 'id', array('delete'=> 'CASCADE', 'update'=> 'NO_ACTION'))
            ->create();

        $this->table('orders')
            ->addColumn('orderdate', 'datetime', ['after' => 'amount', 'limit' => 100])
            ->update();
    }
}
