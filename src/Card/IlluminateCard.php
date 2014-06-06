<?php namespace Cartalyst\Stripe\Card;
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

class IlluminateCard extends Model {

	/**
	 * {@inheritDoc}
	 */
	public $table = 'cards';

	/**
	 * {@inheritDoc}
	 */
	protected $fillable = [
		'last_4',
		'default',
		'exp_year',
		'exp_month',
	];

}
