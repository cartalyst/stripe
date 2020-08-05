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

use Cartalyst\Stripe\HttpClient\Message\ApiResponse;

class Files extends AbstractApi
{
    /**
     * {@inheritdoc}
     */
    public function baseUrl(): string
    {
        return 'https://uploads.stripe.com';
    }

    /**
     * Creates a file upload.
     *
     * @param string $filePath
     * @param string $purpose
     * @param array  $headers
     *
     * @return \Cartalyst\Stripe\HttpClient\Message\ApiResponse
     */
    public function create(string $filePath, string $purpose, array $headers = []): ApiResponse
    {
        return $this->_postMultipart('files', ['purpose' => $purpose], ['file' => $filePath], $headers);
    }

    /**
     * Retrieves an existing file upload.
     *
     * @param string $fileId
     *
     * @return \Cartalyst\Stripe\HttpClient\Message\ApiResponse
     */
    public function find(string $fileId): ApiResponse
    {
        return $this->_get("files/{$fileId}");
    }

    /**
     * Lists all file uploads.
     *
     * @param array $parameters
     *
     * @return \Cartalyst\Stripe\HttpClient\Message\ApiResponse
     */
    public function all(array $parameters = []): ApiResponse
    {
        return $this->_get('files', $parameters);
    }
}
