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

namespace Cartalyst\Stripe\HttpClient\Util;

use finfo;
use RuntimeException;
use Psr\Http\Message\StreamFactoryInterface;
use Http\Message\MultipartStream\MultipartStreamBuilder;

/**
 * @internal
 */
final class Multipart
{
    /**
     * The octet stream content type identifier.
     *
     * @var string
     */
    const STREAM_CONTENT_TYPE = 'application/octet-stream';

    /**
     * The multipart form data content type identifier.
     *
     * @var string
     */
    const MULTIPART_CONTENT_TYPE = 'multipart/form-data';

    /**
     * Prepare the request URI.
     *
     * @param \Psr\Http\Message\StreamFactoryInterface $streamFactory
     * @param array                                    $params
     * @param array                                    $files
     *
     * @return MultipartStreamBuilder
     */
    public static function createMultipartStreamBuilder(StreamFactoryInterface $streamFactory, array $params, array $files = []): MultipartStreamBuilder
    {
        $builder = new MultipartStreamBuilder($streamFactory);

        foreach ($params as $name => $value) {
            $builder->addResource($name, $value);
        }

        foreach ($files as $name => $file) {
            $builder->addResource($name, self::tryFopen($file, 'r'), [
                'headers' => [
                    'Content-Type' => self::guessFileContentType($file),
                ],
                'filename' => basename($file),
            ]);
        }

        return $builder;
    }

    /**
     * Safely opens a PHP stream resource using a filename.
     *
     * @param string $filename
     * @param string $mode
     *
     * @throws \RuntimeException
     *
     * @return resource
     *
     * @see https://github.com/guzzle/psr7/blob/1.6.1/src/functions.php#L287-L320
     */
    private static function tryFopen(string $filename, string $mode)
    {
        $ex = null;
        set_error_handler(function () use ($filename, $mode, &$ex) {
            $ex = new RuntimeException(sprintf(
                'Unable to open %s using mode %s: %s',
                $filename,
                $mode,
                func_get_args()[1]
            ));
        });

        $handle = fopen($filename, $mode);
        restore_error_handler();

        if (null !== $ex) {
            throw $ex;
        }

        return $handle;
    }

    /**
     * Guess the content type of the file if possible.
     *
     * @param string $file
     *
     * @return string
     */
    private static function guessFileContentType(string $file): string
    {
        if (! class_exists(finfo::class, false)) {
            return self::STREAM_CONTENT_TYPE;
        }

        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $type  = $finfo->file($file);

        return $type !== false ? $type : self::STREAM_CONTENT_TYPE;
    }
}
