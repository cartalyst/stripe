<?php Cartalyst\Stripe;
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
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Str;

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
			return $this->{$method}($payload);
		}

		// Return a positive message for Stripe anyways
		return "Method [{$type}] doesn't exist.";
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
