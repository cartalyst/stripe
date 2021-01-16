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
 * @version    2.4.2
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2020, Cartalyst LLC
 * @link       https://cartalyst.com
 */

namespace Cartalyst\Stripe\Tests;

use Cartalyst\Stripe\Stripe;
use PHPUnit\Framework\TestCase;

class FunctionalTestCase extends TestCase
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
    public function setUp(): void
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

    protected function createPlan(array $parameters = [])
    {
        return $this->stripe->plans()->create(array_merge([
            'amount'               => 30.00,
            'currency'             => 'USD',
            'interval'             => 'month',
            'name'                 => 'Monthly (30$)',
            'statement_descriptor' => 'Monthly Subscription.',
            'id'                   => 'monthly-'.time().rand(),
        ], $parameters));
    }

    protected function createProduct()
    {
        return $this->stripe->products()->create([
            'name'        => 'T-shirt',
            'attributes'  => [ 'size', 'gender' ],
            'description' => 'Comfortable gray cotton t-shirts',
        ]);
    }

    protected function createPrice($productId, $recurring = true)
    {
    	  $parameters = [
			      'product'     => $productId,
			      'unit_amount' => 1500,
			      'currency'    => 'USD',
	      ];

    	  if($recurring) {
		    	  $parameters['recurring'] = [
					      'interval'       => 'week',
					      'interval_count' => '2',
	          ];
	      }

        return $this->stripe->prices()->create($parameters);
    }

    protected function createSku($productId)
    {
        return $this->stripe->skus()->create([
            'product'   => $productId,
            'price'     => 15.00,
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

    protected function createCardToken()
    {
        return $this->stripe->tokens()->create([
            'card' => [
                'exp_month' => date('m'),
                'cvc'       => 314,
                'exp_year'  => date('Y', strtotime('+1 year')),
                'number'    => '4242424242424242',
            ],
        ]);
    }

    protected function createBankAccountToken()
    {
        return $this->stripe->tokens()->create([
            'bank_account' => [
                'country'             => 'US',
                'currency'            => 'usd',
                'account_holder_name' => 'Jane Austen',
                'account_holder_type' => 'individual',
                'routing_number'      => '110000000',
                'account_number'      => '000123456789',
            ],
        ]);
    }

    protected function createBankAccountThroughArray($customerId)
    {
        return $this->stripe->bankAccounts()->create($customerId, [
            'source' => [
                'country'             => 'US',
                'currency'            => 'usd',
                'account_holder_name' => 'Jane Austen',
                'account_holder_type' => 'individual',
                'routing_number'      => '110000000',
                'account_number'      => '000123456789',
            ],
        ]);
    }

    protected function createBankAccountThroughToken($customerId)
    {
        $token = $this->createBankAccountToken();

        return $this->stripe->bankAccounts()->create($customerId, $token['id']);
    }

    protected function createCardThroughArray($customerId)
    {
        return $this->stripe->cards()->create($customerId, [
            'source' => [
                'exp_month' => date('m'),
                'cvc'       => 314,
                'exp_year'  => date('Y', strtotime('+1 year')),
                'number'    => '4242424242424242',
                'currency'  => 'usd',
            ],
            'metadata' => ['foo' => 'bar']
        ]);
    }

    protected function createCardThroughToken($customerId)
    {
        $token = $this->createCardToken();

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
            // 'plan' => $plan['id'],
            'items' => [
                ['plan' => $plan['id']]
            ],
        ], $parameters));
    }

    protected function createSubscriptionItem($subscription, $plan)
    {
        return $this->stripe->subscriptionItems()->create($subscription['id'], $plan['id']);
    }

    protected function createOrder(array $items)
    {
        return $this->stripe->orders()->create([
            'currency' => 'usd',
            'items' => $items,
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

    protected function createTestManagedAccount()
    {
        return $this->stripe->account()->create([
            'type' => 'custom',
            'country' => 'US',
            'payout_schedule' => [
                'interval' => 'manual',
            ],
            'external_account' => [
                'object' => 'bank_account',
                'country' => 'US',
                'currency' => 'usd',
                'routing_number' => '110000000',
                'account_number' => '000123456789',
            ],
            'legal_entity' => [
                'type'               => 'individual',
                'personal_id_number' => '000000000',
                'type'               => 'individual',
                'dob'                => [ 'year' => '1980', 'month' => '01', 'day' => '01'],
                'first_name'         => 'John',
                'last_name'          => 'Doe',
                'address' => [
                    'line1'       => '1234 Main Street',
                    'postal_code' => '94110',
                    'city'        => 'San Francisco',
                ],
                'personal_address' => [
                    'line1'       => '1234 Main Street',
                    'postal_code' => '94110',
                    'city'        => 'San Francisco',
                ],
            ],
            'tos_acceptance' => [ 'date' => time(), 'ip' => '127.0.0.1'],
        ]);
    }

    public function createSetupIntent(array $parameters = [])
    {
        return $this->stripe->setupIntents()->create($parameters);
    }
}
