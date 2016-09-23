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

        if (isset($parameters[0])) {
            $id = $parameters[0];

            unset($parameters[0]);

            if (isset($parameters[1])) {
                $parameters = $parameters[1];

                unset($parameters[1]);
            }

            $parameters = [ $id, $parameters ];
        } else {
            $parameters = [ $parameters ];
        }

        $result = call_user_func_array([ $this->api, 'all' ], $parameters);

        $this->nextToken = $result['has_more'] ? end($result['data'])['id'] : false;

        return $result['data'];
    }
}
