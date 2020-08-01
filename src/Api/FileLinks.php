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

class FileLinks extends Api
{
    /**
     * Creates a new file link.
     *
     * @param string $fileId
     * @param array  $attributes
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function create(string $fileId, array $attributes = []): ApiResponse
    {
        $attributes = array_merge($attributes, [
            'file' => $fileId,
        ]);

        return $this->_post('file_links', $attributes);
    }

    /**
     * Retrieves an existing file link.
     *
     * @param string $fileLinkId
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function find(string $fileLinkId): ApiResponse
    {
        return $this->_get("file_links/{$fileLinkId}");
    }

    /**
     * Updates an existing file link.
     *
     * @param string $fileLinkId
     * @param array  $parameters
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function update(string $fileLinkId, array $parameters = []): ApiResponse
    {
        return $this->_post("file_links/{$fileLinkId}", $parameters);
    }

    /**
     * Lists all file links.
     *
     * @param array $parameters
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function all(array $parameters = []): ApiResponse
    {
        return $this->_get('file_links', $parameters);
    }
}
