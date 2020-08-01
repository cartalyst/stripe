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

namespace Cartalyst\Stripe\Api\Radar;

use Cartalyst\Stripe\Api\Api;
use Cartalyst\Stripe\Api\ApiResponse;

class Reviews extends Api
{
    /**
     * Approves a radar review.
     *
     * @param string $reviewId
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function approve(string $reviewId): ApiResponse
    {
        return $this->_post("reviews/{$reviewId}/approve");
    }

    /**
     * Retrieves an existing radar review.
     *
     * @param string $reviewId
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function find(string $reviewId): ApiResponse
    {
        return $this->_get("reviews/{$reviewId}");
    }

    /**
     * Lists all reviews.
     *
     * @param array $parameters
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function all(array $parameters = []): ApiResponse
    {
        return $this->_get('reviews', $parameters);
    }
}
