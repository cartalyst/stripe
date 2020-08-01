<?php

declare(strict_types=1);

/*
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
 * @version    3.0.0
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2020, Cartalyst LLC
 * @link       https://cartalyst.com
 */

namespace Cartalyst\Stripe\Tests\Api\Account;

use Cartalyst\Stripe\Tests\FunctionalTestCase;

class AccountLinkTest extends FunctionalTestCase
{
    /** @test */
    public function it_can_create_a_new_account_link()
    {
        $email = $this->getRandomEmail();

        $filePath = realpath(__DIR__.'/../../files/logo.png');

        $icon = $this->stripe->files()->create($filePath, 'business_icon');
        $logo = $this->stripe->files()->create($filePath, 'business_logo');

        $account = $this->stripe->account()->create([
            'type'          => 'custom',
            'email'         => $email,
            'business_type' => 'company',
            'company'       => [
                'name' => 'John Doe Industries',
            ],
            'settings' => [
                'branding' => [
                    'icon'          => $icon['id'],
                    'logo'          => $logo['id'],
                    'primary_color' => '#ffffff',
                ],
            ],
            'requested_capabilities' => [
                'card_payments',
                'transfers',
            ],
        ]);

        $accountLink = $this->stripe->account()->accountLinks()->create([
            'account'     => $account['id'],
            'failure_url' => 'https://example.com/failure',
            'success_url' => 'https://example.com/success',
            'type'        => 'custom_account_verification',
        ]);

        $this->assertNotNull($accountLink['url']);
        $this->assertNotNull($accountLink['created']);
        $this->assertNotNull($accountLink['expires_at']);
    }
}
