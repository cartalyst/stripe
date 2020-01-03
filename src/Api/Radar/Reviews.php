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

namespace Cartalyst\Stripe\Api\Radar;

use Cartalyst\Stripe\Api\Api;

class Reviews extends Api
{
    /**
     * Approves a radar review.
     *
     * @param  string  $reviewId
     * @return array
     */
    public function approve($reviewId)
    {
        return $this->_post("reviews/{$reviewId}/approve");
    }

    /**
     * Retrieves an existing radar review.
     *
     * @param  string  $reviewId
     * @return array
     */
    public function find($reviewId)
    {
        return $this->_get("reviews/{$reviewId}");
    }

    /**
     * Lists all reviews.
     *
     * @param  array  $parameters
     * @return array
     */
    public function all(array $parameters = [])
    {
        return $this->_get('reviews', $parameters);
    }
}
