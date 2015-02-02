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

namespace Cartalyst\Stripe\Util;

class Description
{
    /**
     * The api version to be used.
     *
     * @var string
     */
    protected $apiVersion;

    /**
     * Returns the api version.
     *
     * @return string
     */
    public function getApiVersion()
    {
        return $this->apiVersion;
    }

    /**
     * Sets the api version.
     *
     * @param  string  $apiVersion
     * @return void
     */
    public function setApiVersion($apiVersion)
    {
        $this->apiVersion = $apiVersion;
    }

    /**
     * Returns the given request manifest file.
     *
     * @param  string  $file
     * @return string
     */
    public function getFile($file)
    {
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
