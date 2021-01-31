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
 * @version    2.4.3
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2021, Cartalyst LLC
 * @link       https://cartalyst.com
 */

namespace Cartalyst\Stripe\Tests\Api\Radar;

use Cartalyst\Stripe\Tests\FunctionalTestCase;
use Cartalyst\Stripe\Exception\NotFoundException;

class ValueListItemsTest extends FunctionalTestCase
{
    /** @test */
    public function it_can_create_a_new_value_list_item()
    {
        $alias = 'custom_ip_blocklist_'.rand();

        $valueList = $this->stripe->radar()->valueLists()->create([
            'alias' => $alias,
            'name'  => 'Custom IP Blocklist',
        ]);

        $valueListItem = $this->stripe->radar()->valueListItems()->create([
            'value_list' => $valueList['id'],
            'value' => '1.2.3.4',
        ]);

        $this->assertSame('1.2.3.4', $valueListItem['value']);
        $this->assertSame($valueList['id'], $valueListItem['value_list']);
    }

    /** @test */
    public function it_can_find_an_existing_value_list_item()
    {
        $alias = 'custom_ip_blocklist_'.rand();

        $valueList = $this->stripe->radar()->valueLists()->create([
            'alias' => $alias,
            'name'  => 'Custom IP Blocklist',
        ]);

        $valueListItem = $this->stripe->radar()->valueListItems()->create([
            'value_list' => $valueList['id'],
            'value' => '1.2.3.4',
        ]);

        $valueListItem = $this->stripe->radar()->valueListItems()->find($valueListItem['id']);

        $this->assertSame('1.2.3.4', $valueListItem['value']);
        $this->assertSame($valueList['id'], $valueListItem['value_list']);
    }

    /** @test */
    public function it_will_throw_an_exception_when_searching_for_a_non_existing_value_list_item()
    {
        $this->expectException(NotFoundException::class);

        $this->stripe->radar()->valueListItems()->find(time().rand());
    }

    /** @test */
    public function it_can_delete_an_existing_value_list_item()
    {
        $alias = 'custom_ip_blocklist_'.rand();

        $valueList = $this->stripe->radar()->valueLists()->create([
            'alias' => $alias,
            'name'  => 'Custom IP Blocklist',
        ]);

        $valueListItem = $this->stripe->radar()->valueListItems()->create([
            'value_list' => $valueList['id'],
            'value' => '1.2.3.4',
        ]);

        $valueListItem = $this->stripe->radar()->valueListItems()->delete($valueListItem['id']);

        $this->assertTrue($valueListItem['deleted']);
    }

    /** @test */
    public function it_can_retrieve_all_value_lists()
    {
        $alias = 'custom_ip_blocklist_'.rand();

        $valueList = $this->stripe->radar()->valueLists()->create([
            'alias' => $alias,
            'name'  => 'Custom IP Blocklist',
        ]);

        $valueListItem = $this->stripe->radar()->valueListItems()->create([
            'value_list' => $valueList['id'],
            'value' => '1.2.3.4',
        ]);

        $valueListItems = $this->stripe->radar()->valueListItems()->all([
            'value_list' => $valueList['id'],
        ]);

        $this->assertCount(1, $valueListItems['data']);
    }
}
