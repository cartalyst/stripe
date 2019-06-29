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
 * @version    2.2.3
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2019, Cartalyst LLC
 * @link       http://cartalyst.com
 */

namespace Cartalyst\Stripe\Tests\Api;

use Cartalyst\Stripe\Tests\FunctionalTestCase;

class CreditNotesTest extends FunctionalTestCase
{
    /** @test */
    public function it_can_create_a_new_credit_note()
    {
        $customer = $this->createCustomer();

        $this->createInvoiceItem($customer['id'], [
            'amount' => 1000
        ]);

        $invoice = $this->createInvoice($customer['id']);

        $invoice = $this->stripe->invoices()->finalize($invoice['id']);

        $creditNote = $this->stripe->creditNotes()->create([
            'amount' => 500,
            'invoice' => $invoice['id'],
        ]);

        $this->assertSame(50000, $creditNote['amount']);
        $this->assertSame('issued', $creditNote['status']);
    }

    /** @test */
    public function it_can_find_an_existing_credit_note()
    {
        $customer = $this->createCustomer();

        $this->createInvoiceItem($customer['id'], [
            'amount' => 1000
        ]);

        $invoice = $this->createInvoice($customer['id']);

        $invoice = $this->stripe->invoices()->finalize($invoice['id']);

        $creditNote = $this->stripe->creditNotes()->create([
            'amount' => 500,
            'invoice' => $invoice['id'],
        ]);

        $creditNote = $this->stripe->creditNotes()->find($creditNote['id']);

        $this->assertSame(50000, $creditNote['amount']);
        $this->assertSame('issued', $creditNote['status']);
    }

    /**
     * @test
     * @expectedException \Cartalyst\Stripe\Exception\NotFoundException
     */
    public function it_will_throw_an_exception_when_searching_for_a_non_existing_credit_note()
    {
        $this->stripe->creditNotes()->find(time().rand());
    }

    /** @test */
    public function it_can_update_an_existing_credit_note()
    {
        $customer = $this->createCustomer();

        $this->createInvoiceItem($customer['id'], [
            'amount' => 1000
        ]);

        $invoice = $this->createInvoice($customer['id']);

        $invoice = $this->stripe->invoices()->finalize($invoice['id']);

        $creditNote = $this->stripe->creditNotes()->create([
            'amount' => 500,
            'invoice' => $invoice['id'],
        ]);

        $creditNote = $this->stripe->creditNotes()->update($creditNote['id'], [
            'metadata' => ['foo' => 'bar'],
        ]);

        $this->assertSame(['foo' => 'bar'], $creditNote['metadata']);
    }

    /** @test */
    public function it_can_void_an_existing_credit_note()
    {
        $customer = $this->createCustomer();

        $this->createInvoiceItem($customer['id'], [
            'amount' => 1000
        ]);

        $invoice = $this->createInvoice($customer['id']);

        $invoice = $this->stripe->invoices()->finalize($invoice['id']);

        $creditNote = $this->stripe->creditNotes()->create([
            'amount' => 500,
            'invoice' => $invoice['id'],
        ]);

        $creditNote = $this->stripe->creditNotes()->void($creditNote['id']);

        $this->assertSame(50000, $creditNote['amount']);
        $this->assertSame('void', $creditNote['status']);
    }

    /** @test */
    public function it_can_iterate_all_credit_notes()
    {
        $customer = $this->createCustomer();

        $this->createInvoiceItem($customer['id'], [
            'amount' => 1000
        ]);

        $invoice = $this->createInvoice($customer['id']);

        $invoice = $this->stripe->invoices()->finalize($invoice['id']);

        $this->stripe->creditNotes()->create([
            'amount' => 500,
            'invoice' => $invoice['id'],
        ]);

        $this->stripe->creditNotes()->create([
            'amount' => 100,
            'invoice' => $invoice['id'],
        ]);

        $creditNotes = $this->stripe->creditNotesIterator([
            'invoice' => $invoice['id'],
        ]);

        $this->assertCount(2, $creditNotes);
    }
}
