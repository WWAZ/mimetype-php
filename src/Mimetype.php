<?php

namespace wwaz\Mimetype;

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
    public static function get(string $filename)
    {
        $pi = pathinfo($filename);

        if( !isset($pi['extension']) ){
            // File has no extension
            if( file_exists($filename) ){
                // File is locally existing.
                // Try getting mime by content type
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
     */
    public static function fromPath(string $filename)
    {
        $pi = pathinfo($filename);

        if( !isset($pi['extension']) ){
            throw new MimetypeException('Unable to determine mime-type from filename – file extension is missing');
        }

        $key = strtolower($pi['extension']);
        
        if (isset(self::all()[$key])) {
            return self::all()[$key];
        }

        return false;
    }

    /**
     * Returns mimetype from content type.
     *
     * @param string $filename
     * @return string]bool
     */
    public static function fromContentType(string $filename)
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

    /**
     * Returns all registered mimetypes.
     *
     * @return array
     */
    public static function all()
    {
        return [
            'txt' => 'text/plain',
            'htm' => 'text/html',
            'html' => 'text/html',
            'php' => 'text/html',
            'css' => 'text/css',
            'js' => 'application/javascript',
            'json' => 'application/json',
            'xml' => 'application/xml',
            'swf' => 'application/x-shockwave-flash',
            'flv' => 'video/x-flv',

            'png' => 'image/png',
            'jpe' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'jpg' => 'image/jpeg',
            'gif' => 'image/gif',
            'bmp' => 'image/bmp',
            'ico' => 'image/vnd.microsoft.icon',
            'tiff' => 'image/tiff',
            'tif' => 'image/tiff',
            'svg' => 'image/svg+xml',
            'svgz' => 'image/svg+xml',

            'zip' => 'application/zip',
            'rar' => 'application/x-rar-compressed',
            'exe' => 'application/x-msdownload',
            'msi' => 'application/x-msdownload',
            'cab' => 'application/vnd.ms-cab-compressed',

            'mp3' => 'audio/mpeg',
            'qt' => 'video/quicktime',
            'mov' => 'video/quicktime',

            'pdf' => 'application/pdf',
            'psd' => 'image/vnd.adobe.photoshop',
            'ai' => 'application/postscript',
            'eps' => 'application/postscript',
            'ps' => 'application/postscript',

            'doc' => 'application/msword',
            'rtf' => 'application/rtf',
            'xls' => 'application/vnd.ms-excel',
            'ppt' => 'application/vnd.ms-powerpoint',
            'docx' => 'application/msword',
            'xlsx' => 'application/vnd.ms-excel',
            'pptx' => 'application/vnd.ms-powerpoint',

            'odt' => 'application/vnd.oasis.opendocument.text',
            'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
        ];
    }
}
