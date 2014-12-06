<?php namespace Cartalyst\Stripe\Gateways;
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

use Closure;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Cartalyst\Stripe\BillableInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

abstract class AbstractGateway {

	/**
	 * The billable entity.
	 *
	 * @var \Cartalyst\Stripe\BillableInterface
	 */
	protected $billable;

	/**
	 * The Stripe API client.
	 *
	 * @var \Cartalyst\Stripe\Api\Stripe
	 */
	protected $client;

	/**
	 * The Event Dispatcher status.
	 *
	 * @var bool
	 */
	protected $dispatcherStatus = true;

	/**
	 * Constructor.
	 *
	 * @param  \Cartalyst\Stripe\BillableInterface  $billable
	 * @return void
	 */
	public function __construct(BillableInterface $billable = null)
	{
		$this->billable = $billable;

		$this->client = $this->getStripeClient();
	}

	/**
	 * Returns a Carbon object if the provided timestamp
	 * is valid and returns null otherwise.
	 *
	 * @param  int  $timestamp
	 * @return \Carbon\Carbon|null
	 */
	protected function nullableTimestamp($timestamp)
	{
		if ( ! $timestamp) return null;

		return Carbon::createFromTimestamp($timestamp);
	}

	/**
	 * Returns the Stripe API client.
	 *
	 * @return \Cartalyst\Stripe\Api\Stripe
	 */
	protected function getStripeClient()
	{
		if ($this->billable)
		{
			return $this->client ?: $this->billable->getStripeClient();
		}
	}

	/**
	 * Converts the amount from cents to "dollars".
	 *
	 * @param  int  $amount
	 * @return double
	 */
	protected function convertToDecimal($amount)
	{
		return (double) ($amount / 100);
	}

	/**
	 * Enables the events dispatcher.
	 *
	 * @return void
	 */
	protected function enableEventDispatcher()
	{
		$this->dispatcherStatus = true;
	}

	/**
	 * Disables the events dispatcher.
	 *
	 * @return void
	 */
	protected function disableEventDispatcher()
	{
		$this->dispatcherStatus = false;
	}

	/**
	 * Fires an event.
	 *
	 * @param  string  $event
	 * @param  array  $data
	 * @return void
	 */
	protected function fire($event, array $data = [])
	{
		if ( ! $this->dispatcherStatus) return;

		$entity = $this->billable;

		$data = array_merge([ $entity ], $data);

		$dispatcher = $entity->getEventDispatcher();

		$dispatcher->fire("cartalyst.stripe.{$event}", $data);
	}

	/**
	 * Handles the callback.
	 *
	 * @param  \Closure  $callback
	 * @param  \Cartalyst\Stripe\Api\Models\Collection|array  $response
	 * @param  \Illuminate\Database\Eloquent\Model  $object
	 * @return void
	 */
	protected function handleCallback(Closure $callback = null, $response, Model $object)
	{
		if ($callback) call_user_func($callback, $response, $object);
	}

	/**
	 * Checks if the entity is a Stripe customer or not.
	 *
	 * @return void
	 * @throws \Symfony\Component\HttpKernel\Exception\BadRequestHttpException
	 */
	protected function checkEntityIsBillable()
	{
		if ( ! $this->billable->isBillable())
		{
			throw new BadRequestHttpException(
				"The entity isn't a Stripe Customer!"
			);
		}
	}

}
