<?php

/**
 * Part of the Stripe package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Cartalyst PSL License.
 *
 * This source file is subject to the Cartalyst PSL License that is
 * bundled with this package in the license.txt file.
 *
 * @package    Stripe
 * @version    1.0.0
 * @author     Cartalyst LLC
 * @license    Cartalyst PSL
 * @copyright  (c) 2011-2015, Cartalyst LLC
 * @link       http://cartalyst.com
 */

namespace Cartalyst\Stripe\Models;

use Guzzle\Service\Command\OperationCommand;

trait GuzzleCommandTrait
{
    /**
     * Create a response model object from a completed command.
     *
     * @param  \Guzzle\Service\Command\OperationCommand  $command
     * @return \Illuminate\Support\Collection
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
}
