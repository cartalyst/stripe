<?php

/**
 * Part of the Stripe package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Cartalyst PSL License.
 *
 * This source file is subject to the Cartalyst PSL License that is
 * bundled with this package in the LICENSE file.
 *
 * @package    Stripe
 * @version    1.0.0
 * @author     Cartalyst LLC
 * @license    Cartalyst PSL
 * @copyright  (c) 2011-2015, Cartalyst LLC
 * @link       http://cartalyst.com
 */

namespace Cartalyst\Stripe\Api;

interface ApiInterface
{
    /**
     * Returns the number of items to return per page.
     *
     * @return void
     */
    public function getPerPage();

    /**
     * Sets the number of items to return per page.
     *
     * @param  int  $perPage
     * @return $this
     */
    public function setPerPage($perPage);

    /**
     * Send a GET request.
     *
     * @param  string  $url
     * @param  array  $options
     * @return \GuzzleHttp\Message\ResponseInterface
     */
    public function _get($url = null, $options = []);

    /**
     * Send a HEAD request.
     *
     * @param  string  $url
     * @param  array  $options
     * @return \GuzzleHttp\Message\ResponseInterface
     */
    public function _head($url = null, array $options = []);

    /**
     * Send a DELETE request.
     *
     * @param  string  $url
     * @param  array  $options
     * @return \GuzzleHttp\Message\ResponseInterface
     */
    public function _delete($url = null, array $options = []);

    /**
     * Send a PUT request.
     *
     * @param  string  $url
     * @param  array  $options
     * @return \GuzzleHttp\Message\ResponseInterface
     */
    public function _put($url = null, array $options = []);

    /**
     * Send a PATCH request.
     *
     * @param  string  $url
     * @param  array  $options
     * @return \GuzzleHttp\Message\ResponseInterface
     */
    public function _patch($url = null, array $options = []);

    /**
     * Send a POST request.
     *
     * @param  string  $url
     * @param  array  $options
     * @return \GuzzleHttp\Message\ResponseInterface
     */
    public function _post($url = null, array $options = []);

    /**
     * Send an OPTIONS request.
     *
     * @param  string  $url
     * @param  array  $options
     * @return \GuzzleHttp\Message\ResponseInterface
     */
    public function _options($url = null, array $options = []);

    /**
     * Executes the HTTP request.
     *
     * @param  string  $httpMethod
     * @param  string  $url
     * @param  array  $options
     * @return \GuzzleHttp\Message\ResponseInterface
     * @throws \Cartalyst\Stripe\Exception\StripeException
     */
    public function execute($httpMethod, $url, array $options = []);
}
