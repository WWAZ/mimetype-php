<?php

namespace Test;

use PHPUnit\Framework\TestCase;

use wwaz\Mimetype\Mimetype;
use wwaz\Mimetype\Exceptions\MimetypeException;

class MimetypeTest extends TestCase
{

    public function test_getting_mimetype_from_txt_file_should_work()
    {
        $filename = dirname( __FILE__ ) . '/assets/file.txt';
        $mime = Mimetype::get($filename);
        $this->assertEquals($mime, 'text/plain');
    }

    public function test_getting_mimetype_from_pdf_file_should_work()
    {
        $filename = dirname( __FILE__ ) . '/assets/file.pdf';
        $mime = Mimetype::get($filename);
        $this->assertEquals($mime, 'application/pdf');
    }

    public function test_getting_mimetype_from_text_file_without_extension_should_work()
    {
        $filename = dirname( __FILE__ ) . '/assets/txt';
        $mime = Mimetype::get($filename);
        $this->assertEquals($mime, 'text/plain');
    }

    public function test_getting_mimetype_from_pdf_file_without_extension_should_work()
    {
        $filename = dirname( __FILE__ ) . '/assets/pdf';
        $mime = Mimetype::get($filename);
        $this->assertEquals($mime, 'application/pdf');
    }

    public function test_getting_mimetype_from_path_should_work()
    {
        $filename = dirname( __FILE__ ) . '/assets/file.txt';
        $mime = Mimetype::fromPath($filename);
        $this->assertEquals($mime, 'text/plain');
    }

    public function test_getting_mimetype_from_path_without_extension_should_throw_error()
    {
        $this->expectException(MimetypeException::class);
        
        $filename = dirname( __FILE__ ) . '/assets/txt';
        $mime = Mimetype::fromPath($filename);
        $this->assertEquals($mime, 'text/plain');
    }

    public function test_getting_mimetype_from_source_should_work()
    {
        $filename = dirname( __FILE__ ) . '/assets/file.txt';
        $mime = Mimetype::fromContentType($filename);
        $this->assertEquals($mime, 'text/plain');
    }

    public function test_getting_mimetype_csv_from_filename()
    {
        $filename = 'file.csv';
        $mime = Mimetype::get($filename);
        $this->assertEquals($mime, 'text/csv');
    }

    public function test_getting_mimetype_dmg_from_filename()
    {
        $filename = 'file.dmg';
        $mime = Mimetype::get($filename);
        print_r($mime);
        $this->assertEquals($mime, 'application/x-apple-diskimage');
    }
}