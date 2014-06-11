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

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Str;
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
		$method = Str::camel(str_replace('.', '_', $type));

		// Check if the method exists
		if (method_exists($this, $method))
		{
			return $this->{$method}($payload['data']['object']);
		}

		// Return a positive message for Stripe anyways
		return "Method [{$type}] doesn't exist.";
	}

	/**
	 * Returns an HTTP Response.
	 *
	 * @param  string  $message
	 * @param  int  $status
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function sendResponse($message, $status = 200)
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
		$model = Config::get('service.stripe.model');

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

}
