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
use Cartalyst\Stripe\Exception\StripeException;

abstract class Api implements ApiInterface
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
     * {@inheritDoc}
     */
    public function getPerPage()
    {
        return $this->perPage;
    }

    /**
     * {@inheritDoc}
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
        return $this->execute('get', $url, $options)->json();
    }

    /**
     * {@inheritDoc}
     */
    public function _head($url = null, array $options = [])
    {
        return $this->execute('head', $url, $options);
    }

    /**
     * {@inheritDoc}
     */
    public function _delete($url = null, array $options = [])
    {
        return $this->execute('delete', $url, $options)->json();
    }

    /**
     * {@inheritDoc}
     */
    public function _put($url = null, array $options = [])
    {
        return $this->execute('put', $url, $options)->json();
    }

    /**
     * {@inheritDoc}
     */
    public function _patch($url = null, array $options = [])
    {
        return $this->execute('patch', $url, $options)->json();
    }

    /**
     * {@inheritDoc}
     */
    public function _post($url = null, array $options = [])
    {
        return $this->execute('post', $url, $options)->json();
    }

    /**
     * {@inheritDoc}
     */
    public function _options($url = null, array $options = [])
    {
        return $this->execute('options', $url, $options)->json();
    }

    /**
     * {@inheritDoc}
     */
    public function execute($httpMethod, $url, array $options = [])
    {
        return $this->client->{$httpMethod}($url, [ 'query' => $options ]);
    }
}
