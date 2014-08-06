<?php namespace Cartalyst\Stripe;
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
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Request;
use Symfony\Component\HttpFoundation\Response;

class WebhookController extends Controller {

	/**
	 * Handles the Stripe webhook call.
	 *
	 * @return mixed
	 */
	public function handleWebhook()
	{
		// Get the request payload
		$payload = $this->getJsonPayload();

		// Get the webhook type
		$type = $payload['type'];

		// Make sure we have a proper method name
		$method = 'handle'.studly_case(str_replace('.', '_', $type));

		// Check if the method exists
		if (method_exists($this, $method))
		{
			// Store the 'previous_attributes'
			$previous_attributes = array_get($payload, 'previous_attributes', []);

			// Merge in the 'previous_attributes' with the object data
			$payload = array_merge($payload['data']['object'], compact('previous_attributes'));

			// Execute the method call
			return $this->{$method}($payload);
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
		$model = Config::get('services.stripe.model');

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
		return (array) json_decode(Request::getContent(), true);
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

}
