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
 * @version    2.4.6
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2021, Cartalyst LLC
 * @link       https://cartalyst.com
 */

namespace Cartalyst\Stripe\Api;

class Files extends Api
{
    /**
     * {@inheritdoc}
     */
    public function baseUrl()
    {
        return 'https://uploads.stripe.com';
    }

    /**
     * Creates a file upload.
     *
     * @param  string  $file
     * @param  string  $purpose
     * @param  array  $headers
     * @return array
     */
    public function create($file, $purpose, array $headers = [])
    {
        $response = $this->getClient()->request('POST', 'v1/files', [
            'headers'   => $headers,
            'multipart' => [
                [ 'name' => 'purpose', 'contents' => $purpose ],
                [ 'name' => 'file', 'contents' => fopen($file, 'r') ]
            ],
        ]);

        return json_decode($response->getBody(), true);
    }

    /**
     * Retrieves an existing file upload.
     *
     * @param  string  $fileId
     * @return array
     */
    public function find($fileId)
    {
        return $this->_get("files/{$fileId}");
    }

    /**
     * Lists all file uploads.
     *
     * @param  array  $parameters
     * @return array
     */
    public function all(array $parameters = [])
    {
        return $this->_get('files', $parameters);
    }
}
