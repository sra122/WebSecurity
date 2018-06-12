<?php
use Migrations\AbstractMigration;

class UpdateUserTable extends AbstractMigration
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
            ->addColumn('credit_card', 'integer', ['after' => 'address', 'limit' => 16])
            ->update();
    }
}
