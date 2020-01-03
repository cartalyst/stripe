<?php

/**
 * Part of the Stripe package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the 3-clause BSD License.
 *
 * This source file is subject to the 3-clause BSD License that is
 * bundled with this package in the LICENSE file.
 *
 * @package    Stripe
 * @version    2.4.0
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2020, Cartalyst LLC
 * @link       http://cartalyst.com
 */

namespace Cartalyst\Stripe\Tests\Api\Radar;

use Cartalyst\Stripe\Tests\FunctionalTestCase;

class ValueListsTest extends FunctionalTestCase
{
    /** @test */
    public function it_can_create_a_new_value_list()
    {
        $alias = 'custom_ip_blocklist_'.rand();

        $valueList = $this->stripe->radar()->valueLists()->create([
            'alias' => $alias,
            'name'  => 'Custom IP Blocklist',
        ]);

        $this->assertSame($alias, $valueList['alias']);
        $this->assertSame('Custom IP Blocklist', $valueList['name']);
    }

    /** @test */
    public function it_can_find_an_existing_value_list()
    {
        $alias = 'custom_ip_blocklist_'.rand();

        $valueList = $this->stripe->radar()->valueLists()->create([
            'alias' => $alias,
            'name'  => 'Custom IP Blocklist',
        ]);

        $valueList = $this->stripe->radar()->valueLists()->find($valueList['id']);

        $this->assertSame($alias, $valueList['alias']);
        $this->assertSame('Custom IP Blocklist', $valueList['name']);
    }

    /**
     * @test
     * @expectedException \Cartalyst\Stripe\Exception\NotFoundException
     */
    public function it_will_throw_an_exception_when_searching_for_a_non_existing_value_list()
    {
        $this->stripe->radar()->valueLists()->find(time().rand());
    }

    /** @test */
    public function it_can_update_an_existing_value_list()
    {
        $alias = 'custom_ip_blocklist_'.rand();

        $valueList = $this->stripe->radar()->valueLists()->create([
            'alias' => $alias,
            'name'  => 'Custom IP Blocklist',
        ]);

        $this->assertSame([], $valueList['metadata']);

        $valueList = $this->stripe->radar()->valueLists()->update($valueList['id'], [
            'metadata' => ['foo' => 'bar'],
        ]);

        $this->assertSame($alias, $valueList['alias']);
        $this->assertSame('Custom IP Blocklist', $valueList['name']);
        $this->assertSame(['foo' => 'bar'], $valueList['metadata']);
    }

    /** @test */
    public function it_can_delete_an_existing_value_list()
    {
        $alias = 'custom_ip_blocklist_'.rand();

        $valueList = $this->stripe->radar()->valueLists()->create([
            'alias' => $alias,
            'name'  => 'Custom IP Blocklist',
        ]);

        $valueList = $this->stripe->radar()->valueLists()->delete($valueList['id']);

        $this->assertTrue($valueList['deleted']);
    }

    /** @test */
    public function it_can_retrieve_all_value_lists()
    {
        $alias = 'custom_ip_blocklist_'.rand();

        $this->stripe->radar()->valueLists()->create([
            'alias' => $alias,
            'name'  => 'Custom IP Blocklist',
        ]);

        $valueLists = $this->stripe->radar()->valueLists()->all();

        $this->assertNotEmpty($valueLists['data']);
        $this->assertInternalType('array', $valueLists['data']);
    }
}
