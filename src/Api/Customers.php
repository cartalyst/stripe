<?php namespace Cartalyst\Stripe\Api;

class Customers extends AbstractApi {

	public function all(array $arguments = [])
	{
		$instance = new static($this->client);
		$instance->get('customers', $arguments);
		return $instance;
	}

	public function find($id, array $arguments = [])
	{
		$instance = new static($this->client);
		$instance->get("customers/{$id}", $arguments);
		return $instance;
	}

	public function delete()
	{
		return true;
	}

}
