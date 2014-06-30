<?php namespace Cartalyst\Stripe\Billing;
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
use Cartalyst\Stripe\Billing\Models\IlluminateInvoice;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class InvoiceGateway extends StripeGateway {

	/**
	 * The invoice object.
	 *
	 * @var \Cartalyst\Stripe\Billing\Models\IlluminateInvoice
	 */
	protected $invoice;

	/**
	 * Constructor.
	 *
	 * @param  \Cartalyst\Stripe\Billing\BillableInterface  $billable
	 * @param  mixed  $invoice
	 * @return void
	 */
	public function __construct(BillableInterface $billable, $invoice = null)
	{
		parent::__construct($billable);

		if (is_numeric($invoice))
		{
			$invoice = $this->billable->invoices->find($invoice);
		}

		if ($invoice instanceof IlluminateInvoice)
		{
			$this->invoice = $invoice;
		}
	}

	/**
	 * Syncronizes the Stripe invoices data with the local data.
	 *
	 * @return void
	 * @throws \Symfony\Component\HttpKernel\Exception\BadRequestHttpException
	 */
	public function syncWithStripe()
	{
		$entity = $this->billable;

		if ( ! $entity->isBillable())
		{
			throw new BadRequestHttpException("The entity isn't a Stripe Customer!");
		}

		$invoices = $this->client->invoicesIterator([
			'customer' => $entity->stripe_id,
		]);

		foreach ($invoices as $invoice)
		{
			$stripeId = $invoice['id'];

			$_invoice = $entity->invoices()->where('stripe_id', $stripeId)->first();

			$data = [
				'stripe_id'       => $stripeId,
				'subscription_id' => $invoice['subscription'],
				'currency'        => $invoice['currency'],
				'subtotal'        => ($invoice['subtotal'] / 100),
				'total'           => ($invoice['total'] / 100),
				'amount_due'      => ($invoice['amount_due'] / 100),
				'attempted'       => (bool) $invoice['attempted'],
				'closed'          => (bool) $invoice['closed'],
				'paid'            => (bool) $invoice['paid'],
				'attempt_count'   => $invoice['attempt_count'],
				'created_at'      => Carbon::createFromTimestamp($invoice['date']),
				'period_start'    => Carbon::createFromTimestamp($invoice['period_start']),
				'period_end'      => Carbon::createFromTimestamp($invoice['period_end']),
			];

			if ( ! $_invoice)
			{
				$_invoice = $entity->invoices()->create($data);
			}
			else
			{
				$_invoice->update($data);
			}

			foreach ($invoice['lines']['data'] as $item)
			{
				$id = $item['id'];

				$_item = $_invoice->items()->where('stripe_id', $id)->first();

				$data = [
					'stripe_id'    => $id,
					'currency'     => $item['currency'],
					'type'         => $item['type'],
					'amount'       => ($item['amount'] / 100),
					'proration'    => (bool) $item['proration'],
					'description'  => $item['description'],
					'plan'         => $item['plan']['id'],
					'quantity'     => $item['quantity'],
					'period_start' => Carbon::createFromTimestamp($item['period']['start']),
					'period_end'   => Carbon::createFromTimestamp($item['period']['end']),
				];

				if ( ! $_item)
				{
					$_item = $_invoice->items()->create($data);
				}
				else
				{
					$_item->update($data);
				}
			}
		}
	}

}
