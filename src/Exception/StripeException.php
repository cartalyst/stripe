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

namespace Cartalyst\Stripe\Exception;

class StripeException extends \Exception
{
    /**
     * The error code returned by Stripe.
     *
     * @var string
     */
    protected $errorCode;

    /**
     * The error type returned by Stripe.
     *
     * @var string
     */
    protected $errorType;

    /**
     * The missing parameter returned by Stripe with the error.
     *
     * @var string
     */
    protected $missingParameter;

    /**
     * The raw output returned by Stripe in case of exception.
     *
     * @var string
     */
    protected $rawOutput;

    /**
     * Returns the error type returned by Stripe.
     *
     * @return string
     */
    public function getErrorCode()
    {
        return $this->errorCode;
    }

    /**
     * Sets the error type returned by Stripe.
     *
     * @param  string  $errorCode
     * @return $this
     */
    public function setErrorCode($errorCode)
    {
        $this->errorCode = $errorCode;

        return $this;
    }

    /**
     * Returns the error type returned by Stripe.
     *
     * @return string
     */
    public function getErrorType()
    {
        return $this->errorType;
    }

    /**
     * Sets the error type returned by Stripe.
     *
     * @param  string  $errorType
     * @return $this
     */
    public function setErrorType($errorType)
    {
        $this->errorType = $errorType;

        return $this;
    }

    /**
     * Returns missing parameter returned by Stripe with the error.
     *
     * @return string
     */
    public function getMissingParameter()
    {
        return $this->missingParameter;
    }

    /**
     * Sets the missing parameter returned by Stripe with the error.
     *
     * @param  string  $missingParameter
     * @return $this
     */
    public function setMissingParameter($missingParameter)
    {
        $this->missingParameter = $missingParameter;

        return $this;
    }

    /**
     * Returns raw output returned by Stripe in case of exception.
     *
     * @return string
     */
    public function getRawOutput()
    {
        return $this->rawOutput;
    }

    /**
     * Sets the raw output parameter returned by Stripe in case of exception.
     *
     * @param  string  $rawOutput
     * @return $this
     */
    public function setRawOutput($rawOutput)
    {
        $this->rawOutput = $rawOutput;

        return $this;
    }
}
