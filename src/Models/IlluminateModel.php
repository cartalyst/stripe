<?php namespace Cartalyst\Stripe\Models;
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
use Illuminate\Database\Eloquent\Collection;

class IlluminateModel extends Model {

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
	 * {@inheritDoc}
	 */
	public static function find($id, $columns = ['*'])
	{
		if (is_array($id) && empty($id)) return new Collection;

		$instance = new static;

		if ($id instanceof $instance) return $id;

		$instance
			->newQuery()
			->whereNested(function($query) use ($id, $instance)
			{
				$query
					->orWhere('stripe_id', $id)
					->orWhere($instance->getKeyName(), (int) $id);
			});

		return $instance->first($columns);
	}

}
