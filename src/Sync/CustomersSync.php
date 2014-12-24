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

use Cartalyst\Stripe\Gateways\CustomerGateway;

class CustomersSync extends AbstractSync {

	/**
	 * {@inheritDoc}
	 */
	public function execute()
	{
		// Instantiate the coupon gateway
		#$gateway = new CouponGateway;

		// Get all the available customers
		$customers = array_reverse($this->laravel['stripe']->customersIterator()->toArray());

		// Loop through all the available customers
		foreach ($customers as $customer)
		{
			# need to loop through the selected models and figure
			# out the  proper classes from it..

			# then i can synchronize each customer data
		}
	}

}
