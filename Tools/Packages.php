<?php ob_start(); ?>
# Dependencies

<?php
$composer = json_decode(file_get_contents(__DIR__ . '/../composer.json'));

foreach ($composer->require as $name => $version) { ?>
* [<?= $name ?>: <?= $version ?>](<?= str_starts_with($name, 'php') ? 'https://www.php.net/downloads.php' : "https://packagist.org/packages/{$name}" ?>)
<?php } ?>

# Dev Dependencies

<?php foreach ($composer->{'require-dev'} as $name => $version) { ?>
* [<?= $name ?>: <?= $version ?>](<?= str_starts_with($name, 'php') ? 'https://www.php.net/downloads.php' : "https://packagist.org/packages/{$name}" ?>)
<?php
}

file_put_contents(__DIR__ . '/packages.md', ob_get_clean());
?>
