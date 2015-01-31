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

namespace Cartalyst\Stripe\Models;

use Closure;
use Countable;
use ArrayAccess;
use IteratorAggregate;
use Cartalyst\Stripe\Stripe;
use Guzzle\Service\Command\OperationCommand;
use Guzzle\Service\Command\ResponseClassInterface;

class Collection implements ArrayAccess, Countable, IteratorAggregate, ResponseClassInterface
{
    /**
     * The items contained in the collection.
     *
     * @var array
     */
    protected $items = [];

    /**
     * List of API response properties that'll be
     * automatically converted into collections.
     *
     * @var array
     */
    protected $collections = [];

    /**
     * The Stripe API client instance.
     *
     * @var \Cartalyst\Stripe\Stripe
     */
    protected $apiClient;

    /**
     * Create a new collection.
     *
     * @param  array  $items
     * @return void
     */
    public function __construct(array $items = [])
    {
        $this->items = $items;
    }

    /**
     * Create a new collection instance if the value isn't one already.
     *
     * @param  mixed  $items
     * @return \Cartalyst\Stripe\Models\Collection
     */
    public static function make($items)
    {
        if (is_null($items)) return new static;

        if ($items instanceof Collection) return $items;

        return new static(is_array($items) ? $items : [ $items ]);
    }

    /**
     * Returns the Stripe API client instance.
     *
     * @return \Cartalyst\Stripe\Stripe
     */
    public function getApiClient()
    {
        return $this->apiClient;
    }

    /**
     * Sets the Stripe API client instance.
     *
     * @param \Cartalyst\Stripe\Stripe  $client
     * @return void
     */
    public function setApiClient(Stripe $client)
    {
        $this->apiClient = $client;
    }

    /**
     * Create a response model object from a completed command.
     *
     * @param  \Guzzle\Service\Command\OperationCommand  $command
     * @return \Cartalyst\Stripe\Models\Collection
     */
    public static function fromCommand(OperationCommand $command)
    {
        // Initialize the collection
        $collection = new self($command->getResponse()->json());

        // Set the Stripe API client on the collection
        $collection->setApiClient($command->getClient()->getApiClient());

        // Return the collection
        return $collection;
    }

    /**
     * Returns all of the items in the collection.
     *
     * @return array
     */
    public function all()
    {
        return $this->items;
    }

    /**
     * Counts the number of items in the collection.
     *
     * @return int
     */
    public function count()
    {
        return count($this->items);
    }

    /**
     * Determines if the given item exists in the collection.
     *
     * @param  string  $key
     * @return bool
     */
    public function exists($key)
    {
        return (bool) $this->offsetExists($key);
    }

    /**
     * Returns the given item from the collection.
     *
     * @param  mixed  $key
     * @return mixed
     */
    public function find($key)
    {
        return $this->offsetGet($key);
    }

    /**
     * Returns the first item from the collection.
     *
     * @return mixed|null
     */
    public function first()
    {
        return count($this->items) > 0 ? reset($this->items) : null;
    }

    /**
     * Returns an item from the collection.
     *
     * @param  string  $key
     * @param  mixed  $default
     * @return mixed
     */
    public function get($key, $default = null)
    {
        if (array_key_exists($key, $this->items))
        {
            return $this->items[$key];
        }

        return $default;
    }

    /**
     * Determines if an item exists in the collection by key.
     *
     * @param  mixed  $key
     * @return bool
     */
    public function has($key)
    {
        return array_key_exists($key, $this->items);
    }

    /**
     * Determines if the collection is empty or not.
     *
     * @return bool
     */
    public function isEmpty()
    {
        return empty($this->items);
    }

    /**
     * Returns the last item from the collection.
     *
     * @return mixed|null
     */
    public function last()
    {
        return count($this->items) > 0 ? end($this->items) : null;
    }

    /**
     * Determines if the given offset exists.
     *
     * @param  string  $key
     * @return bool
     */
    public function offsetExists($key)
    {
        if (isset($this->items[$key]))
        {
            return true;
        }

        return false;
    }

    /**
     * Returns the value for a given offset.
     *
     * @param  string  $key
     * @return mixed
     */
    public function offsetGet($key)
    {
        if (isset($this->items[$key]))
        {
            return $this->items[$key];
        }
    }

    /**
     * Set the value at the given offset.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return void
     */
    public function offsetSet($key, $value)
    {
        $this->items[$key] = $value;
    }

    /**
     * Unset the value at the given offset.
     *
     * @param  string  $key
     * @return void
     */
    public function offsetUnset($key)
    {
        unset($this->items[$key]);
    }

    /**
     * Unset the value at the given offset.
     *
     * @param  string  $key
     * @return void
     */
    public function pull($key)
    {
        $this->offsetUnset($key);
    }

    /**
     * Set the value at the given offset.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return void
     */
    public function put($key, $value)
    {
        $this->offsetSet($key, $value);
    }

    /**
     * Sort the collection using the given Closure.
     *
     * @param  \Closure|string  $callback
     * @param  int  $options
     * @param  bool  $descending
     * @return $this
     */
    public function sortBy($callback, $options = SORT_REGULAR, $descending = false)
    {
        $results = [];

        if (is_string($callback)) {
            $callback = function($item) use ($callback) {
                if (is_null($callback)) return $item;

                foreach (explode('.', $callback) as $segment) {
                    if (is_array($item)) {
                        if ( ! array_key_exists($segment, $item)) {
                            return null;
                        }

                        $item = $item[$segment];
                    }
                }

                return $item;
            };
        }

        // First we will loop through the items and get the comparator from a callback
        // function which we were given. Then, we will sort the returned values and
        // and grab the corresponding values for the sorted keys from this array.
        foreach ($this->items as $key => $value) {
            $results[$key] = $callback($value);
        }

        $descending ? arsort($results, $options) : asort($results, $options);

        // Once we have sorted all of the keys in the array, we will loop through them
        // and grab the corresponding model so we can set the underlying items list
        // to the sorted version. Then we'll just return the collection instance.
        foreach (array_keys($results) as $key) {
            $results[$key] = $this->items[$key];
        }

        $this->items = $results;

        return $this;
    }

    /**
     * Sort the collection in descending order using the given Closure.
     *
     * @param  \Closure|string  $callback
     * @param  int  $options
     * @return $this
     */
    public function sortByDesc($callback, $options = SORT_REGULAR)
    {
        return $this->sortBy($callback, $options, true);
    }

    /**
     * Returns the collection of items as a plain array.
     *
     * @return array
     */
    public function toArray()
    {
        return array_map(function($value) {
            return $value;
        }, $this->items);
    }

    /**
     * Returns the collection of items as JSON.
     *
     * @param  int  $options
     * @return string
     */
    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), $options);
    }

    /**
     * Dynamically retrieve the value of an item.
     *
     * @param  string  $key
     * @return mixed
     */
    public function __get($key)
    {
        $value = $this->get($key);

        if (method_exists($this, $method = "{$key}Attribute")) {
            return $this->{$method}($value);
        }

        return $value;
    }

    /**
     * Dynamically set the value of an item.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return void
     */
    public function __set($key, $value)
    {
        $this->items[$key] = $value;
    }

    /**
     * Dynamically check if an item is set.
     *
     * @param  string  $key
     * @return void
     */
    public function __isset($key)
    {
        return isset($this->items[$key]);
    }

    /**
     * Dynamically unset an item.
     *
     * @param  string  $key
     * @return void
     */
    public function __unset($key)
    {
        unset($this->items[$key]);
    }

    /**
     * Convert the collection to its string representation.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->toJson();
    }
}
