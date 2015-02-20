### Exceptions

The Stripe API will throw a few exceptions when something is wrong, like when a credit card with a bad number is submited, an expired credit card or even when Stripe.com itself has done something wrong.

Here is the list of all the exceptions that the Stripe API throws with a brief description:

<table>
	<thead>
		<th>Exception</th>
		<th>Description</th>
	</thead>
	<tbody>
		<tr>
			<td>Cartalyst\Stripe\Exception\BadRequestException</td>
			<td>This exception will be thrown when the data sent through the request is mal formed.</td>
		</tr>
		<tr>
			<td>Cartalyst\Stripe\Exception\UnauthorizedException</td>
			<td>This exception will be thrown if your Stripe API Key is incorrect.</td>
		</tr>
		<tr>
			<td>Cartalyst\Stripe\Exception\InvalidRequestException</td>
			<td>This exception will be thrown whenever the request fails for some reason.</td>
		</tr>
		<tr>
			<td>Cartalyst\Stripe\Exception\NotFoundException</td>
			<td>This exception will be thrown whenever a request results on a 404.</td>
		</tr>
		<tr>
			<td>Cartalyst\Stripe\Exception\CardErrorException</td>
			<td>This exception will be thrown whenever the credit card is invalid.</td>
		</tr>
		<tr>
			<td>Cartalyst\Stripe\Exception\ServerErrorException</td>
			<td>This exception will be thrown whenever Stripe does something wrong.</td>
		</tr>
	</tbody>
</table>

#### Usage

Below is an example of using the API to find a customer, but this customer doesn't exist, so it'll throw a `NotFoundException`.

```php
try
{
	$customer = $stripe->customers()->find('foobar');

	echo $customer['email'];
}
catch (Cartalyst\Stripe\Exception\NotFoundException $e)
{
	// Get the status code
	$code = $e->getCode();

	// Get the error message returned by Stripe
	$message = $e->getMessage();

	// Get the error type returned by Stripe
	$type = $e->getErrorType();
}
```
