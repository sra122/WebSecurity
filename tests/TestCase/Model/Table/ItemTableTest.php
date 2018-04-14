<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ItemTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ItemTable Test Case
 */
class ItemTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ItemTable
     */
    public $Item;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.item',
        'app.basket',
        'app.orders'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Item') ? [] : ['className' => ItemTable::class];
        $this->Item = TableRegistry::get('Item', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Item);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
