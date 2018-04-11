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
 * @version    2.1.4
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2018, Cartalyst LLC
 * @link       http://cartalyst.com
 */

namespace Cartalyst\Stripe\Tests;

use PHPUnit_Framework_TestCase;
use Cartalyst\Stripe\AmountConverter;

class AmountConverterTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_can_convert_a_number_to_cents()
    {
        // Miscellaneous
        $this->assertSame('0.00', AmountConverter::convert('a'));
        $this->assertSame('1300', AmountConverter::convert('1a3f'));
        $this->assertSame('030', AmountConverter::convert('a0f.30'));
        $this->assertSame('1330', AmountConverter::convert('1a3f.30'));

        // 1 cent (0 U.S. dollars) + (1 U.S. cents) (this is not allowed by Stripe though)
        $this->assertSame('010', AmountConverter::convert(.10));
        $this->assertSame('010', AmountConverter::convert(0.10));
        $this->assertSame('010', AmountConverter::convert(0.10001));
        $this->assertSame('010', AmountConverter::convert(0.10011));
        $this->assertSame('010', AmountConverter::convert(0.10111));
        $this->assertSame('010', AmountConverter::convert('0.10001'));
        $this->assertSame('010', AmountConverter::convert('0.10011'));
        $this->assertSame('010', AmountConverter::convert('0.10111'));

        // 50 cents (0 U.S. dollars) + (50 U.S. cents)
        $this->assertSame('050', AmountConverter::convert(.50));
        $this->assertSame('050', AmountConverter::convert(0.50));
        $this->assertSame('050', AmountConverter::convert(0.50001));
        $this->assertSame('050', AmountConverter::convert(0.50011));
        $this->assertSame('050', AmountConverter::convert(0.50111));
        $this->assertSame('050', AmountConverter::convert('0.50001'));
        $this->assertSame('050', AmountConverter::convert('0.50011'));
        $this->assertSame('050', AmountConverter::convert('0.50111'));

        // 54 cents (0 U.S. dollars) + (54 U.S. cents)
        $this->assertSame('054', AmountConverter::convert(.54));
        $this->assertSame('054', AmountConverter::convert(0.54));
        $this->assertSame('054', AmountConverter::convert(0.54001));
        $this->assertSame('054', AmountConverter::convert(0.54011));
        $this->assertSame('054', AmountConverter::convert(0.54111));
        $this->assertSame('054', AmountConverter::convert('0.54001'));
        $this->assertSame('054', AmountConverter::convert('0.54011'));
        $this->assertSame('054', AmountConverter::convert('0.54111'));

        // 1 dollar (1 U.S. dollars) + (0 U.S. cents)
        $this->assertSame('100', AmountConverter::convert(1));
        $this->assertSame('100', AmountConverter::convert('1'));
        $this->assertSame('100', AmountConverter::convert(1.0));
        $this->assertSame('100', AmountConverter::convert(1.00));
        $this->assertSame('100', AmountConverter::convert('1.00'));
        $this->assertSame('100', AmountConverter::convert(1.00001));
        $this->assertSame('100', AmountConverter::convert(1.00011));
        $this->assertSame('100', AmountConverter::convert(1.00111));
        $this->assertSame('100', AmountConverter::convert('1.00001'));
        $this->assertSame('100', AmountConverter::convert('1.00011'));
        $this->assertSame('100', AmountConverter::convert('1.00111'));

        // 1.50 dollar (1 U.S. dollars) + (50 U.S. cents)
        $this->assertSame('150', AmountConverter::convert(1.50));
        $this->assertSame('150', AmountConverter::convert(1.50));
        $this->assertSame('150', AmountConverter::convert('1.50'));
        $this->assertSame('150', AmountConverter::convert(1.50001));
        $this->assertSame('150', AmountConverter::convert('1.50001'));

        // 1.53 dollar (1 U.S. dollars) + (53 U.S. cents)
        $this->assertSame('153', AmountConverter::convert(1.53));
        $this->assertSame('153', AmountConverter::convert(1.53));
        $this->assertSame('153', AmountConverter::convert('1.53'));
        $this->assertSame('153', AmountConverter::convert(1.53001));
        $this->assertSame('153', AmountConverter::convert(1.53011));
        $this->assertSame('153', AmountConverter::convert(1.53111));
        $this->assertSame('153', AmountConverter::convert('1.53001'));
        $this->assertSame('153', AmountConverter::convert('1.53011'));
        $this->assertSame('153', AmountConverter::convert('1.53111'));

        // 4 dollars (1 U.S. dollars) + (0 U.S. cents)
        $this->assertSame('400', AmountConverter::convert(4));
        $this->assertSame('400', AmountConverter::convert('4'));
        $this->assertSame('400', AmountConverter::convert(4.0));
        $this->assertSame('400', AmountConverter::convert(4.00));
        $this->assertSame('400', AmountConverter::convert('4.00'));
        $this->assertSame('400', AmountConverter::convert(4.00001));
        $this->assertSame('400', AmountConverter::convert(4.00011));
        $this->assertSame('400', AmountConverter::convert(4.00111));
        $this->assertSame('400', AmountConverter::convert('4.00001'));
        $this->assertSame('400', AmountConverter::convert('4.00011'));
        $this->assertSame('400', AmountConverter::convert('4.00111'));

        // 10 dollars (10 U.S. dollars) + (70 U.S. cents)
        $this->assertSame('1000', AmountConverter::convert(10));
        $this->assertSame('1000', AmountConverter::convert('10'));
        $this->assertSame('1000', AmountConverter::convert(10.0));
        $this->assertSame('1000', AmountConverter::convert(10.00));
        $this->assertSame('1000', AmountConverter::convert('10.00'));
        $this->assertSame('1000', AmountConverter::convert(10.00001));
        $this->assertSame('1000', AmountConverter::convert(10.00011));
        $this->assertSame('1000', AmountConverter::convert(10.00111));
        $this->assertSame('1000', AmountConverter::convert('10.00001'));
        $this->assertSame('1000', AmountConverter::convert('10.00011'));
        $this->assertSame('1000', AmountConverter::convert('10.00111'));

        // 12 dollars (12 U.S. dollars) + (0 U.S. cents)
        $this->assertSame('1200', AmountConverter::convert(12));
        $this->assertSame('1200', AmountConverter::convert('12'));
        $this->assertSame('1200', AmountConverter::convert(12.0));
        $this->assertSame('1200', AmountConverter::convert(12.00));
        $this->assertSame('1200', AmountConverter::convert('12.00'));
        $this->assertSame('1200', AmountConverter::convert(12.00001));
        $this->assertSame('1200', AmountConverter::convert(12.00011));
        $this->assertSame('1200', AmountConverter::convert(12.00111));
        $this->assertSame('1200', AmountConverter::convert('12.00001'));
        $this->assertSame('1200', AmountConverter::convert('12.00011'));
        $this->assertSame('1200', AmountConverter::convert('12.00111'));

        // 12.01 dollars (12 U.S. dollars) + (1 U.S. cents)
        $this->assertSame('1201', AmountConverter::convert(12.01));
        $this->assertSame('1201', AmountConverter::convert('12.01'));
        $this->assertSame('1201', AmountConverter::convert('12.01'));
        $this->assertSame('1201', AmountConverter::convert(12.01001));
        $this->assertSame('1201', AmountConverter::convert(12.01001));
        $this->assertSame('1201', AmountConverter::convert(12.01111));
        $this->assertSame('1201', AmountConverter::convert('12.01001'));
        $this->assertSame('1201', AmountConverter::convert('12.01011'));
        $this->assertSame('1201', AmountConverter::convert('12.01111'));

        // 12.17 dollars (12 U.S. dollars) + (17 U.S. cents)
        $this->assertSame('1217', AmountConverter::convert(12.17));
        $this->assertSame('1217', AmountConverter::convert('12.17'));
        $this->assertSame('1217', AmountConverter::convert(12.17001));
        $this->assertSame('1217', AmountConverter::convert(12.17011));
        $this->assertSame('1217', AmountConverter::convert(12.17111));
        $this->assertSame('1217', AmountConverter::convert('12.17001'));
        $this->assertSame('1217', AmountConverter::convert('12.17011'));
        $this->assertSame('1217', AmountConverter::convert('12.17111'));

        // 12.70 dollars (12 U.S. dollars) + (70 U.S. cents)
        $this->assertSame('1270', AmountConverter::convert(12.7));
        $this->assertSame('1270', AmountConverter::convert(12.70));
        $this->assertSame('1270', AmountConverter::convert('12.70'));
        $this->assertSame('1270', AmountConverter::convert(12.70001));
        $this->assertSame('1270', AmountConverter::convert(12.70011));
        $this->assertSame('1270', AmountConverter::convert(12.70111));
        $this->assertSame('1270', AmountConverter::convert('12.70001'));
        $this->assertSame('1270', AmountConverter::convert('12.70011'));
        $this->assertSame('1270', AmountConverter::convert('12.70111'));

        // 12.90 dollars (12 U.S. dollars) + (90 U.S. cents)
        $this->assertSame('1290', AmountConverter::convert(12.9));
        $this->assertSame('1290', AmountConverter::convert(12.90));
        $this->assertSame('1290', AmountConverter::convert('12.90'));
        $this->assertSame('1290', AmountConverter::convert(12.90001));
        $this->assertSame('1290', AmountConverter::convert(12.90011));
        $this->assertSame('1290', AmountConverter::convert(12.90111));
        $this->assertSame('1290', AmountConverter::convert('12.90001'));
        $this->assertSame('1290', AmountConverter::convert('12.90011'));
        $this->assertSame('1290', AmountConverter::convert('12.90111'));

        // 12.99 dollars (12 U.S. dollars) + (99 U.S. cents)
        $this->assertSame('1299', AmountConverter::convert(12.99));
        $this->assertSame('1299', AmountConverter::convert('12.99'));
        $this->assertSame('1299', AmountConverter::convert(12.99001));
        $this->assertSame('1299', AmountConverter::convert(12.99011));
        $this->assertSame('1299', AmountConverter::convert(12.99111));
        $this->assertSame('1299', AmountConverter::convert('12.99001'));
        $this->assertSame('1299', AmountConverter::convert('12.99011'));
        $this->assertSame('1299', AmountConverter::convert('12.99111'));

        // 12.993 dollars (1 U.S. dollars) + (99 U.S. cents)
        $this->assertSame('1299', AmountConverter::convert(12.993));
        $this->assertSame('1299', AmountConverter::convert('12.993'));
        $this->assertSame('1299', AmountConverter::convert(12.99301));
        $this->assertSame('1299', AmountConverter::convert(12.99311));
        $this->assertSame('1299', AmountConverter::convert('12.99301'));
        $this->assertSame('1299', AmountConverter::convert('12.99311'));

        // 50 dollars (50 U.S. dollars) + (0 U.S. cents)
        $this->assertSame('5000', AmountConverter::convert(50));
        $this->assertSame('5000', AmountConverter::convert('50'));
        $this->assertSame('5000', AmountConverter::convert(50.0));
        $this->assertSame('5000', AmountConverter::convert(50.00));
        $this->assertSame('5000', AmountConverter::convert('50.00'));
        $this->assertSame('5000', AmountConverter::convert(50.00001));
        $this->assertSame('5000', AmountConverter::convert(50.00011));
        $this->assertSame('5000', AmountConverter::convert(50.00111));
        $this->assertSame('5000', AmountConverter::convert('50.00001'));
        $this->assertSame('5000', AmountConverter::convert('50.00011'));
        $this->assertSame('5000', AmountConverter::convert('50.00111'));

        // 100 dollars (100 U.S. dollars) + (0 U.S. cents)
        $this->assertSame('10000', AmountConverter::convert(100));
        $this->assertSame('10000', AmountConverter::convert('100'));
        $this->assertSame('10000', AmountConverter::convert(100.0));
        $this->assertSame('10000', AmountConverter::convert(100.00));
        $this->assertSame('10000', AmountConverter::convert('100.00'));
        $this->assertSame('10000', AmountConverter::convert(100.00001));
        $this->assertSame('10000', AmountConverter::convert(100.00011));
        $this->assertSame('10000', AmountConverter::convert(100.00111));
        $this->assertSame('10000', AmountConverter::convert('100.00001'));
        $this->assertSame('10000', AmountConverter::convert('100.00011'));
        $this->assertSame('10000', AmountConverter::convert('100.00111'));

        // 101 dollars (101 U.S. dollars) + (0 U.S. cents)
        $this->assertSame('10100', AmountConverter::convert(101));
        $this->assertSame('10100', AmountConverter::convert('101'));
        $this->assertSame('10100', AmountConverter::convert(101.0));
        $this->assertSame('10100', AmountConverter::convert(101.00));
        $this->assertSame('10100', AmountConverter::convert('101.00'));
        $this->assertSame('10100', AmountConverter::convert(101.00001));
        $this->assertSame('10100', AmountConverter::convert(101.00011));
        $this->assertSame('10100', AmountConverter::convert(101.00111));
        $this->assertSame('10100', AmountConverter::convert('101.00001'));
        $this->assertSame('10100', AmountConverter::convert('101.00011'));
        $this->assertSame('10100', AmountConverter::convert('101.00111'));

        // 1299.50 dollars (1299 U.S. dollars) + (50 U.S. cents)
        $this->assertSame('129950', AmountConverter::convert(1299.5));
        $this->assertSame('129950', AmountConverter::convert(1299.50));
        $this->assertSame('129950', AmountConverter::convert('1299.5'));
        $this->assertSame('129950', AmountConverter::convert('1299.50'));
        $this->assertSame('129950', AmountConverter::convert(1299.50001));
        $this->assertSame('129950', AmountConverter::convert(1299.500011));
        $this->assertSame('129950', AmountConverter::convert(1299.500111));
        $this->assertSame('129950', AmountConverter::convert(1299.501111));
        $this->assertSame('129950', AmountConverter::convert('1299.50001'));
        $this->assertSame('129950', AmountConverter::convert('1299.500011'));
        $this->assertSame('129950', AmountConverter::convert('1299.500111'));
        $this->assertSame('129950', AmountConverter::convert('1299.501111'));
    }
}
