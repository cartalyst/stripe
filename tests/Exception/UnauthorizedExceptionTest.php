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

namespace Cartalyst\Stripe\Tests\Exception;

use PHPUnit\Framework\TestCase;
use Cartalyst\Stripe\Exception\ExceptionFactory;
use Cartalyst\Stripe\Exception\UnauthorizedException;

class UnauthorizedExceptionTest extends TestCase
{
    /** @test */
    public function the_proper_exception_class_will_be_returned()
    {
        $class = ExceptionFactory::create(401, 'Unauthorized');

        $this->assertInstanceOf(UnauthorizedException::class, $class);
        $this->assertSame('Unauthorized', $class->getMessage());
    }
}
