<?php namespace Cartalyst\Stripe\Native\Facades;
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

use Cartalyst\Stripe\Native\StripeBootstrapper;

class Stripe {

	/**
	 * The Stripe API instance.
	 *
	 * @var \Cartalyst\Stripe\Api\Stripe
	 */
	protected $stripe;

	/**
	 * The Native Bootstrap instance.
	 *
	 * @var \Cartalyst\Stripe\Native\StripeBootstraper
	 */
	protected static $instance;

	/**
	 * Constructor.
	 *
	 * @param  \Cartalyst\Stripe\Native\StripeBootstraper  $bootstraper
	 * @return void
	 */
	public function __construct(StripeBootstraper $bootstraper = null)
	{
		if ( ! $bootstraper)
		{
			$bootstraper = new StripeBootstraper;
		}

		$this->stripe = $bootstraper->createStripe();
	}

	/**
	 * Creates a new Native Bootstraper instance.
	 *
	 * @param  \Cartalyst\Stripe\Native\StripeBootstrapper  $bootstrapper
	 * @return void
	 */
	public static function instance(StripeBootstrapper $bootstrapper = null)
	{
		if (static::$instance === null)
		{
			static::$instance = new static($bootstrapper);
		}

		return static::$instance;
	}

	/**
	 * Returns the Stripe API instance.
	 *
	 * @return \Cartalyst\Stripe\Api\Stripe
	 */
	public function getStripe()
	{
		return $this->stripe;
	}

	/**
	 * Handle dynamic, static calls to the object.
	 *
	 * @param  string  $method
	 * @param  array  $args
	 * @return mixed
	 */
	public static function __callStatic($method, $args)
	{
		$instance = static::instance()->getStripe();

		switch (count($args))
		{
			case 0:
				return $instance->{$method}();

			case 1:
				return $instance->{$method}($args[0]);

			case 2:
				return $instance->{$method}($args[0], $args[1]);

			case 3:
				return $instance->{$method}($args[0], $args[1], $args[2]);

			case 4:
				return $instance->{$method}($args[0], $args[1], $args[2], $args[3]);

			default:
				return call_user_func_array([$instance, $method], $args);
		}
	}

}
