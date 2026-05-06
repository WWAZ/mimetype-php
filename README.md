# wwaz/Mimetype

Zero-config MIME type detection for PHP – automatically via file extension or content type.

[![PHP](https://img.shields.io/badge/PHP-%3E%3D8.0-blue)](https://php.net)

---

## Quick Start

```bash
composer require wwaz/mimetype
```

```php
use wwaz\Mimetype\Mimetype;

echo Mimetype::get('document.pdf');  // → application/pdf
```

`get()` first tries detection by file extension. If that fails (missing extension or unknown type), it automatically falls back to content-type analysis – no configuration needed.

---

## API

### `Mimetype::get(string $filename): string|false`

Universal method – the right choice for most cases.

```php
Mimetype::get('image.png');           // → image/png
Mimetype::get('/var/upload/avatar');  // → image/jpeg  (via content type)
Mimetype::get('archive.tar.gz');      // → application/gzip
```

### `Mimetype::fromPath(string $filename): string|false`

Detection **by file extension only**. Throws `MimetypeException` if the extension is missing.

### `Mimetype::fromContentType(string $filename): string|false`

Detection **by PHP `mime_content_type()` only**. The file must exist on the filesystem.

---

## Examples

### 1 – Validate a file upload

```php
$mime = Mimetype::get($_FILES['upload']['tmp_name']);

$allowed = ['image/jpeg', 'image/png', 'image/webp'];

if (!in_array($mime, $allowed)) {
    throw new RuntimeException('Only JPEG, PNG and WebP are allowed.');
}
```

### 2 – Set the Content-Type header

```php
$file = '/var/www/assets/logo.svg';
header('Content-Type: ' . Mimetype::get($file));
readfile($file);
```

### 3 – Handle a missing extension gracefully

```php
use wwaz\Mimetype\Exceptions\MimetypeException;

try {
    $mime = Mimetype::fromPath('mysterious-file');
} catch (MimetypeException $e) {
    // Fall back to content-type detection
    $mime = Mimetype::fromContentType('/path/to/mysterious-file');
}
```

---

## Dependencies

| Package | Purpose |
|---|---|
| [ralouphie/mimey](https://github.com/ralouphie/mimey) | Extensible MIME type database |
| PHP ≥ 8.0 | `string|bool` union types |

---

MIT © wwaz