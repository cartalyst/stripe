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
    public function setPerPage(?int $perPage): ApiInterface;

    /**
     * Sets the idempotency key.
     *
     * @param string $idempotencyKey
     *
     * @return \Cartalyst\Stripe\Api\ApiInterface
     */
    public function idempotent(string $idempotencyKey): ApiInterface;

    /**
     * Sends a GET request.
     *
     * @param string $url
     * @param array  $parameters
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function _get(string $url, array $parameters = []): ApiResponse;

    /**
     * Sends a DELETE request.
     *
     * @param string $url
     * @param array  $parameters
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function _delete(string $url, array $parameters = []): ApiResponse;

    /**
     * Sends a POST request.
     *
     * @param string $url
     * @param array  $parameters
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function _post(string $url, array $parameters = []): ApiResponse;

    /**
     * Sends the HTTP request.
     *
     * @param string $httpMethod
     * @param string $url
     * @param array  $parameters
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function sendRequest(string $httpMethod, string $url, array $parameters = []): ApiResponse;
}
