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

class CreditNotes extends Api
{
    /**
     * Creates a new credit note.
     *
     * @param array $parameters
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function create(array $parameters = []): ApiResponse
    {
        return $this->_post('credit_notes', $parameters);
    }

    /**
     * Retrieves an existing credit note.
     *
     * @param string $creditNoteId
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function find(string $creditNoteId): ApiResponse
    {
        return $this->_get("credit_notes/{$creditNoteId}");
    }

    /**
     * Updates an existing credit notes.
     *
     * @param string $creditNoteId
     * @param array  $parameters
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function update(string $creditNoteId, array $parameters = []): ApiResponse
    {
        return $this->_post("credit_notes/{$creditNoteId}", $parameters);
    }

    /**
     * Void the given credit note.
     *
     * @param string $creditNoteId
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function void(string $creditNoteId): ApiResponse
    {
        return $this->_post("credit_notes/{$creditNoteId}/void");
    }

    /**
     * Lists all credit notes.
     *
     * @param array $parameters
     *
     * @return \Cartalyst\Stripe\Api\ApiResponse
     */
    public function all(array $parameters = []): ApiResponse
    {
        return $this->_get('credit_notes', $parameters);
    }
}
