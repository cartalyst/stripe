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

namespace Cartalyst\Stripe\Tests\Descriptions;

use PHPUnit_Framework_TestCase;
use Cartalyst\Stripe\Descriptions\Descriptor;

class DescriptorTest extends PHPUnit_Framework_TestCase
{
    /**
     * The descriptor instance.
     *
     * @var \Cartalyst\Stripe\Descriptions\Descriptor
     */
    protected $descriptor;

    /**
     * Setup resources and dependencies
     *
     * @return void
     */
    public function setUp()
    {
        $this->descriptor = new Descriptor;
        $this->descriptor->setApiVersion('2015-01-26');
    }

    /** @test */
    public function it_can_be_instantiated()
    {
        new Descriptor;
    }

    /** @test */
    public function it_can_get_and_set_the_api_endpoint()
    {
        $this->assertEquals('https://api.stripe.com', $this->descriptor->getApiEndpoint());

        $this->descriptor->setApiEndpoint('http://api.stripe.com');

        $this->assertEquals('http://api.stripe.com', $this->descriptor->getApiEndpoint());
    }

    /** @test */
    public function it_can_get_and_set_the_api_version()
    {
        $this->assertEquals('2015-01-26', $this->descriptor->getApiVersion());

        $this->descriptor->setApiVersion('2015-01-11');

        $this->assertEquals('2015-01-11', $this->descriptor->getApiVersion());
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function if_an_invalid_api_version_is_used_it_throws_an_exception()
    {
        $this->descriptor->setApiVersion('1.2.3');
    }

    /** @test */
    public function it_can_resolve_a_description()
    {
        $this->descriptor->resolve('customers');
    }

    /** @test */
    public function it_can_check_if_an_operation_file_exists()
    {
        $this->assertTrue($this->descriptor->exists('customers'));
    }
}
