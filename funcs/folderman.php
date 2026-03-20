<?php

$baseDir = realpath(__DIR__ . '/../../'); // /var/www/html
if (!$baseDir || !is_dir($baseDir)) {
    die("Directory not found or inaccessible.");
}

$dataFile = __DIR__ . '/../data/folders.json';

$folderState = [
    'favorites' => [],
    'hidden' => ['server-index']
];

if (file_exists($dataFile)) {
    $json = json_decode(file_get_contents($dataFile), true);
    if (is_array($json)) {
        $folderState['favorites'] = $json['favorites'] ?? [];
        $folderState['hidden'] = $json['hidden'] ?? ['server-index'];
    }
}

$favoritesLower = array_map('strtolower', $folderState['favorites']);
$hiddenLower = array_map('strtolower', $folderState['hidden']);

$folders = [];
$favorites = [];
$hiddenFoldersList = [];

foreach (scandir($baseDir) as $item) {
    if ($item === '.' || $item === '..' || str_starts_with($item, '.')) {
        continue;
    }

    $fullPath = $baseDir . DIRECTORY_SEPARATOR . $item;

    if (!is_dir($fullPath)) {
        continue;
    }

    $itemLower = strtolower($item);

    if (in_array($itemLower, $hiddenLower, true)) {
        $hiddenFoldersList[] = $item;
        continue;
    }

    if (in_array($itemLower, $favoritesLower, true)) {
        $favorites[] = $item;
    } else {
        $folders[] = $item;
    }
}

sort($favorites, SORT_NATURAL | SORT_FLAG_CASE);
sort($folders, SORT_NATURAL | SORT_FLAG_CASE);
sort($hiddenFoldersList, SORT_NATURAL | SORT_FLAG_CASE);