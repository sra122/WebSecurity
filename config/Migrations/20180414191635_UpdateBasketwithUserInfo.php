<?php
use Migrations\AbstractMigration;

class UpdateBasketwithUserInfo extends AbstractMigration
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
        $this->table('basket')
            ->addColumn('user_id', 'integer', ['after' => 'item_id', 'limit' => 11, 'default' => null, 'null' => false])
            ->addForeignKey('user_id', 'user', 'id', array('delete'=> 'CASCADE', 'update'=> 'NO_ACTION'))
            ->update();
    }
}
