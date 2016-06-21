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
 * @version    2.0.4
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2016, Cartalyst LLC
 * @link       http://cartalyst.com
 */

namespace Cartalyst\Stripe\Tests;

use Cartalyst\Stripe\Stripe;
use PHPUnit_Framework_TestCase;

class FunctionalTestCase extends PHPUnit_Framework_TestCase
{
    /**
     * The Stripe API instance.
     *
     * @var \Cartalyst\Stripe\Stripe
     */
    protected $stripe;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        $this->stripe = new Stripe();
    }

    protected function createCoupon()
    {
        return $this->stripe->coupons()->create([
            'percent_off' => 50,
            'duration'    => 'forever',
            'id'          => '50-PERCENT-OFF-'.time().rand(),
        ]);
    }

    protected function createCustomer(array $parameters = [])
    {
        return $this->stripe->customers()->create(array_merge([
            'email' => 'john@doe.com',
        ], $parameters));
    }

    protected function createPlan()
    {
        return $this->stripe->plans()->create([
            'amount'               => 30.00,
            'currency'             => 'USD',
            'interval'             => 'month',
            'name'                 => 'Monthly (30$)',
            'statement_descriptor' => 'Monthly Subscription.',
            'id'                   => 'monthly-'.time().rand(),
        ]);
    }

    protected function createProduct()
    {
        return $this->stripe->products()->create([
            'name'        => 'T-shirt',
            'attributes'  => [ 'size', 'gender' ],
            'description' => 'Comfortable gray cotton t-shirts',
        ]);
    }

    protected function createSku($productId)
    {
        return $this->stripe->skus()->create([
            'product'   => $productId,
            'price'     => 1500,
            'currency'  => 'usd',
            'inventory' => [
                'type'     => 'finite',
                'quantity' => 500
            ],
            'attributes' => [
                'size'   => 'Medium',
                'gender' => 'Unisex',
            ],
        ]);
    }


    protected function createCardThroughArray($customerId)
    {
        return $this->stripe->cards()->create($customerId, [
            'exp_month' => 10,
            'cvc'       => 314,
            'exp_year'  => 2020,
            'number'    => '4242424242424242',
        ]);
    }

    protected function createCardThroughToken($customerId)
    {
        $token = $this->stripe->tokens()->create([
            'card' => [
                'exp_month' => 10,
                'cvc'       => 314,
                'exp_year'  => 2020,
                'number'    => '4242424242424242',
            ],
        ]);

        return $this->stripe->cards()->create($customerId, $token['id']);
    }

    protected function createCharge($customerId, array $parameters = [])
    {
        $this->createCardThroughToken($customerId);

        return $this->stripe->charges()->create(array_merge([
            'currency' => 'USD',
            'amount'   => 50.49,
            'customer' => $customerId,
        ], $parameters));
    }

    protected function createSubscription($customerId, array $parameters = [])
    {
        $this->createCardThroughToken($customerId);

        $plan = $this->createPlan();

        return $this->stripe->subscriptions()->create($customerId, array_merge([
            'plan' => $plan['id']
        ], $parameters));
    }

    protected function createOrder($skuId)
    {
        return $this->stripe->orders()->create([
            'currency' => 'usd',
            'items' => [
                [
                    'type'   => 'sku',
                    'parent' => $skuId,
                ],
            ],
            'shipping' => [
                'name'    => 'Jenny Rosen',
                'address' => [
                    'line1'       => '1234 Main street',
                    'city'        => 'Anytown',
                    'country'     => 'US',
                    'postal_code' => '123456',
                ],
            ],
            'email' => 'jenny@ros.en'
        ]);
    }

    protected function createRecipient()
    {
        return $this->stripe->recipients()->create([
            'name' => 'John Doe',
            'type' => 'individual',
        ]);
    }

    protected function createInvoice($customerId, array $parameters = [])
    {
        return $this->stripe->invoices()->create($customerId, $parameters);
    }

    protected function createInvoiceItem($customerId, array $parameters = [])
    {
        return $this->stripe->invoiceItems()->create($customerId, array_merge([
            'amount'      => '10.00',
            'currency'    => 'usd',
            'description' => 'One-time setup fee.'
        ], $parameters));
    }

    protected function createAnInvoiceAndInvoiceItems($customerId, $amountOfInvoiceItems = 2)
    {
        for ($i=0; $i < $amountOfInvoiceItems; $i++) {
            $this->createInvoiceItem($customerId);
        }

        return $this->createInvoice($customerId);
    }

    protected function getRandomEmail()
    {
        return rand().time().'-john@doe.com';
    }

    // protected function createBankAccount()
    // {
    //     $accountId = $this->stripe->account()->details()['id'];

    //     $bankAccountToken = $this->stripe->tokens()->create([
    //         'bank_account' => [
    //             'country'        => 'US',
    //             'routing_number' => '110000000',
    //             'account_number' => '000123456789',
    //         ],
    //     ]);

    //     return $this->stripe->externalAccounts()->create($accountId, [
    //         'external_account' => $bankAccountToken['id'],
    //     ]);
    // }

    // protected function createTransfer()
    // {
    //     $bank = $this->createBankAccount();

    //     $customer = $this->createCustomer();

    //     for ($i=0; $i < 4; $i++) {
    //         $this->createCharge($customer['id']);
    //     }

    //     return $this->stripe->transfers()->create([
    //         'currency'    => 'USD',
    //         'amount'      => 50.49,
    //         'destination' => $bank['id'],
    //     ]);
    // }
}
