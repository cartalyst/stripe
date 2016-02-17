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
 * @version    2.0.2
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2016, Cartalyst LLC
 * @link       http://cartalyst.com
 */

namespace Cartalyst\Stripe\Tests\Api;

use Cartalyst\Stripe\Tests\FunctionalTestCase;

class RecipientsTest extends FunctionalTestCase
{
    /** @test */
    public function it_can_create_a_recipient()
    {
        $recipient = $this->createRecipient();

        $this->assertSame('John Doe', $recipient['name']);
    }

    /** @test */
    public function it_can_find_a_recipient()
    {
        $recipient = $this->createRecipient();

        $recipient = $this->stripe->recipients()->find($recipient['id']);

        $this->assertSame('John Doe', $recipient['name']);
    }

    /**
     * @test
     * @expectedException \Cartalyst\Stripe\Exception\NotFoundException
     */
    public function it_will_throw_an_exception_when_searching_for_a_non_existing_recipient()
    {
        $this->stripe->recipients()->find(time().rand());
    }

    /** @test */
    public function it_can_update_a_recipient()
    {
        $recipient = $this->createRecipient();

        $recipient = $this->stripe->recipients()->update($recipient['id'], [
            'name' => 'Johnathan Doe',
        ]);

        $this->assertSame('Johnathan Doe', $recipient['name']);
    }

    /** @test */
    public function it_can_delete_a_recipient()
    {
        $recipient = $this->createRecipient();

        $recipient = $this->stripe->recipients()->find($recipient['id']);

        $this->assertSame('John Doe', $recipient['name']);

        $recipient = $this->stripe->recipients()->delete($recipient['id']);

        $this->assertTrue($recipient['deleted']);
    }

    /** @test */
    public function it_can_retrieve_all_recipients()
    {
        $this->createRecipient();

        $recipients = $this->stripe->recipients()->all();

        $this->assertNotEmpty($recipients['data']);
        $this->assertInternalType('array', $recipients['data']);
    }

    /** @test */
    public function it_can_iterate_all_recipients()
    {
        for ($i=0; $i < 5; $i++) {
            $this->createRecipient();
        }

        $this->stripe->recipientsIterator();
    }
}
