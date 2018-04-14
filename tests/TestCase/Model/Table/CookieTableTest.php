<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CookieTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CookieTable Test Case
 */
class CookieTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\CookieTable
     */
    public $Cookie;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.cookie',
        'app.user',
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
        $config = TableRegistry::exists('Cookie') ? [] : ['className' => CookieTable::class];
        $this->Cookie = TableRegistry::get('Cookie', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Cookie);

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
