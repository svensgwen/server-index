<?php
/* Directory to scan: parent folder */
$baseDir = realpath(dirname(__DIR__)); // one level up
if (!$baseDir || !is_dir($baseDir)) {
    die("Directory not found or inaccessible.");
}

/* Hidden Folders (case-insensitive) */
$hiddenFolders = ['assets', 'pandora', 'starter-kit'];

$folders = []; // initialize array

/* Scan for folders */
foreach (scandir($baseDir) as $item) {
    // Skip current, parent, or hidden folders starting with .
    if ($item === '.' || $item === '..' || str_starts_with($item, '.')) {
        continue;
    }

    $fullPath = $baseDir . DIRECTORY_SEPARATOR . $item;

    // Check if it's a directory AND not in hidden list (case-insensitive)
    if (is_dir($fullPath) && !in_array(strtolower($item), array_map('strtolower', $hiddenFolders))) {
        $folders[] = $item;
    }
}

/* Output for testing */
// print_r($folders);
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
<meta charset="UTF-8">
<title>Directory Index</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="./assets/plugins/bootstrap-5.3.8/css/bootstrap.min.css">
<link rel="stylesheet" href="./assets/css/style.css">
<style>

</style>

</head>
<body>

<div class="container py-5">

    <h4 class="title mb-3">Svens Server Index</h4>
    <img src="./assets/img/gif/folder-run.gif" alt="Folder run" height="60">
    <!-- Search -->
    <input type="text" id="search" class="form-control mb-4" placeholder="Search folders..." autofocus>

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

<script>
$(document).ready(function(){
    $("#search").on("keyup", function(){
        let value = $(this).val().toLowerCase();
        $(".folder-item").filter(function(){
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });
});
</script>

</body>
</html>