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
 * @version    2.0.7
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2016, Cartalyst LLC
 * @link       http://cartalyst.com
 */

namespace Cartalyst\Stripe\Api;

interface ApiInterface
{
    /**
     * Returns the API base url.
     *
     * @return string
     */
    public function baseUrl();

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
     * @param  array  $parameters
     * @return array
     */
    public function _get($url = null, $parameters = []);

    /**
     * Send a HEAD request.
     *
     * @param  string  $url
     * @param  array  $parameters
     * @return array
     */
    public function _head($url = null, array $parameters = []);

    /**
     * Send a DELETE request.
     *
     * @param  string  $url
     * @param  array  $parameters
     * @return array
     */
    public function _delete($url = null, array $parameters = []);

    /**
     * Send a PUT request.
     *
     * @param  string  $url
     * @param  array  $parameters
     * @return array
     */
    public function _put($url = null, array $parameters = []);

    /**
     * Send a PATCH request.
     *
     * @param  string  $url
     * @param  array  $parameters
     * @return array
     */
    public function _patch($url = null, array $parameters = []);

    /**
     * Send a POST request.
     *
     * @param  string  $url
     * @param  array  $parameters
     * @return array
     */
    public function _post($url = null, array $parameters = []);

    /**
     * Send an OPTIONS request.
     *
     * @param  string  $url
     * @param  array  $parameters
     * @return array
     */
    public function _options($url = null, array $parameters = []);

    /**
     * Executes the HTTP request.
     *
     * @param  string  $httpMethod
     * @param  string  $url
     * @param  array  $parameters
     * @return array
     */
    public function execute($httpMethod, $url, array $parameters = []);
}
