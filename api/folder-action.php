<?php

header('Content-Type: application/json');

$dataFile = __DIR__ . '/../data/folders.json';
$dataDir  = dirname($dataFile);

$defaultData = [
    'favorites' => [],
    'hidden' => ['server-index']
];

/*
|--------------------------------------------------------------------------
| Ensure data directory exists
|--------------------------------------------------------------------------
*/
if (!is_dir($dataDir)) {
    if (!mkdir($dataDir, 0775, true)) {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => 'Failed to create data directory.',
            'path' => $dataDir
        ]);
        exit;
    }
}

/*
|--------------------------------------------------------------------------
| Ensure JSON file exists
|--------------------------------------------------------------------------
*/
if (!file_exists($dataFile)) {
    $created = file_put_contents($dataFile, json_encode($defaultData, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

    if ($created === false) {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => 'Failed to create JSON file.',
            'path' => $dataFile
        ]);
        exit;
    }
}

/*
|--------------------------------------------------------------------------
| Check readability / writability
|--------------------------------------------------------------------------
*/
if (!is_readable($dataFile)) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'JSON file is not readable.',
        'path' => $dataFile
    ]);
    exit;
}

if (!is_writable($dataFile)) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'JSON file is not writable.',
        'path' => $dataFile
    ]);
    exit;
}

/*
|--------------------------------------------------------------------------
| Read current data
|--------------------------------------------------------------------------
*/
$json = file_get_contents($dataFile);
$data = json_decode($json, true);

if (!is_array($data)) {
    $data = $defaultData;
}

/*
|--------------------------------------------------------------------------
| Validate input
|--------------------------------------------------------------------------
*/
$folder = trim($_POST['folder'] ?? '');
$action = trim($_POST['action'] ?? '');

if ($folder === '' || $action === '') {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Folder or action missing.'
    ]);
    exit;
}

/*
|--------------------------------------------------------------------------
| Normalize keys
|--------------------------------------------------------------------------
*/
$data['favorites'] = isset($data['favorites']) && is_array($data['favorites']) ? $data['favorites'] : [];
$data['hidden']    = isset($data['hidden']) && is_array($data['hidden']) ? $data['hidden'] : ['server-index'];

/*
|--------------------------------------------------------------------------
| Handle actions
|--------------------------------------------------------------------------
*/
switch ($action) {
    case 'pin':
        if (!in_array($folder, $data['favorites'], true)) {
            $data['favorites'][] = $folder;
        }
        $data['hidden'] = array_values(array_diff($data['hidden'], [$folder]));
        break;

    case 'unpin':
        $data['favorites'] = array_values(array_diff($data['favorites'], [$folder]));
        break;

    case 'hide':
        if (!in_array($folder, $data['hidden'], true)) {
            $data['hidden'][] = $folder;
        }
        $data['favorites'] = array_values(array_diff($data['favorites'], [$folder]));
        break;

    case 'unhide':
        $data['hidden'] = array_values(array_diff($data['hidden'], [$folder]));
        break;

    default:
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => 'Invalid action.'
        ]);
        exit;
}

/*
|--------------------------------------------------------------------------
| Remove duplicates
|--------------------------------------------------------------------------
*/
$data['favorites'] = array_values(array_unique($data['favorites']));
$data['hidden']    = array_values(array_unique($data['hidden']));

/*
|--------------------------------------------------------------------------
| Save data
|--------------------------------------------------------------------------
*/
$written = file_put_contents(
    $dataFile,
    json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES),
    LOCK_EX
);

if ($written === false) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Failed to write JSON file.',
        'path' => $dataFile,
        'dir_writable' => is_writable($dataDir),
        'file_writable' => is_writable($dataFile)
    ]);
    exit;
}

/*
|--------------------------------------------------------------------------
| Success response
|--------------------------------------------------------------------------
*/
echo json_encode([
    'success' => true,
    'message' => 'Updated successfully.',
    'data' => $data
]);
exit;