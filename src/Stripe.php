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

namespace Cartalyst\Stripe;

use ReflectionClass;
use Cartalyst\Stripe\Api\ApiInterface;

/**
 * @method static \Cartalyst\Stripe\Api\Account account()
 * @method static \Cartalyst\Stripe\Api\ApplicationFeeRefunds applicationFeeRefunds()
 * @method static \Cartalyst\Stripe\Api\ApplicationFees applicationFees
 * @method static \Cartalyst\Stripe\Api\Balance balance()
 * @method static \Cartalyst\Stripe\Api\BalanceTransactions balanceTransactions()
 * @method static \Cartalyst\Stripe\Api\BankAccounts bankAccounts()
 * @method static \Cartalyst\Stripe\Api\Bitcoin bitcoin()
 * @method static \Cartalyst\Stripe\Api\Cards cards()
 * @method static \Cartalyst\Stripe\Api\Charges charges()
 * @method static \Cartalyst\Stripe\Api\Checkout checkout()
 * @method static \Cartalyst\Stripe\Api\CountrySpecs countrySpecs()
 * @method static \Cartalyst\Stripe\Api\Coupons coupons()
 * @method static \Cartalyst\Stripe\Api\CreditNotes creditNotes()
 * @method static \Cartalyst\Stripe\Api\CustomerBalanceTransactions customerBalanceTransactions()
 * @method static \Cartalyst\Stripe\Api\Customers customers()
 * @method static \Cartalyst\Stripe\Api\CustomerTaxIds customerTaxIds()
 * @method static \Cartalyst\Stripe\Api\Disputes disputes()
 * @method static \Cartalyst\Stripe\Api\EphemeralKey ephemeralKey()
 * @method static \Cartalyst\Stripe\Api\Events events()
 * @method static \Cartalyst\Stripe\Api\ExternalAccounts externalAccounts()
 * @method static \Cartalyst\Stripe\Api\FileLinks fileLinks()
 * @method static \Cartalyst\Stripe\Api\Files files()
 * @method static \Cartalyst\Stripe\Api\InvoiceItems invoiceItems()
 * @method static \Cartalyst\Stripe\Api\Invoices invoices()
 * @method static \Cartalyst\Stripe\Api\OrderReturns orderReturns()
 * @method static \Cartalyst\Stripe\Api\Orders orders()
 * @method static \Cartalyst\Stripe\Api\PaymentIntents paymentIntents()
 * @method static \Cartalyst\Stripe\Api\PaymentMethods paymentMethods()
 * @method static \Cartalyst\Stripe\Api\Payouts payouts()
 * @method static \Cartalyst\Stripe\Api\Plans plans()
 * @method static \Cartalyst\Stripe\Api\Products products()
 * @method static \Cartalyst\Stripe\Api\Radar radar()
 * @method static \Cartalyst\Stripe\Api\Recipients recipients()
 * @method static \Cartalyst\Stripe\Api\Refunds refunds()
 * @method static \Cartalyst\Stripe\Api\ScheduledQueries scheduledQueries()
 * @method static \Cartalyst\Stripe\Api\SetupItems setupItems()
 * @method static \Cartalyst\Stripe\Api\Subscriptions subscriptions()
 * @method static \Cartalyst\Stripe\Api\SubscriptionSchedule subscriptionSchedule()
 * @method static \Cartalyst\Stripe\Api\TaxRates taxRates()
 * @method static \Cartalyst\Stripe\Api\Terminal terminal()
 * @method static \Cartalyst\Stripe\Api\Tokens tokens()
 * @method static \Cartalyst\Stripe\Api\Topup topup()
 * @method static \Cartalyst\Stripe\Api\TransferReversals transferReversals()
 * @method static \Cartalyst\Stripe\Api\Transfers transfers()
 * @method static \Cartalyst\Stripe\Api\UsageRecords usageRecords()
 * @method static \Cartalyst\Stripe\Api\WebhookEndpoints webhookEndpoints()
 */
class Stripe
{
    /**
     * The package version.
     *
     * @var string
     */
    const VERSION = '3.0.0';

    /**
     * The Config instance.
     *
     * @var \Cartalyst\Stripe\ConfigInterface
     */
    protected $config;

    /**
     * Constructor.
     *
     * @param string $apiKey
     * @param string $apiVersion
     *
     * @return void
     */
    public function __construct(string $apiKey, string $apiVersion)
    {
        $this->config = new Config($apiKey, $apiVersion);
    }

    /**
     * Returns the current package version.
     *
     * @return string
     */
    public static function getVersion(): string
    {
        return self::VERSION;
    }

    /**
     * Returns the Config repository instance.
     *
     * @return \Cartalyst\Stripe\ConfigInterface
     */
    public function getConfig(): ConfigInterface
    {
        return $this->config;
    }

    /**
     * Sets the Config repository instance.
     *
     * @param \Cartalyst\Stripe\ConfigInterface $config
     *
     * @return $this
     */
    public function setConfig(ConfigInterface $config): self
    {
        $this->config = $config;

        return $this;
    }

    /**
     * Returns the Stripe API key.
     *
     * @return string
     */
    public function getApiKey(): string
    {
        return $this->config->getApiKey();
    }

    /**
     * Sets the Stripe API key.
     *
     * @param string $apiKey
     *
     * @return $this
     */
    public function setApiKey(string $apiKey): self
    {
        $this->config->setApiKey($apiKey);

        return $this;
    }

    /**
     * Returns the Stripe API version.
     *
     * @return string
     */
    public function getApiVersion(): string
    {
        return $this->config->getApiVersion();
    }

    /**
     * Sets the Stripe API version.
     *
     * @param string $apiVersion
     *
     * @return $this
     */
    public function setApiVersion(string $apiVersion): self
    {
        $this->config->setApiVersion($apiVersion);

        return $this;
    }

    /**
     * Sets the account id.
     *
     * @param string|null $accountId
     *
     * @return $this
     */
    public function accountId(?string $accountId): self
    {
        $this->config->setAccountId($accountId);

        return $this;
    }

    /**
     * Returns the application's information.
     *
     * @return array|null
     */
    public function getAppInfo(): ?array
    {
        return $this->config->getAppInfo();
    }

    /**
     * Sets the application's information.
     *
     * @param string      $appName
     * @param string|null $appVersion
     * @param string|null $appUrl
     * @param string|null $appPartnerId
     *
     * @return $this
     */
    public function setAppInfo(string $appName, ?string $appVersion = null, ?string $appUrl = null, ?string $appPartnerId = null): self
    {
        $this->config->setAppInfo($appName, $appVersion, $appUrl, $appPartnerId);

        return $this;
    }

    /**
     * Dynamically handle missing methods.
     *
     * @param string $method
     * @param array  $parameters
     *
     * @return mixed
     */
    public function __call(string $method, array $parameters)
    {
        if ($this->isIteratorRequest($method)) {
            $apiInstance = $this->getApiInstance(substr($method, 0, -8));

            return (new Pager($apiInstance))->fetch($parameters);
        }

        return $this->getApiInstance($method);
    }

    /**
     * Determines if the request is an iterator request.
     *
     * @param string $method
     *
     * @return bool
     */
    protected function isIteratorRequest(string $method): bool
    {
        return substr($method, -8) === 'Iterator';
    }

    /**
     * Returns the Api class instance for the given method.
     *
     * @param string $method
     *
     * @throws \BadMethodCallException
     *
     * @return \Cartalyst\Stripe\Api\ApiInterface
     */
    protected function getApiInstance(string $method): ApiInterface
    {
        $class = 'Cartalyst\\Stripe\\Api\\'.ucwords($method);

        if (class_exists($class) && ! (new ReflectionClass($class))->isAbstract()) {
            return new $class($this->config);
        }

        throw new \BadMethodCallException("Undefined method [{$method}] called.");
    }
}
