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
 * @version    2.3.0
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2019, Cartalyst LLC
 * @link       http://cartalyst.com
 */

namespace Cartalyst\Stripe\Tests\Api\Radar;

use Cartalyst\Stripe\Tests\FunctionalTestCase;

class EarlyFraudWarning extends FunctionalTestCase
{
    /**
     * @test
     * @expectedException \Cartalyst\Stripe\Exception\NotFoundException
     */
    public function it_will_throw_an_exception_when_searching_for_a_non_existing_early_fraud_warning()
    {
        $this->stripe->radar()->earlyFraudWarning()->find(time());
    }

    /** @test */
    public function it_can_retrieve_all_early_fraud_warnings()
    {
        $earlyFraudWarnings = $this->stripe->radar()->earlyFraudWarning()->all();

        $this->assertEmpty($earlyFraudWarnings['data']);
        $this->assertInternalType('array', $earlyFraudWarnings['data']);
    }
}
