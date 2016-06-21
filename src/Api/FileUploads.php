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
 * @version    1.0.9
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2016, Cartalyst LLC
 * @link       http://cartalyst.com
 */

namespace Cartalyst\Stripe\Api;

use GuzzleHttp\Post\PostFile;

class FileUploads extends Api
{
    /**
     * {@inheritDoc}
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
        $client = $this->getClient();

        $request = $client->createRequest('POST', 'v1/files');

        $postBody = $request->getBody();

        $postBody->setField('purpose', $purpose);

        $postBody->addFile(
            new PostFile('file', fopen($file, 'r'), null, $headers)
        );

        return json_decode($client->send($request)->getBody()->getContents(), true);
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
