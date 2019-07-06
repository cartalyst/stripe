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
 * @version    2.2.7
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2019, Cartalyst LLC
 * @link       http://cartalyst.com
 */

namespace Cartalyst\Stripe\Tests\Api;

use Cartalyst\Stripe\Tests\FunctionalTestCase;

class FilesTest extends FunctionalTestCase
{
    /** @test */
    public function it_can_upload_a_file()
    {
        $filePath = realpath(__DIR__.'/../files/verify-account.jpg');

        $upload = $this->stripe->files()->create($filePath, 'identity_document');

        $this->assertSame('jpg', $upload['type']);
    }

    /** @test */
    public function it_can_retrieve_an_uploaded_file()
    {
        $filePath = realpath(__DIR__.'/../files/verify-account.jpg');

        $uploadedFileId = $this->stripe->files()->create($filePath, 'identity_document')['id'];

        $upload = $this->stripe->files()->find($uploadedFileId);

        $this->assertSame('jpg', $upload['type']);
    }

    /** @test */
    public function it_can_retrieve_all_uploaded_files()
    {
        $filePath = realpath(__DIR__.'/../files/verify-account.jpg');

        $this->stripe->files()->create($filePath, 'identity_document');
        $this->stripe->files()->create($filePath, 'identity_document');
        $this->stripe->files()->create($filePath, 'identity_document');

        $uploadedFiles = $this->stripe->files()->all();

        $this->assertNotEmpty($uploadedFiles['data']);
        $this->assertInternalType('array', $uploadedFiles['data']);
    }

    /** @test */
    public function it_can_iterate_all_uploaded_files()
    {
        $filePath = realpath(__DIR__.'/../files/verify-account.jpg');

        for ($i=0; $i < 5; $i++) {
            $this->stripe->files()->create($filePath, 'identity_document');
        }

        $files = $this->stripe->filesIterator();

        $this->assertNotEmpty($files);
    }
}
