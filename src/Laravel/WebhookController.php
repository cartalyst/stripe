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

use Carbon\Carbon;
use Illuminate\Support\Facades;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\Response;

class WebhookController extends Controller {

	/**
	 * Handles the Stripe webhook call.
	 *
	 * @param  array|\Cartalyst\Stripe\Api\Response  $payload
	 * @return mixed
	 */
	public function handleWebhook($payload = null)
	{
		// Get the request payload
		$payload = $payload ?: $this->getJsonPayload();

		// Make sure we have a proper method name
		$method = 'handle'.studly_case(str_replace('.', '_', $payload['type']));

		// Check if the method exists
		if (method_exists($this, $method))
		{
			// Get the 'previous_attributes' data, if available
			$previous_attributes = array_get($payload, 'data.previous_attributes', []);

			// Execute the method call
			return $this->{$method}(
				array_merge($payload['data']['object'], compact('previous_attributes'))
			);
		}

		// Return a positive message for Stripe anyways
		return $this->sendResponse();
	}

	/**
	 * Returns an HTTP Response.
	 *
	 * @param  string  $message
	 * @param  int  $status
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function sendResponse($message = null, $status = 200)
	{
		return new Response($message, $status);
	}

	/**
	 * Returns the billable entity instance by Stripe ID.
	 *
	 * @param  string  $stripeId
	 * @return \Cartalyst\Stripe\BillableInterface
	 */
	protected function getBillable($stripeId)
	{
		$model = Facades\Config::get('services.stripe.model');

		$class = '\\'.ltrim($model, '\\');

		return (new $class)->where('stripe_id', $stripeId)->first();
	}

	/**
	 * Returns the JSON payload for the request.
	 *
	 * @return array
	 */
	protected function getJsonPayload()
	{
		return (array) json_decode(Facades\Request::getContent(), true);
	}

	/**
	 * Converts the given timestamp into a Carbon object.
	 *
	 * @param  int  $timestamp
	 * @return \Carbon\Carbon|null
	 */
	protected function nullableTimestamp($timestamp)
	{
		if ( ! $timestamp) return null;

		return Carbon::createFromTimestamp($timestamp);
	}

}
