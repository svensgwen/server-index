<?php
/* Directory to scan: parent folder */
$baseDir = realpath(dirname(__DIR__)); // one level up
if (!$baseDir || !is_dir($baseDir)) {
    die("Directory not found or inaccessible.");
}

/* Hidden Folders (case-insensitive) */
$hiddenFolders = ['assets', 'pandora', 'starterkit'];

/* Important Folders (case-insensitive) */
$favoriteFolders = ['todoem', 'cozy-bear'];

$folders = [];
$favories = [];

/* Scan for folders */
foreach (scandir($baseDir) as $item) {

    if ($item === '.' || $item === '..' || str_starts_with($item, '.')) {
        continue;
    }

    $fullPath = $baseDir . DIRECTORY_SEPARATOR . $item;

    if (is_dir($fullPath) && !in_array(strtolower($item), array_map('strtolower', $hiddenFolders))) {

        if (in_array(strtolower($item), array_map('strtolower', $favoriteFolders))) {
            $favories[] = $item;
        } else {
            $folders[] = $item;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <title>Svens Server</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="./assets/plugins/bootstrap-5.3.8/css/bootstrap.min.css">
    <link rel="shortcut icon" href="./assets/img/svg/robot.svg" type="image/x-icon">

    <link rel="stylesheet" href="./assets/css/style.css">
    <style>

    </style>

</head>

<body>

    <div class="container pb-5">
        <div class="header">
            <div class="header-content">
                <h4 class="title mb-3">Svens Server</h4>
                <img src="./assets/img/sven2.png" class="img-fluid">
            </div>

        </div>

        <!-- Search -->
        <input type="text" id="search" class="form-control mb-4" placeholder="Search folders..." autofocus autocomplete="off">
        <?php if (!empty($favories)): ?>

            <h5 class="mb-3">⭐ Favorites</h5>

            <div class="row g-2 mb-4">

                <?php foreach ($favories as $folder): ?>
                    <div class="col-6 col-md-4 col-lg-3 folder-item">
                        <a href="../<?= htmlspecialchars($folder) ?>"
                            class="d-block border border-warning rounded px-3 py-2 text-decoration-none fw-bold">
                            <?= htmlspecialchars($folder) ?>
                        </a>
                    </div>
                <?php endforeach; ?>

            </div>

        <?php endif; ?>
        <!-- Folder Grid -->
        <div class="row g-2" id="folderList">

            <?php if (empty($folders)): ?>
                <div class="col-12 text-muted">No folders found</div>
            <?php else: ?>
                <?php foreach ($folders as $folder): ?>
                    <div class="col-6 col-md-4 col-lg-3 folder-item">
                        <a href="../<?= htmlspecialchars($folder) ?>"
                            class="d-block border rounded px-3 py-2 text-decoration-none">
                            📁 <?= htmlspecialchars($folder) ?>
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>

        </div>

    </div>

    <script src="./assets/plugins/bootstrap-5.3.8/js/bootstrap.bundle.min.js"></script>
    <script src="./assets/plugins/jquery-3.7.1.min.js"></script>
    <script src="./assets/js/script.js"></script>

</body>

</html>