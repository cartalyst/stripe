<?php

declare(strict_types=1);

/*
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
 * @version    3.0.0
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2020, Cartalyst LLC
 * @link       https://cartalyst.com
 */

namespace Cartalyst\Stripe\Api;

use ArrayAccess;
use JsonSerializable;
use RuntimeException;

class ApiResponse implements ArrayAccess, JsonSerializable
{
    /**
     * The body of the Stripe response.
     *
     * @var array
     */
    protected $data = [];

    /**
     * The headers of the Stripe response.
     *
     * @var array
     */
    protected $headers = [];

    /**
     * Constructor.
     *
     * @param array $data
     * @param array $headers
     *
     * @return void
     */
    public function __construct(array $data, array $headers)
    {
        $this->data = $data;

        $this->headers = $headers;
    }

    /**
     * Returns the headers of the Stripe response.
     *
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * Determine if the given attribute exists.
     *
     * @param mixed $offset
     *
     * @return bool
     */
    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->data);
    }

    /**
     * Get the value for a given offset.
     *
     * @param mixed $offset
     *
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return array_key_exists($offset, $this->data) ? $this->data[$offset] : null;
    }

    /**
     * Set the value for a given offset.
     *
     * @param mixed $offset
     * @param mixed $value
     *
     * @throws \RuntimeException
     *
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        throw new RuntimeException('Setting values on this object is not allowed.');
    }

    /**
     * Unset the value for a given offset.
     *
     * @param mixed $offset
     *
     * @throws \RuntimeException
     *
     * @return void
     */
    public function offsetUnset($offset)
    {
        throw new RuntimeException('Unsetting values from this object is not allowed.');
    }

    /**
     * Determine if an attribute exists on the data.
     *
     * @param string $key
     *
     * @return bool
     */
    public function __isset(string $key)
    {
        return isset($this->data[$key]);
    }

    /**
     * Dynamically get properties from the data.
     *
     * @param string $key
     *
     * @return mixed
     */
    public function __get(string $key)
    {
        return $this->data[$key];
    }

    /**
     * Unset an attribute on the data.
     *
     * @param string $key
     *
     * @throws \RuntimeException
     *
     * @return void
     */
    public function __unset(string $key)
    {
        throw new RuntimeException('Unsetting values from this object is not allowed.');
    }

    /**
     * Returns the data as an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return $this->data;
    }

    /**
     * Converts the data into something JSON serializable.
     *
     * @return array
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    /**
     * Converts the data to its JSON representation.
     *
     * @param int $options
     *
     * @return string
     */
    public function toJson($options = 0): string
    {
        return json_encode($this->jsonSerialize(), $options);
    }
}
