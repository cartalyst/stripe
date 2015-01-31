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

use Exception;
use Guzzle\Http\Message\Request;
use Guzzle\Http\Message\Response;
use Doctrine\Common\Inflector\Inflector;
use Guzzle\Service\Command\CommandInterface;
use Guzzle\Plugin\ErrorResponse\ErrorResponseExceptionInterface;

class StripeException extends Exception implements ErrorResponseExceptionInterface
{
    /**
     * The Guzzle request.
     *
     * @var \Guzzle\Http\Message\Request
     */
    protected $request;

    /**
     * The Guzzle response.
     *
     * @var \Guzzle\Http\Message\Response
     */
    protected $response;

    /**
     * The error type returned by Stripe.
     *
     * @var string
     */
    protected $errorType;

    /**
     * {@inheritDoc}
     */
    public static function fromCommand(CommandInterface $command, Response $response)
    {
        $errors = json_decode($response->getBody(true), true);

        $statusCode = $response->getStatusCode();

        $type = isset($errors['error']['type']) ? $errors['error']['type'] : null;

        $message = isset($errors['error']['message']) ? $errors['error']['message'] : null;

        $type = str_replace(' ', '', ucwords(str_replace(array('-', '_'), ' ', $type)));

        $class = "\Cartalyst\Stripe\Exception\{$type}Exception";

        if (class_exists($class)) {
            $exception = new $class($message, $statusCode);
        } else {
            $exception = new static($message, $statusCode);
        }

        $exception->setErrorType($type);

        $exception->setResponse($response);

        $exception->setRequest($command->getRequest());

        return $exception;
    }

    /**
     * Returns the Guzzle request.
     *
     * @return \Guzzle\Http\Message\Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * Sets the Guzzle request.
     *
     * @param  \Guzzle\Http\Message\Request  $request
     * @return void
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Returns the Guzzle response.
     *
     * @return \Guzzle\Http\Message\Response
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * Sets the Guzzle response.
     *
     * @param  \Guzzle\Http\Message\Response  $response
     * @return void
     */
    public function setResponse(Response $response)
    {
        $this->response = $response;
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
     * @return void
     */
    public function setErrorType($errorType)
    {
        $this->errorType = $errorType;
    }
}
