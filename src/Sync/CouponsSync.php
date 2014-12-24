<?php namespace Cartalyst\Stripe\Sync;
/**
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

use Cartalyst\Stripe\Gateways\CouponGateway;

class CouponsSync extends AbstractSync implements TypeInterface {

	/**
	 * {@inheritDoc}
	 */
	protected $name = 'coupons';

	/**
	 * {@inheritDoc}
	 */
	public function execute()
	{
		// Instantiate the coupon gateway
		$gateway = new CouponGateway;

		// Get all the available coupons
		$coupons = $this->stripe->couponsIterator();

		// Loop through all the available coupons
		foreach ($coupons as $coupon)
		{
			$gateway->store($coupon);
		}
	}

}
