<?php namespace Cartalyst\Stripe\Laravel\Models;
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

use Illuminate\Database\Eloquent\Model;

class IlluminateInvoiceItem extends Model {

	/**
	 * {@inheritDoc}
	 */
	public $table = 'stripe_invoice_items';

	/**
	 * {@inheritDoc}
	 */
	protected $fillable = [
		'type',
		'amount',
		'plan_id',
		'quantity',
		'currency',
		'proration',
		'stripe_id',
		'invoice_id',
		'period_end',
		'description',
		'period_start',
	];

	/**
	 * {@inheritDoc}
	 */
	protected $dates = [
		'period_end',
		'period_start',
	];

	/**
	 * Returns the polymorphic relationship.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\MorphTo
	 */
	public function billable()
	{
		return $this->morphTo();
	}

}
