<?php

namespace wwaz\Mimetype;

use Mimey\MimeTypes;
use wwaz\Mimetype\Exceptions\MimetypeException;

class Mimetype
{
    private static ?MimeTypes $mimeDb = null;

    private static function mimeDb(): MimeTypes
    {
        return self::$mimeDb ??= new MimeTypes();
    }

    public static function get(string $filename): string|false
    {
        $extension = self::normalizeExtension(self::extension($filename));

        if ($extension !== '') {
            $mime = self::mimeDb()->getMimeType($extension);
            if ($mime !== null && $mime !== '') {
                return $mime;
            }
        }

        return self::fromContentType($filename);
    }

    /**
     * @throws MimetypeException
     */
    public static function fromPath(string $filename): string|false
    {
        $extension = self::normalizeExtension(self::extension($filename));

        if ($extension === '') {
            throw new MimetypeException('No file extension present in filename.');
        }

        $mime = self::mimeDb()->getMimeType($extension);

        return $mime ?? false;
    }

    public static function fromContentType(string $filename): string|false
    {
        if (!is_file($filename) || !is_readable($filename)) {
            return false;
        }

        $mime = @mime_content_type($filename);

        return $mime !== false && $mime !== '' ? $mime : false;
    }

    private static function extension(string $filename): string
    {
        return pathinfo($filename, PATHINFO_EXTENSION);
    }

    private static function normalizeExtension(string $extension): string
    {
        return strtolower(trim($extension));
    }
}
