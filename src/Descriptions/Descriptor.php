<?php

namespace Cartalyst\Stripe\Descriptions;

use Symfony\Component\Finder\Finder;
use Guzzle\Service\Description\ServiceDescription;

class Descriptor
{
    /**
     * The Stripe API version.
     *
     * @var string
     */
    protected $apiVersion;

    protected $versions = [];

    public function __construct()
    {
        $finder = (new Finder)->name('Description.php')->in(__DIR__.'/*');

        foreach ($finder as $file) {
            preg_match('/V\d+(?:\_\d)/', $file->getRealpath(), $matches);

            $className = "Cartalyst\\Stripe\\Descriptions\\{$matches[0]}\\Description";

            foreach ((new $className)->getSupportedVersions() as $version)
            {
                $this->versions[$version][] = $matches[0];
            }
        }
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

    public function getVersions()
    {
        return $this->versions;
    }


    public function make($apiVersion)
    {
        # this will return the Guzzle ServiceDescription with the proper payload

        # make sure to cache everything to avoid repeating calls..
    }

    /**
     * Returns the current request payload.
     *
     * @param  string  $method
     * @return \Guzzle\Service\Description\ServiceDescription
     */
    protected function buildPayload($method)
    {
        $operations = $this->getPayload($method);

        $description = $this->getPayload('description', false);

        return ServiceDescription::factory(
            array_merge($description, compact('operations'))
        );
    }
    /**
     * Returns the given request manifest file.
     *
     * @param  string  $file
     * @return string
     */
    public function getFile($file)
    {
        die;
        $file = ucwords($file);

        return __DIR__."/../Descriptions/{$this->apiVersion}/{$file}.php";
    }

    /**
     * Checks if the manifest file for the current request exists.
     *
     * @param  string  $file
     * @return bool
     */
    protected function manifestExists($file)
    {
        return file_exists($this->getFile($file));
    }

    /**
     * Returns the given file manifest data.
     *
     * @param  string  $file
     * @param  bool  $includeErrors
     * @return array
     */
    protected function getPayload($file, $includeErrors = true)
    {
        if ($includeErrors) {
            $errors = require_once $this->getFile('errors');
        }

        return require_once $this->getFile($file);
    }
}
