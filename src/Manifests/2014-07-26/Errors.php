<?php
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
 * @copyright  (c) 2011-2015, Cartalyst LLC
 * @link       http://cartalyst.com
 */

return [

	[
		'class' => 'Cartalyst\Stripe\Api\Exception\BadRequestException',
		'code'  => 400,
	],

	[
		'class' => 'Cartalyst\Stripe\Api\Exception\UnauthorizedException',
		'code'  => 401,
	],

	[
		'class' => 'Cartalyst\Stripe\Api\Exception\RequestFailedException',
		'code'  => 402,
	],

	[
		'class' => 'Cartalyst\Stripe\Api\Exception\NotFoundException',
		'code'  => 404,
	],

	[
		'class' => 'Cartalyst\Stripe\Api\Exception\ServerErrorException',
		'code'  => 500,
	],

	[
		'class' => 'Cartalyst\Stripe\Api\Exception\ServerErrorException',
		'code'  => 502,
	],

	[
		'class' => 'Cartalyst\Stripe\Api\Exception\ServerErrorException',
		'code'  => 503,
	],

	[
		'class' => 'Cartalyst\Stripe\Api\Exception\ServerErrorException',
		'code'  => 504,
	],

];
