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
}
