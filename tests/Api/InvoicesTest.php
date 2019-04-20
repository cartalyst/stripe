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
 * @version    2.1.4
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2018, Cartalyst LLC
 * @link       http://cartalyst.com
 */

namespace Cartalyst\Stripe\Tests\Api;

use Cartalyst\Stripe\Tests\FunctionalTestCase;

class InvoicesTest extends FunctionalTestCase
{
    /** @test */
    public function it_can_create_a_new_invoice()
    {
        $customer = $this->createCustomer();

        $customerId = $customer['id'];

        $card = $this->createCardThroughToken($customerId);

        $this->createInvoiceItem($customerId);
        $this->createInvoiceItem($customerId);

        $invoice = $this->createInvoice($customerId);

        $this->assertFalse($invoice['paid']);
        $this->assertSame(2000, $invoice['amount_due']);
        $this->assertCount(2, $invoice['lines']['data']);
    }

    /** @test */
    public function it_can_retrieve_an_invoice()
    {
        $customer = $this->createCustomer();

        $customerId = $customer['id'];

        $card = $this->createCardThroughToken($customerId);

        $this->createInvoiceItem($customerId);
        $this->createInvoiceItem($customerId);

        $invoice = $this->createInvoice($customerId);

        $invoice = $this->stripe->invoices()->find($invoice['id']);

        $this->assertSame(2000, $invoice['amount_due']);
        $this->assertCount(2, $invoice['lines']['data']);
    }

    /** @test */
    public function it_can_update_an_invoice()
    {
        $customer = $this->createCustomer();

        $customerId = $customer['id'];

        $card = $this->createCardThroughToken($customerId);

        $this->createInvoiceItem($customerId);
        $this->createInvoiceItem($customerId);

        $invoice = $this->createInvoice($customerId);

        $invoice = $this->stripe->invoices()->update($invoice['id'], [
            'description' => 'Pay for goods.',
        ]);

        $this->assertSame('Pay for goods.', $invoice['description']);
    }

    /** @test */
    public function it_can_retrieve_an_invoice_line_items()
    {
        $customer = $this->createCustomer();

        $customerId = $customer['id'];

        $card = $this->createCardThroughToken($customerId);

        $this->createInvoiceItem($customerId);
        $this->createInvoiceItem($customerId);

        $invoice = $this->createInvoice($customerId);

        $lineItems = $this->stripe->invoices()->lineItems($invoice['id']);

        $this->assertCount(2, $lineItems['data']);
    }

    /** @test */
    public function it_can_retrieve_the_upcoming_invoice()
    {
        $customer = $this->createCustomer();

        $customerId = $customer['id'];

        $card = $this->createCardThroughToken($customerId);

        $this->createInvoiceItem($customerId);
        $this->createInvoiceItem($customerId);

        $upcomingInvoice = $this->stripe->invoices()->upcomingInvoice($customerId);

        $this->assertCount(2, $upcomingInvoice['lines']['data']);
    }

    /** @test */
    public function it_can_delete_a_draft_invoice()
    {
        $customer = $this->createCustomer();

        $customerId = $customer['id'];

        $card = $this->createCardThroughToken($customerId);

        $this->createInvoiceItem($customerId);

        $invoice = $this->createInvoice($customerId, [
            'auto_advance' => false,
        ]);

        $this->assertFalse($invoice['paid']);

        $invoice = $this->stripe->invoices()->delete($invoice['id']);

        $this->assertTrue($invoice['deleted']);
    }

    /** @test */
    public function it_can_finalize_an_invoice()
    {
        $customer = $this->createCustomer();

        $customerId = $customer['id'];

        $card = $this->createCardThroughToken($customerId);

        $this->createInvoiceItem($customerId);

        $invoice = $this->createInvoice($customerId, [
            'auto_advance' => false,
        ]);

        $this->assertFalse($invoice['paid']);

        $invoice = $this->stripe->invoices()->finalize($invoice['id']);

        $this->assertSame('open', $invoice['status']);
        $this->assertNotNull($invoice['status_transitions']['finalized_at']);
        $this->assertNull($invoice['status_transitions']['voided_at']);
    }

    /** @test */
    public function it_can_pay_an_invoice()
    {
        $customer = $this->createCustomer();

        $customerId = $customer['id'];

        $card = $this->createCardThroughToken($customerId);

        $this->createInvoiceItem($customerId);
        $this->createInvoiceItem($customerId);

        $invoice = $this->createInvoice($customerId);

        $this->assertFalse($invoice['paid']);

        $invoice = $this->stripe->invoices()->pay($invoice['id']);

        $this->assertTrue($invoice['paid']);
    }

    /** @test */
    public function it_can_void_an_invoice()
    {
        $customer = $this->createCustomer();

        $customerId = $customer['id'];

        $card = $this->createCardThroughToken($customerId);

        $this->createInvoiceItem($customerId);

        $invoice = $this->createInvoice($customerId);

        $this->stripe->invoices()->finalize($invoice['id']);

        $this->assertFalse($invoice['paid']);

        $invoice = $this->stripe->invoices()->void($invoice['id']);

        $this->assertSame('void', $invoice['status']);
        $this->assertNotNull($invoice['status_transitions']['voided_at']);
    }

    /** @test */
    public function it_can_mark_an_invoice_as_uncollectible()
    {
        $customer = $this->createCustomer();

        $customerId = $customer['id'];

        $card = $this->createCardThroughToken($customerId);

        $this->createInvoiceItem($customerId);

        $invoice = $this->createInvoice($customerId);

        $this->stripe->invoices()->finalize($invoice['id']);

        $this->assertFalse($invoice['paid']);

        $invoice = $this->stripe->invoices()->markUncollectible($invoice['id']);

        $this->assertSame('uncollectible', $invoice['status']);
        $this->assertNotNull($invoice['status_transitions']['marked_uncollectible_at']);
    }

    /** @test */
    public function it_can_send_an_invoice()
    {
        $customer = $this->createCustomer();

        $customerId = $customer['id'];

        $card = $this->createCardThroughToken($customerId);

        $this->createInvoiceItem($customerId);
        $this->createInvoiceItem($customerId);

        $invoice = $this->createInvoice($customerId, [
            'billing'        => 'send_invoice',
            'days_until_due' => 1,
        ]);

        $this->assertFalse($invoice['paid']);

        $invoice = $this->stripe->invoices()->send($invoice['id']);

        $this->assertFalse($invoice['paid']);
    }

    /** @test */
    public function it_can_retrieve_all_invoices()
    {
        $customer = $this->createCustomer();

        $customerId = $customer['id'];

        $card = $this->createCardThroughToken($customerId);

        $invoice1 = $this->createAnInvoiceAndInvoiceItems($customerId, 4);
        $invoice2 = $this->createAnInvoiceAndInvoiceItems($customerId, 2);

        $invoices = $this->stripe->invoices()->all();

        $this->assertNotEmpty($invoices['data']);
        $this->assertInternalType('array', $invoices['data']);
        $this->assertSame(6000, ($invoice1['total'] + $invoice2['total']));
        $this->assertSame(
            6, ($invoice1['lines']['total_count'] + $invoice2['lines']['total_count'])
        );
    }

    /** @test */
    public function it_can_iterate_all_invoices()
    {
        $customer = $this->createCustomer();

        $customerId = $customer['id'];

        $card = $this->createCardThroughToken($customerId);

        $invoice1 = $this->createAnInvoiceAndInvoiceItems($customerId, 4);
        $invoice2 = $this->createAnInvoiceAndInvoiceItems($customerId, 2);

        $invoices = $this->stripe->invoicesIterator([ 'customer' => $customerId ]);

        $this->assertCount(2, $invoices);
        $this->assertSame(6000, ($invoice1['total'] + $invoice2['total']));
        $this->assertSame(
            6, ($invoice1['lines']['total_count'] + $invoice2['lines']['total_count'])
        );
    }
}
