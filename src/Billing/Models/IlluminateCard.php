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

class IlluminateCard extends Model {

	/**
	 * {@inheritDoc}
	 */
	public $table = 'cards';

	/**
	 * {@inheritDoc}
	 */
	protected $fillable = [
		'brand',
		'default',
		'funding',
		'exp_year',
		'cvc_check',
		'exp_month',
		'last_four',
		'stripe_id',
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

	/**
	 * Get mutator for the "default" attribute.
	 *
	 * @param  string  $default
	 * @return bool
	 */
	public function getDefaultAttribute($default)
	{
		return (int) $default;
	}

	/**
	 * Checks if the credit card is the default card.
	 *
	 * @return bool
	 */
	public function isDefault()
	{
		return (bool) $this->default;
	}

}
