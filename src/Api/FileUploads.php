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
 * @version    2.0.3
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
     * @return array
     */
    public function create($file, $purpose)
    {
        $file = new PostFile('file', fopen($file, 'r'));

        $client = $this->getClient();
        $request = $client->createRequest('POST', 'v1/files');
        $postBody = $request->getBody();
        $postBody->setField('purpose', $purpose);
        $postBody->addFile($file);

        return $client->send($request);
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
