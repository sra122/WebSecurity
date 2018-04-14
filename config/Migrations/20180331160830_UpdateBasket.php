<?php
use Migrations\AbstractMigration;

class UpdateBasket extends AbstractMigration
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
            ->addColumn('cookieuser', 'string', ['after' => 'id', 'limit' => 255])
            ->update();
    }
}
