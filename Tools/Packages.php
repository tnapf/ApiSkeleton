<?php ob_start(); ?>
    # Packages

<?php

function decode_file(string $path): stdClass
{
    return json_decode(file_get_contents($path));
}

$composer = decode_file(__DIR__ . '/../composer.json');

?>
<?php foreach ($composer->require as $name => $version) { ?>
    * [<?= $name ?>: <?= $version ?>](<?= str_starts_with($name, 'php') ? 'https://www.php.net/downloads.php' : "https://packagist.org/packages/{$name}" ?>)
<?php } ?>
<?php file_put_contents(__DIR__ . '/packages.md', ob_get_clean()); ?>