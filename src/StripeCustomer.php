<?php namespace Cartalyst\Stripe;

class StripeCustomer extends Stripe {

	protected $billable;

	public function __construct($billable)
	{
		$this->billable = $billable;

		parent::__construct($billable);
	}

	public function all()
	{
		return $this->client()->get('customers');
	}


}
