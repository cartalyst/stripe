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
 * @version    2.2.1
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2019, Cartalyst LLC
 * @link       http://cartalyst.com
 */

namespace Cartalyst\Stripe\Tests\Api;

use Cartalyst\Stripe\Tests\FunctionalTestCase;

class FileLinksTest extends FunctionalTestCase
{
    /** @test */
    public function it_can_create_a_file_link()
    {
        $filePath = realpath(__DIR__.'/../files/verify-account.jpg');

        $upload = $this->stripe->files()->create($filePath, 'dispute_evidence');

        $fileLink = $this->stripe->fileLinks()->create($upload['id']);

        $this->assertSame($upload['id'], $fileLink['file']);
    }

    /** @test */
    public function it_can_retrieve_a_file_link()
    {
        $filePath = realpath(__DIR__.'/../files/verify-account.jpg');

        $upload = $this->stripe->files()->create($filePath, 'dispute_evidence');

        $fileLink = $this->stripe->fileLinks()->create($upload['id']);

        $fileLink = $this->stripe->fileLinks()->find($fileLink['id']);

        $this->assertSame($upload['id'], $fileLink['file']);
    }

    /** @test */
    public function it_can_update_a_file_link()
    {
        $filePath = realpath(__DIR__.'/../files/verify-account.jpg');

        $upload = $this->stripe->files()->create($filePath, 'dispute_evidence');

        $fileLink = $this->stripe->fileLinks()->create($upload['id']);

        $this->assertSame([], $fileLink['metadata']);

        $fileLink = $this->stripe->fileLinks()->update($fileLink['id'], [
            'metadata' => ['foo' => 'bar'],
        ]);

        $this->assertSame(['foo' => 'bar'], $fileLink['metadata']);
    }

    /** @test */
    public function it_can_retrieve_all_file_links()
    {
        $filePath = realpath(__DIR__.'/../files/verify-account.jpg');

        $upload = $this->stripe->files()->create($filePath, 'dispute_evidence');

        $fileLink = $this->stripe->fileLinks()->create($upload['id']);
        $fileLink = $this->stripe->fileLinks()->create($upload['id']);
        $fileLink = $this->stripe->fileLinks()->create($upload['id']);

        $fileLinks = $this->stripe->fileLinks()->all([
            'file' => $upload['id'],
        ]);

        $this->assertCount(3, $fileLinks['data']);
    }

    /** @test */
    public function it_can_iterate_all_file_links()
    {
        $filePath = realpath(__DIR__.'/../files/verify-account.jpg');

        $upload = $this->stripe->files()->create($filePath, 'dispute_evidence');

        for ($i=0; $i < 5; $i++) {
            $this->stripe->fileLinks()->create($upload['id']);
        }

        $fileLinks = $this->stripe->fileLinksIterator([
            'file' => $upload['id'],
        ]);

        $this->assertCount(5, $fileLinks);
    }
}
