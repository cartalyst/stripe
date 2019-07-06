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
 * @version    2.2.7
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2019, Cartalyst LLC
 * @link       http://cartalyst.com
 */

namespace Cartalyst\Stripe\Tests\Api\Account;

use Cartalyst\Stripe\Tests\FunctionalTestCase;

class PersonsTest extends FunctionalTestCase
{
    /** @test */
    public function it_can_create_a_new_person()
    {
        $email = $this->getRandomEmail();

        $account = $this->stripe->account()->create([
            'type' => 'custom', 'email' => $email,
        ]);

        $person = $this->stripe->account()->persons()->create($account['id'], [
            'first_name' => 'John',
            'last_name'  => 'Doe',
        ]);

        $this->assertSame($account['id'], $person['account']);
        $this->assertSame('John', $person['first_name']);
        $this->assertSame('Doe', $person['last_name']);
    }

    /** @test */
    public function it_can_find_an_existing_person()
    {
        $email = $this->getRandomEmail();

        $account = $this->stripe->account()->create([
            'type' => 'custom', 'email' => $email,
        ]);

        $person = $this->stripe->account()->persons()->create($account['id'], [
            'first_name' => 'John',
            'last_name'  => 'Doe',
        ]);

        $person = $this->stripe->account()->persons()->find($account['id'], $person['id']);

        $this->assertSame($account['id'], $person['account']);
        $this->assertSame('John', $person['first_name']);
        $this->assertSame('Doe', $person['last_name']);
    }

    /**
     * @test
     * @expectedException \Cartalyst\Stripe\Exception\NotFoundException
     */
    public function it_will_throw_an_exception_when_searching_for_a_non_existing_person()
    {
        $email = $this->getRandomEmail();

        $account = $this->stripe->account()->create([
            'type' => 'custom', 'email' => $email,
        ]);

        $this->stripe->account()->persons()->find($account['id'], time().rand());
    }

    /** @test */
    public function it_can_update_a_person()
    {
        $email = $this->getRandomEmail();

        $account = $this->stripe->account()->create([
            'type' => 'custom', 'email' => $email,
        ]);

        $person = $this->stripe->account()->persons()->create($account['id'], [
            'first_name' => 'John',
            'last_name'  => 'Doe',
        ]);

        $this->assertSame([], $person['metadata']);

        $person = $this->stripe->account()->persons()->update($account['id'], $person['id'], [
            'metadata' => ['foo' => 'bar'],
        ]);

        $this->assertSame(['foo' => 'bar'], $person['metadata']);
    }

    /** @test */
    public function it_can_delete_a_person()
    {
        $email = $this->getRandomEmail();

        $account = $this->stripe->account()->create([
            'type' => 'custom', 'email' => $email,
        ]);

        $person = $this->stripe->account()->persons()->create($account['id'], [
            'first_name' => 'John',
            'last_name'  => 'Doe',
        ]);

        $response = $this->stripe->account()->persons()->delete($account['id'], $person['id']);

        $this->assertSame($person['id'], $response['id']);
        $this->assertTrue($response['deleted']);
    }

    /** @test */
    public function it_can_retrieve_all_persons()
    {
        $email = $this->getRandomEmail();

        $account = $this->stripe->account()->create([
            'type' => 'custom', 'email' => $email,
        ]);

        $this->stripe->account()->persons()->create($account['id'], [
            'first_name' => 'John',
            'last_name'  => 'Doe',
        ]);

        $persons = $this->stripe->account()->persons()->all($account['id']);

        $this->assertCount(2, $persons['data']);
        $this->assertInternalType('array', $persons['data']);
    }
}
