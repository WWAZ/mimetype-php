# mimetype-php

MIME-Typ für einen Dateipfad oder Dateinamen ermitteln — zuerst über die Endung ([Mimey](https://packagist.org/packages/ralouphie/mimey)), bei Bedarf über den Dateiinhalt (`mime_content_type`). **PHP 8.2+**, MIT.

## Schnellstart

```bash
composer require wwaz/mimetype-php
```

```php
<?php

use wwaz\Mimetype\Mimetype;

$mime = Mimetype::get(__DIR__ . '/uploads/dokument.pdf'); // z. B. "application/pdf"
```

`get()` ist die Methode für den Alltag: Sie nutzt die Endung und fällt bei fehlendem Mapping (oder fehlender Endung) auf die Inhalts-Erkennung zurück, **wenn die Datei existiert**.

---

## Beispiele

### 1. Lokale Datei (typischer Upload)

```php
use wwaz\Mimetype\Mimetype;

$path = $request->file('upload')->getRealPath();
$mime = Mimetype::get($path);

if ($mime === false) {
    // weder Mapping noch Inhalt erkannt
} elseif (! in_array($mime, ['image/jpeg', 'image/png'], true)) {
    // Validierung ...
}
```

### 2. Nur Dateiname — ohne dass die Datei liegen muss

Wenn du nur einen String wie `export.csv` hast und den MIME-Typ für Header oder Validierung brauchst:

```php
$mime = Mimetype::get('Bericht_Q4.csv'); // "text/csv"
```

Funktioniert über die Endung; es wird **kein** `file_exists` für die Inhalts-Erkennung gebraucht.

### 3. Nur Endung vs. nur Inhalt

```php
use wwaz\Mimetype\Mimetype;
use wwaz\Mimetype\Exceptions\MimetypeException;

// Strikt nach Endung (wirft, wenn pathinfo keine Endung hat)
try {
    $mime = Mimetype::fromPath('/var/data/backup.tar.gz');
} catch (MimetypeException $e) {
    // z. B. Pfad ohne Extension
}

// Immer Inhalt — Datei muss existieren und lesbar sein
$mime = Mimetype::fromContentType('/var/data/datei_ohne_endung');
```

---

## Kurzüberblick

| Methode | Wofür |
|--------|--------|
| `get($path)` | Standard: Endung, sonst Inhalt (falls Datei da ist) |
| `fromPath($path)` | Nur Endung; ohne Extension → `MimetypeException` möglich |
| `fromContentType($path)` | Nur `mime_content_type()`; sonst `false` |

`fromResource()` ist veraltet — bitte `fromContentType()` nutzen.

**Entwicklung:** `composer install` und `composer test`.

## Lizenz

MIT
