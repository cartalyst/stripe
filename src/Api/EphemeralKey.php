<?php

declare(strict_types=1);

/*
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
 * @version    3.0.0
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2020, Cartalyst LLC
 * @link       https://cartalyst.com
 */

namespace Cartalyst\Stripe\Api;

class EphemeralKey extends AbstractApi
{
    /**
     * Creates a new Ephemeral Key.
     *
     * @param string $customerId
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function create(string $customerId): ApiResponse
    {
        return $this->_post('ephemeral_keys', [
            'customer' => $customerId,
        ]);
    }

    /**
     * Deletes the given Ephemeral Key.
     *
     * @param string $ephemeralKey
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function delete(string $ephemeralKey): ApiResponse
    {
        return $this->_delete("ephemeral_keys/{$ephemeralKey}");
    }
}
