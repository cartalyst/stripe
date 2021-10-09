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
 * @version    2.4.6
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2021, Cartalyst LLC
 * @link       https://cartalyst.com
 */

namespace Cartalyst\Stripe\Api;

class CreditNotes extends Api
{
    /**
     * Creates a new credit note.
     *
     * @param  array  $parameters
     * @return array
     */
    public function create(array $parameters = [])
    {
        return $this->_post('credit_notes', $parameters);
    }

    /**
     * Retrieves an existing credit note.
     *
     * @param  string  $creditNoteId
     * @return array
     */
    public function find($creditNoteId)
    {
        return $this->_get("credit_notes/{$creditNoteId}");
    }

    /**
     * Updates an existing credit notes.
     *
     * @param  string  $creditNoteId
     * @param  array  $parameters
     * @return array
     */
    public function update($creditNoteId, array $parameters = [])
    {
        return $this->_post("credit_notes/{$creditNoteId}", $parameters);
    }

    /**
     * Void the given credit note.
     *
     * @param  string  $creditNoteId
     * @return array
     */
    public function void($creditNoteId)
    {
        return $this->_post("credit_notes/{$creditNoteId}/void");
    }

    /**
     * Lists all credit notes.
     *
     * @param  array  $parameters
     * @return array
     */
    public function all(array $parameters = [])
    {
        return $this->_get('credit_notes', $parameters);
    }
}
