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

class Pager
{
    /**
     * The Api instance.
     *
     * @var \Cartalyst\Stripe\Api\ApiInterface  $api
     */
    protected $api;

    /**
     * The next request token.
     *
     * @var array
     */
    protected $nextToken;

    /**
     * Constructor.
     *
     * @param  \Cartalyst\Stripe\Api\ApiInterface  $api
     * @return void
     */
    public function __construct(ApiInterface $api)
    {
        $this->api = $api;
    }

    /**
     * Fetches all the objects of the given api.
     *
     * @param  array  $parameters
     * @return array
     */
    public function fetch(array $parameters = [])
    {
        $this->api->setPerPage(100);

        $results = $this->processRequest($parameters);

        while ($this->nextToken) {
            $results = array_merge($results, $this->processRequest($parameters));
        }

        return $results;
    }

    /**
     * Processes the api request.
     *
     * @param  array  $parameters
     * @return array
     */
    protected function processRequest(array $parameters = [])
    {
        if ($this->nextToken) {
            $parameters['starting_after'] = $this->nextToken;
        }

        $result = call_user_func_array([ $this->api, 'all' ], [ $parameters ]);

        $this->nextToken = $result['has_more'] ? end($result['data'])['id'] : false;

        return $result['data'];
    }
}
