<?php

/**
 * Part of the Stripe package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Cartalyst PSL License.
 *
 * This source file is subject to the Cartalyst PSL License that is
 * bundled with this package in the LICENSE file.
 *
 * @package    Stripe
 * @version    1.0.0
 * @author     Cartalyst LLC
 * @license    Cartalyst PSL
 * @copyright  (c) 2011-2015, Cartalyst LLC
 * @link       http://cartalyst.com
 */

namespace Cartalyst\Stripe\Descriptions\V1_0;

class Description extends \Cartalyst\Stripe\Descriptions\Description
{
    /**
     * {@inheritDoc}
     */
    public function getSupportedVersions()
    {
        return [
            '2014-03-28', '2014-05-19', '2014-06-13', '2014-06-17', '2014-07-22', '2014-07-26',
            '2014-08-04', '2014-08-20', '2014-09-08', '2014-10-07', '2014-11-05', '2014-11-20',
            '2014-12-08', '2014-12-17', '2014-12-22', '2015-01-11', '2015-01-26',
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function getSupportedOperations()
    {
        return [
            'account'                 => 'V1_0\Account',
            'application_fee_refunds' => 'V1_0\ApplicationFeeRefunds',
            'application_fees'        => 'V1_0\ApplicationFees',
            'balance'                 => 'V1_0\Balance',
            'cards'                   => 'V1_0\Cards',
            'charges'                 => 'V1_0\Charges',
            'coupons'                 => 'V1_0\Coupons',
            'customers'               => 'V1_0\Customers',
            'disputes'                => 'V1_0\Disputes',
            'events'                  => 'V1_0\Events',
            'invoice_items'           => 'V1_0\InvoiceItems',
            'invoices'                => 'V1_0\Invoices',
            'plans'                   => 'V1_0\Plans',
            'recipients'              => 'V1_0\Recipients',
            'refunds'                 => 'V1_0\Refunds',
            'subscriptions'           => 'V1_0\Subscriptions',
            'tokens'                  => 'V1_0\Tokens',
            'transfers'               => 'V1_0\Transfers',
        ];
    }
}
