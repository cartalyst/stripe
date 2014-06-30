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

use Illuminate\Database\Eloquent\Model;

class IlluminateRefund extends Model {

	/**
	 * {@inheritDoc}
	 */
	public $table = 'refunds';

	/**
	 * {@inheritDoc}
	 */
	protected $fillable = [
		'amount',
		'currency',
		'payment_id',
		'transaction_id',
	];

	/**
	 * The Eloquent charges model.
	 *
	 * @var string
	 */
	protected static $chargeModel = 'Cartalyst\Stripe\Billing\Models\IlluminateCharge';

	/**
	 * Returns the charge associated to this refund.
	 *
	 * @return \Carbon\Stripe\Billing\Models\IlluminateCharge
	 */
	public function charge()
	{
		return $this->belongsTo(static::$chargeModel, 'payment_id');
	}

	/**
	 * Sets the Eloquent model to be used for charges relationship.
	 *
	 * @param  string  $model
	 * @return void
	 */
	public static function setChargeModel($model)
	{
		static::$chargeModel = $model;
	}

}
