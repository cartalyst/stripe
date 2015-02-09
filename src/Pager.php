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

namespace Cartalyst\Stripe;

use Cartalyst\Stripe\Api\ApiInterface;
use Cartalyst\Stripe\HttpClient\ClientInterface;

class Pager implements PagerInterface
{
    /**
     * The Stripe Http Client instance.
     *
     * @var \Cartalyst\Stripe\HttpClient\Client
     */
    protected $client;

    /**
     * The previous request token.
     *
     * @var array
     */
    protected $previousToken;

    /**
     * The next requst token.
     *
     * @var array
     */
    protected $nextToken;

    /**
     * Constructor.
     *
     * @param  \Cartalyst\Stripe\HttpClient\ClientInterface  $client
     * @return void
     */
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * {@inheritDoc}
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * {@inheritDoc}
     */
    public function setClient(ClientInterface $client)
    {
        $this->client = $client;

        return $this;
    }

    public function fetch(ApiInterface $api, array $parameters = [])
    {
        $this->client->clearLastRequest();

        $this->client->clearLastResponse();

        $perPage = $api->getPerPage();

        $api->setPerPage(100);

        $results = $this->processRequest($api, $parameters)['data'];

        while ($this->nextToken) {
            $results = array_merge($results, $this->processRequest($api, $parameters)['data']);
        }

        return $results;
    }

    protected function processRequest($api, array $parameters = [])
    {
        if ($this->nextToken)
        {
            $parameters['starting_after'] = $this->nextToken;
        }

        $result = call_user_func_array([ $api, 'all' ], [ $parameters ]);

        $this->nextToken = $result['has_more'] ? end($result['data'])['id'] : false;

        return $result;
    }
}
