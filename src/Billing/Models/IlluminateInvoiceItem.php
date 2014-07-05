<?php namespace Cartalyst\Stripe\Billing\Models;
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

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class IlluminateInvoiceItem extends Model {

	/**
	 * {@inheritDoc}
	 */
	public $table = 'invoice_items';

	/**
	 * {@inheritDoc}
	 */
	protected $fillable = [
		'type',
		'amount',
		'plan_id',
		'quantity',
		'currency',
		'stripe_id',
		'proration',
		'invoice_id',
		'period_end',
		'description',
		'period_start',
	];

}
