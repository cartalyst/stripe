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

interface ApiInterface
{
    /**
     * Returns the API base url.
     *
     * @return string
     */
    public function baseUrl(): string;

    /**
     * Returns the number of items to return per page.
     *
     * @return int|null
     */
    public function getPerPage(): ?int;

    /**
     * Sets the number of items to return per page.
     *
     * @param int|null $perPage
     *
     * @return \Cartalyst\Stripe\Api\ApiInterface
     */
    public function setPerPage(?int $perPage): self;

    /**
     * Sets the idempotency key.
     *
     * @param string|null $idempotencyKey
     *
     * @return \Cartalyst\Stripe\Api\ApiInterface
     */
    public function idempotent(?string $idempotencyKey): self;

    /**
     * Sends a GET request.
     *
     * @param string $uri
     * @param array  $query
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function _get(string $uri, array $query = []): ApiResponse;

    /**
     * Sends a DELETE request.
     *
     * @param string $uri
     * @param array  $query
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function _delete(string $uri, array $query = []): ApiResponse;

    /**
     * Sends a POST request.
     *
     * @param string $uri
     * @param array  $query
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function _post(string $uri, array $query = []): ApiResponse;

    /**
     * Sends a POST multipart request.
     *
     * @param string $uri
     * @param array  $params
     * @param array  $files
     * @param array  $headers
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function _postMultipart(string $uri, array $params, array $files, array $headers = []): ApiResponse;

    /**
     * Sends the HTTP request.
     *
     * @param string $method
     * @param string $uri
     * @param array  $query
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function sendRequest(string $method, string $uri, array $query = []): ApiResponse;

    /**
     * Sends the HTTP request.
     *
     * @param string $method
     * @param string $uri
     * @param array  $params
     * @param array  $files
     * @param array  $headers
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function sendMultipartRequest(string $method, string $uri, array $params, array $files, array $headers = []): ApiResponse;
}
