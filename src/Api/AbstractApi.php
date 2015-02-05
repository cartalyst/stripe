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

use GuzzleHttp\Client;

abstract class AbstractApi implements ApiInterface
{
    /**
     * The Guzzle client instance.
     *
     * @var \GuzzleHttp\Client
     */
    protected $client;

    /**
     * Number of items to return per page.
     *
     * @var int
     */
    protected $perPage = 100;

    /**
     * Constructor.
     *
     * @param  \GuzzleHttp\Client  $client
     * @return void
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Returns the number of items to return per page.
     *
     * @return void
     */
    public function getPerPage()
    {
        return $this->perPage;
    }

    /**
     * Sets the number of items to return per page.
     *
     * @param  int  $perPage
     * @return $this
     */
    public function setPerPage($perPage)
    {
        $this->perPage = (int) $perPage;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function _get($url = null, $options = [])
    {
        return $this->client->get($url, $options);
    }

    /**
     * {@inheritDoc}
     */
    public function _head($url = null, array $options = [])
    {
        return $this->client->head($url, $options);
    }

    /**
     * {@inheritDoc}
     */
    public function _delete($url = null, array $options = [])
    {
        return $this->client->delete($url, $options);
    }

    /**
     * {@inheritDoc}
     */
    public function _put($url = null, array $options = [])
    {
        return $this->client->put($url, $options);
    }

    /**
     * {@inheritDoc}
     */
    public function _patch($url = null, array $options = [])
    {
        return $this->client->patch($url, $options);
    }

    /**
     * {@inheritDoc}
     */
    public function _post($url = null, array $options = [])
    {
        return $this->client->post($url, $options);
    }

    /**
     * {@inheritDoc}
     */
    public function _options($url = null, array $options = [])
    {
        return $this->client->options($url, $options);
    }
}
