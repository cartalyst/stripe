<?php namespace Cartalyst\Stripe\Gateways;
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

use Cartalyst\Stripe\BillableInterface;
use Cartalyst\Stripe\Models\IlluminateDiscount;

class DiscountGateway extends AbstractGateway {

	/**
	 * Constructor.
	 *
	 * @param  \Cartalyst\Stripe\BillableInterface  $billable
	 * @param  mixed  $id
	 * @return void
	 */
	public function __construct(BillableInterface $billable, $id = null)
	{
		parent::__construct($billable);

		$discount = $this->billable->discounts()->getModel()->find($id);

		if ($discount instanceof IlluminateDiscount)
		{
			$this->discount = $discount;
		}
	}

	/**
	 * Applies a discount to the entity.
	 *
	 * @param  string  $coupon
	 * @return \Cartalyst\Stripe\Api\Models\Customer
	 */
	public function apply($coupon)
	{
		return $this->client->customers()->update([
			'id'     => $this->billable->stripe_id,
			'coupon' => $coupon,
		]);
	}

	/**
	 * Removes a previously applied discount from the entity.
	 *
	 * @return \Cartalyst\Stripe\Api\Models\Customer
	 */
	public function remove()
	{
		return $this->client->customers()->update([
			'id'     => $this->billable->stripe_id,
			'coupon' => null,
		]);
	}

}
