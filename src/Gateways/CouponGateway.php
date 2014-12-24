<?php namespace Cartalyst\Stripe\Gateways;/**
 * Part of the Stripe package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Cartalyst PSL License.
 *
 * This source file is subject to the Cartalyst PSL License that is
 * bundled with this package in the license.txt file.
 *
 * @package    Stripe
 * @version    1.0.0
 * @author     Cartalyst LLC
 * @license    Cartalyst PSL
 * @copyright  (c) 2011-2014, Cartalyst LLC
 * @link       http://cartalyst.com
 */

use Cartalyst\Stripe\Models\IlluminateCoupon as Coupon;

class CouponGateway extends AbstractGateway {

	public function delete()
	{

	}

	/**
	 * Stores the coupon information on local storage.
	 *
	 * @param  \Cartalyst\Stripe\Api\Response|array  $response
	 * @return \Cartalyst\Stripe\Models\IlluminateCoupon
	 */
	public function store($response)
	{
		// Get the coupon id
		$id = $response['id'];

		// Prepare the payload
		$payload = [
			'valid'              => $response['valid'],
			'currency'           => $response['currency'],
			'duration'           => $response['duration'],
			'metadata'           => $response['metadata'],
			'redeem_by'          => $response['redeem_by'],
			'stripe_id'          => $id,
			'amount_off'         => $response['amount_off'],
			'percent_off'        => $response['percent_off'],
			'times_redeemed'     => $response['times_redeemed'],
			'max_redemptions'    => $response['max_redemptions'],
			'duration_in_months' => $response['duration_in_months'],
			'created_at'         => $this->nullableTimestamp($response['created']),
		];

		// Does the coupon exist on storage?
		if ( ! $coupon = Coupon::whereStripeId($id)->first())
		{
			$coupon = Coupon::create($payload);
		}
		else
		{
			$coupon->update($payload);
		}

		return $coupon;
	}

}
