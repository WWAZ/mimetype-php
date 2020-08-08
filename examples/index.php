<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once dirname(__DIR__, 1) . '/vendor/autoload.php';

$mime = wwaz\Mimetype\Mimetype::fromPath('path/to/file.txt');
echo 'path/to/file.txt -> ' . $mime."<br>\n";

$mime = wwaz\Mimetype\Mimetype::fromPath('files/hello.pdf');
echo 'path/to/file.txt -> ' . $mime."<br>\n";
