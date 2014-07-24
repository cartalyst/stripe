### Handling Exceptions

The Stripe API throws two kinds of exceptions:

#### Guzzle Exceptions

These exceptions will be thrown since Guzzle will automatically validate all the arguments you provide according to the manifest file rules.

If an argument is invalid, Guzzle will throw a `Guzzle\Service\Exception\ValidationException` exception,

```php
try
{
	$customer = Stripe::customers()->find([
		// We should pass in the id argument here..
	]);
}
catch (Guzzle\Service\Exception\ValidationException $e)
{
	$errors = $e->getErrors();
}
```

#### Stripe API Exceptions

Here is the full list of all the exceptions that the Stripe API throws with a brief description:

Exception                                             | Description
----------------------------------------------------- | ------------------------
Cartalyst\Stripe\Api\Exception\BadRequestException    | This exception will be thrown when the data sent through the request is mal formed.
Cartalyst\Stripe\Api\Exception\UnauthorizedException  | This exception will be thrown if your Stripe API Key is incorrect.
Cartalyst\Stripe\Api\Exception\RequestFailedException | This exception will be thrown whenever the request fails for some reason.
Cartalyst\Stripe\Api\Exception\CardErrorException     | This exception will be thrown whenever the credit card is invalid.
Cartalyst\Stripe\Api\Exception\NotFoundException      | This exception will be thrown whenever a request results on a 404.
Cartalyst\Stripe\Api\Exception\ServerErrorException   | This exception will be thrown whenever Stripe does something wrong.

#### Usage

```php
try
{
	$customer = Stripe::customers()->find([
		'id' => 'foobar',
	]);

	echo $customer['email'];
}
catch (Cartalyst\Stripe\Api\Exception\NotFoundException $e)
{
	// Get the error message returned by Stripe
	$message = $e->getMessage();

	// Get the error type returned by Stripe
	$type = $e->getErrorType();

	// Get the status code
	$code = $e->getCode();

	// Get the request response, if required to get more information
	$response = $e->getResponse();
}
```
