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

namespace Cartalyst\Stripe\Api;

class ApplicationFees extends Api
{
    /**
     * Retrieves an existing application fee.
     *
     * @param  string  $applicationFeeId
     * @return \GuzzleHttp\Message\ResponseInterface
     */
    public function find($applicationFeeId)
    {
        return $this->_get("application_fees/{$applicationFeeId}");
    }

    /**
     * Lists all application_fees.
     *
     * @param  array  $parameters
     * @return \GuzzleHttp\Message\ResponseInterface
     */
    public function all(array $parameters = [])
    {
        return $this->_get('application_fees', $parameters);
    }
}
