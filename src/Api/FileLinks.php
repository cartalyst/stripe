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
 * @version    2.4.2
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
     * @param  string  $fileId
     * @param  array  $attributes
     * @return array
     */
    public function create($fileId, array $attributes = [])
    {
        $attributes = array_merge($attributes, [
            'file' => $fileId,
        ]);

        return $this->_post("file_links", $attributes);
    }

    /**
     * Retrieves an existing file link.
     *
     * @param  string  $fileLinkId
     * @return array
     */
    public function find($fileLinkId)
    {
        return $this->_get("file_links/{$fileLinkId}");
    }

    /**
     * Updates an existing file link.
     *
     * @param  string  $fileLinkId
     * @param  array  $parameters
     * @return array
     */
    public function update($fileLinkId, array $parameters = [])
    {
        return $this->_post("file_links/{$fileLinkId}", $parameters);
    }

    /**
     * Lists all file links.
     *
     * @param  array  $parameters
     * @return array
     */
    public function all(array $parameters = [])
    {
        return $this->_get('file_links', $parameters);
    }
}
