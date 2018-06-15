<?php
use Migrations\AbstractMigration;

class UpdateUserwithRole extends AbstractMigration
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
        $this->table('user')
            ->addColumn('role', 'string', ['after' => 'address', 'limit' => 20, 'default' => null])
            ->update();
    }
}
