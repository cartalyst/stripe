<?php

/**
 * Part of the Stripe package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the 3-clause BSD License.
 *
 * This source file is subject to the 3-clause BSD License that is
 * bundled with this package in the LICENSE file.
 *
 * @package    Stripe
 * @version    2.4.1
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2020, Cartalyst LLC
 * @link       http://cartalyst.com
 */

namespace Cartalyst\Stripe\Api;

class EphemeralKey extends Api
{
    /**
     * Creates a new Ephemeral Key.
     *
     * @param  string  $customer
     * @return array
     */
    public function create($customer)
    {
        return $this->_post('ephemeral_keys', compact('customer'));
    }

    /**
     * Deletes the given Ephemeral Key.
     *
     * @param  string  $ephemeralKey
     * @return array
     */
    public function delete($ephemeralKey)
    {
        return $this->_delete("ephemeral_keys/{$ephemeralKey}");
    }
}
