<?php
use Migrations\AbstractMigration;

class UpdateBasketQuantity extends AbstractMigration
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
            ->addColumn('quantity', 'integer', ['after' => 'item_id', 'limit' => 10])
            ->update();
    }
}
