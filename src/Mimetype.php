<?php

namespace wwaz\Mimetype;

use Mimey\MimeTypes as MimeyTypes;
use wwaz\Mimetype\Exceptions\MimetypeException;

class Mimetype
{
    /**
     * Returns mimetype.
     * 
     * First approach: by extension
     * Second approach: by content type
     * 
     * @param string $filename
     * @return string|bool
     */
    public static function get(string $filename): string|bool
    {
        $pi = pathinfo($filename);

        if( !isset($pi['extension']) ){
            if( file_exists($filename) ){
                return self::fromResource($filename);
            }
        }

        $mime = self::fromPath($filename);

        if( !$mime ){
            // Detecting mime by extension failed.
            // Retry by detecting from content type.
            return self::fromResource($filename); 
        }

        return $mime;
    }
    
    /**
     * Returns mimetype from path.
     *
     * @param string $filename
     * @return string]bool
     * @throws MimetypeException
     */
    public static function fromPath(string $filename): string|bool
    {
        $pi = pathinfo($filename);

        if( !isset($pi['extension']) ){
            throw new MimetypeException('Unable to determine mime-type from filename – file extension is missing');
        }

        $key = strtolower($pi['extension']);

        return (new MimeyTypes())->getMimeType($key);
    }

    /**
     * Returns mimetype from content type.
     *
     * @param string $filename
     * @return string|bool
     */
    public static function fromContentType(string $filename): string|bool
    {
        if (file_exists($filename)) {
            return mime_content_type($filename);
        }
        return false;
    }

    /**
     * Returns mimetype from file resource.
     *
     * @deprecated
     */
    public static function fromResource(string $filepath)
    {
        return self::fromContentType($filepath);
    }
}
