<?php namespace Cartalyst\Stripe\Laravel;
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

use Cartalyst\Stripe\BillableTrait as Billable;

trait BillableTrait {

	use Billable;

	/**
	 * The card model name.
	 *
	 * @var string
	 */
	protected static $cardModel = 'Cartalyst\Stripe\Laravel\Models\IlluminateCard';

	/**
	 * The charge model name.
	 *
	 * @var string
	 */
	protected static $chargeModel = 'Cartalyst\Stripe\Laravel\Models\IlluminateCharge';

	/**
	 * The charge refund model name.
	 *
	 * @var string
	 */
	protected static $chargeRefundModel = 'Cartalyst\Stripe\Laravel\Models\IlluminateChargeRefund';

 	/**
	 * The discount model name.
	 *
	 * @var string
	 */
	protected static $discountModel = 'Cartalyst\Stripe\Laravel\Models\IlluminateDiscount';

	/**
	 * The invoice model name.
	 *
	 * @var string
	 */
	protected static $invoiceModel = 'Cartalyst\Stripe\Laravel\Models\IlluminateInvoice';

	/**
	 * The invoice item model name.
	 *
	 * @var string
	 */
	protected static $invoiceItemModel = 'Cartalyst\Stripe\Laravel\Models\IlluminateInvoiceItem';

	/**
	 * The subscription model name.
	 *
	 * @var string
	 */
	protected static $subscriptionModel = 'Cartalyst\Stripe\Laravel\Models\IlluminateSubscription';

}
