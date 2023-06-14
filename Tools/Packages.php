<?php

$composer = json_decode(file_get_contents(__DIR__ . '/../composer.json'), true);

$formatPackages = function (array $packages): string {
    if (empty($packages)) {
        return "* No dependencies.\n";
    }
    $formattedPackages = [];

    foreach ($packages as $name => $version) {
        if ($name === 'php') {
            $downloadUri = 'https://www.php.net/downloads.php';
        } elseif (str_starts_with($name, 'ext-')) {
            $name = str_replace('ext-', '', $name);
            $downloadUri = "https://www.php.net/{$name}.setup";
        } else {
            $downloadUri = "https://packagist.org/packages/{$name}";
        }

        $formattedPackages[] = "* [{$name}: {$version}]({$downloadUri})";
    }

    return implode("\n", $formattedPackages) . "\n";
};

$context = [
    '# Dependencies',
    $formatPackages($composer['require'] ?? []),
    '# Dev Dependencies',
    $formatPackages($composer['require-dev'] ?? []),
];

file_put_contents(__DIR__ . '/packages.md', implode("\n", $context));
