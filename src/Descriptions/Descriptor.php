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

use Symfony\Component\Finder\Finder;
use Guzzle\Service\Description\ServiceDescription;

class Descriptor
{
    /**
     * The Stripe API endpoint.
     *
     * @var string
     */
    protected $apiEndpoint = 'https://api.stripe.com';

    /**
     * The Stripe API version.
     *
     * @var string
     */
    protected $apiVersion;

    /**
     * Holds all the supported Stripe versions and their
     * corresponding descriptions versions.
     *
     * @var array
     */
    protected $versions = [];

    /**
     * The cached descriptions.
     *
     * @var array
     */
    protected $descriptions = [];

    /**
     * Holds the errors to be used on the descriptions operations.
     *
     * @var array
     */
    protected $errors = [];

    /**
     * Constructor.
     *
     * @return void
     */
    public function __construct()
    {
        $this->fetchDescriptions();
    }

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
     * Returns the Stripe API Version.
     *
     * @return string
     */
    public function getApiVersion()
    {
        return $this->apiVersion;
    }

    /**
     * Returns the Stripe API Version.
     *
     * @param  string  $apiVersion
     * @return $this
     */
    public function setApiVersion($apiVersion)
    {
        $this->apiVersion = $apiVersion;

        return $this;
    }

    /**
     * Resolves the current request payload.
     *
     * @param  string  $method
     * @return \Guzzle\Service\Description\ServiceDescription
     */
    public function resolve($method)
    {
        if ( ! in_array($method, $this->descriptions))
        {
            $this->descriptions[$method] = $this->makeDescription($method);
        }

        return $this->descriptions[$method];
    }

    /**
     * Checks if the operation file for the current request exists.
     *
     * @param  string  $file
     * @return bool
     */
    public function exists($file)
    {
        return file_exists($this->getFile($file));
    }

    /**
     * Creates a Guzzle Service Description instance of the given method.
     *
     * @param  string  $method
     * @return \Guzzle\Service\Description\ServiceDescription
     */
    protected function makeDescription($method)
    {
        $attributes = $this->getAttributes();

        $operations = $this->getOperationPayload($method);

        return ServiceDescription::factory(
            array_merge($attributes, compact('operations'))
        );
    }

    /**
     * Fetches all the available descriptions.
     *
     * @return void
     */
    protected function fetchDescriptions()
    {
        $finder = (new Finder)->files()->name('[0-9].[0-9].php')->depth(0)->in(__DIR__);

        foreach ($finder as $file)
        {
            $contents = require_once $file->getRealpath();

            $descriptionVersion = str_replace('.php', null, $file->getFilename());

            foreach ($contents as $version)
            {
                $this->versions[$version][] = $descriptionVersion;
            }
        }
    }

    /**
     * Returns the base attributes for the description.
     *
     * @return array
     */
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

    /**
     * Returns the description errors array to be used on the operations.
     *
     * @return array
     */
    protected function getErrors()
    {
        if (empty($this->errors))
        {
            $this->errors = require_once __DIR__.'/Errors.php';
        }

        return $this->errors;
    }

    /**
     * Returns the latest description version for the
     * current Stripe API version.
     *
     * @return string
     */
    protected function getLatestStableVersion()
    {
        return end($this->versions[$this->apiVersion]);
    }

    /**
     * Returns the given request operation file path.
     *
     * @param  string  $file
     * @return string
     */
    protected function getFile($method)
    {
        $file = ucwords($method);

        return __DIR__."/{$this->getLatestStableVersion()}/{$file}.php";
    }

    /**
     * Returns the given method operation payload.
     *
     * @param  string  $method
     * @return array
     */
    protected function getOperationPayload($method)
    {
        $errors = $this->getErrors();

        return require_once $this->getFile($method);
    }
}
