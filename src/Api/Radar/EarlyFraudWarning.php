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
 * @version    2.4.2
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2020, Cartalyst LLC
 * @link       https://cartalyst.com
 */

namespace Cartalyst\Stripe\Api\Radar;

use Cartalyst\Stripe\Api\Api;

class EarlyFraudWarning extends Api
{
    /**
     * Retrieves an existing early fraud warning.
     *
     * @param  string  $earlyFraudWarningId
     * @return array
     */
    public function find($earlyFraudWarningId)
    {
        return $this->_get("radar/early_fraud_warnings/{$earlyFraudWarningId}");
    }

    /**
     * Lists all early fraud warnings.
     *
     * @param  array  $parameters
     * @return array
     */
    public function all(array $parameters = [])
    {
        return $this->_get('radar/early_fraud_warnings', $parameters);
    }
}
