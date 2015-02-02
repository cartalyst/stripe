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

namespace Cartalyst\Stripe\Descriptions;

abstract class Description
{
    /**
     * The Stripe API endpoint.
     *
     * @var string
     */
    protected $apiEndpoint = 'https://api.stripe.com';

    /**
     * Constructor.
     *
     * @param  string  $apiVersion
     * @return void
     */
    // public function __construct($apiVersion = null)
    // {
    //     $this->apiVersion = $apiVersion;
    // }

    /**
     * Returns the Stripe API Endpoint.
     *
     * @return string
     */
    public function getApiEndpoint()
    {
        return $this->apiEndpoint;
    }

    /**
     * Sets the Stripe API Endpoint.
     *
     * @param  string  $apiEndpoint
     * @return $this
     */
    public function setApiEndpoint($apiEndpoint)
    {
        $this->apiEndpoint = $apiEndpoint;

        return $this;
    }

    /**
     * Returns a list of all the Stripe versions supported by this description.
     *
     * @return array
     */
    abstract public function getSupportedVersions();

    /**
     * Returns a list of all the supported operations by this description.
     *
     * @return array
     */
    abstract public function getSupportedOperations();




    public function make($method)
    {
        if ( ! $this->isValidVersion()) {
            throw new \Exception('The current API Version is not supported.');
        }

        $this->getPayload($method);

        // return ServiceDescription::factory(
        //     (new static)->getPayload($method)
        // );
    }


    protected function getAttributes()
    {
        return [
            'name'        => 'Stripe',
            'description' => 'Stripe payment system.',
            'baseUrl'     => $this->apiEndpoint,
            'apiVersion'  => $this->apiVersion,
            'operations'  => [],
        ];
    }

    protected function getOperationPayload($method)
    {
        var_dump($this->getSupportedOperations());die;
        # todo...

        #return [];

        # check if the method exists
        if (method_exists($this, $method))
        {
            var_dump('Yes :)');die;
        }

        var_dump('Nops :c');die;
    }

    protected function getPayload($method)
    {
        $operations = $this->getOperationPayload($method);

        return array_merge($this->getAttributes(), compact('operations'));
    }

    /**
     * Checks if the current api version is supported by this description.
     *
     * @return bool
     */
    protected function isValidVersion()
    {
        return in_array($this->apiVersion, $this->getSupportedVersions());
    }
}
