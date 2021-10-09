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
 * @version    2.4.6
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2021, Cartalyst LLC
 * @link       https://cartalyst.com
 */

namespace Cartalyst\Stripe\Api;

class Refunds extends Api
{
    /**
     * Creates a new refund for the given charge or payment intent.
     *
     * @param  string  $paymentId
     * @param  int  $amount
     * @param  array  $parameters
     * @return array
     */
    public function create($paymentId, $amount = null, array $parameters = [])
    {
        $paymentType = $this->getPaymentType($paymentId);

        $parameters = array_merge($parameters, [
            'amount'     => $amount,
            $paymentType => $paymentId,
        ]);

        return $this->_post('refunds', $parameters);
    }

    /**
     * Retrieves an existing refund from the given charge.
     *
     * @param  string  $chargeId
     * @param  string|null  $refundId
     * @return array
     */
    public function find($chargeId, $refundId = null)
    {
        if (! $refundId) {
            return $this->_get("refunds/{$chargeId}");
        }

        return $this->_get("refunds/{$refundId}");
    }

    /**
     * Updates an existing refund.
     *
     * @param  string  $chargeId
     * @param  string  $refundId
     * @param  array  $parameters
     * @return array
     */
    public function update($chargeId, $refundId, array $parameters = [])
    {
        return $this->_post("refunds/{$refundId}", $parameters);
    }

    /**
     * Lists all the refunds of the current Stripe account
     * or lists all the refunds for the given charge or payment intent.
     *
     * @param  string|null  $paymentId
     * @param  array  $parameters
     * @return array
     */
    public function all($paymentId = null, array $parameters = [])
    {
        if ($paymentId) {
            $paymentType = $this->getPaymentType($paymentId);

            $parameters = array_merge($parameters, [
                $paymentType => $paymentId,
            ]);
        }

        return $this->_get('refunds', $parameters);
    }

    /**
     * Returns the payment type for the provided payment id.
     *
     * @param  string  $paymentId
     * @return void
     */
    private function getPaymentType(string $paymentId)
    {
        return substr($paymentId, 0, 2) === 'ch' ? 'charge' : 'payment_intent';
    }
}
