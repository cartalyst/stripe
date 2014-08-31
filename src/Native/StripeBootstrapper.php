<?php namespace Cartalyst\Stripe\Native;
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

use Cartalyst\Stripe\Api\Stripe;

class StripeBoostrapper {

	/**
	 * The Stripe configuration.
	 *
	 * @var array
	 */
	protected $config;

	/**
	 * Constructor.
	 *
	 * @param  mixed  $config
	 * @return void
	 */
	public function __construct($config = null)
	{
		$this->config = $config ?: new ConfigRepository($config);
	}

	/**
	 * Creates the Stripe instance.
	 *
	 * @return \Cartalyst\Stripe\Api\Stripe
	 */
	public function createStripe()
	{
		$stripeKey = array_get($this->config, 'stripe.secret');

		$version = array_get($this->config, 'stripe.version');

		$manifestPath = array_get($this->config, 'stripe.manifestPath');

		return new Stripe($stripeKey, $version, $manifestPath);
	}

}
