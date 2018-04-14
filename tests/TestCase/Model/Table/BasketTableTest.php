<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\BasketTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\BasketTable Test Case
 */
class BasketTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\BasketTable
     */
    public $Basket;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.basket',
        'app.item',
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
        $config = TableRegistry::exists('Basket') ? [] : ['className' => BasketTable::class];
        $this->Basket = TableRegistry::get('Basket', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Basket);

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

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
