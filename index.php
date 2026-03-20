<?php
require_once __DIR__ . '/funcs/folderman.php';
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <title>Foxie Server</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="./assets/plugins/fontawesome/fontawesome.css">
    <link rel="stylesheet" href="./assets/plugins/bootstrap-5.3.8/css/bootstrap.min.css">
    <link rel="icon" href="./assets/img/svg/cute-fox.svg" type="image/svg+xml">
    <link rel="shortcut icon" href="./assets/img/svg/cute-fox.svg" type="image/x-icon">

    <link rel="stylesheet" href="./assets/css/style.css">

    <style>
        .folder-item {
            margin-bottom: 0;
        }

        .folder-row {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px;
            border-radius: 10px;
            border: 1px solid var(--bs-border-color);
            background-color: rgba(0, 0, 0, 0.6);
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.08);
            height: 100%;
        }

        .folder-main {
            flex: 1;
            min-width: 0;
            padding: 10px 14px;
            border-radius: 8px;
            background-color: var(--bs-dark);
            border: 1px solid transparent;
            color: var(--bs-body-color);
            display: flex;
            align-items: center;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            transition:
                background-color 0.25s ease,
                border-color 0.25s ease,
                transform 0.2s ease,
                box-shadow 0.25s ease;
        }

        .folder-main:hover {
            background-color: color-mix(in srgb, var(--bs-primary) 8%, var(--bs-dark));
            border-color: color-mix(in srgb, var(--bs-primary) 35%, var(--bs-border-color));
            color: var(--bs-body-color);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .folder-main:active {
            transform: scale(0.98);
        }

        .folder-main:focus-visible {
            outline: 2px solid var(--bs-primary);
            outline-offset: 2px;
        }

        .favorite-row .folder-main {
            border-color: var(--bs-warning);
            font-weight: 700;
        }

        .folder-actions {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-shrink: 0;
        }

        .folder-actions .btn {
            width: 38px;
            height: 38px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .hidden-folder-card {
            border: 1px solid var(--bs-border-color);
            border-radius: 10px;
            padding: 12px;
            background-color: rgba(0, 0, 0, 0.45);
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.08);
            height: 100%;
        }

        .hidden-folder-name {
            font-weight: 600;
            margin-bottom: 12px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>
</head>

<body>

    <div class="container pb-5">
        <div class="header">
            <div class="header-content shadow-sm">
                <img src="./assets/img/svg/firefox-heart.svg" class="img-fluid" alt="Foxie Server">
                <h4 class="title mb-3">Foxie Server</h4>
            </div>
        </div>

        <div class="mx-auto" style="max-width: 720px;">
            <input
                type="text"
                id="search"
                class="form-control form-control-lg mb-4 shadow-sm"
                placeholder="Search folders..."
                autofocus
                autocomplete="off">
        </div>

        <?php if (!empty($favorites)): ?>
            <div class="mb-4">
                <h5 class="mb-3">⭐ Favorites</h5>
                <div class="row g-3" id="favoritesList">
                    <?php foreach ($favorites as $folder): ?>
                        <div
                            class="col-12 col-sm-6 col-md-4 col-lg-3 folder-item"
                            data-name="<?= strtolower(htmlspecialchars($folder)) ?>">

                            <div class="folder-row favorite-row">
                                <a
                                    href="../<?= htmlspecialchars($folder) ?>"
                                    class="folder-main text-decoration-none"
                                    title="<?= htmlspecialchars($folder) ?>">
                                    📁 <?= htmlspecialchars($folder) ?>
                                </a>

                                <div class="folder-actions">
                                    <button
                                        type="button"
                                        class="btn btn-sm btn-danger pin-btn"
                                        data-folder="<?= htmlspecialchars($folder) ?>"
                                        data-action="unpin"
                                        title="Unpin folder"
                                        aria-label="Unpin <?= htmlspecialchars($folder) ?>">
                                        <i class="fa fa-thumbtack"></i>
                                    </button>

                                    <button
                                        type="button"
                                        class="btn btn-sm btn-secondary hide-btn"
                                        data-folder="<?= htmlspecialchars($folder) ?>"
                                        title="Hide folder"
                                        aria-label="Hide <?= htmlspecialchars($folder) ?>">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                </div>
                            </div>

                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <div class="mb-4">
            <h5 class="mb-3">📂 All Folders</h5>

            <div class="row g-3" id="folderList">
                <?php if (empty($folders)): ?>
                    <div class="col-12 text-light-emphasis">No folders found</div>
                <?php else: ?>
                    <?php foreach ($folders as $folder): ?>
                        <div
                            class="col-12 col-sm-6 col-md-4 col-lg-3 folder-item"
                            data-name="<?= strtolower(htmlspecialchars($folder)) ?>">

                            <div class="folder-row">
                                <a
                                    href="../<?= htmlspecialchars($folder) ?>"
                                    class="folder-main text-decoration-none"
                                    title="<?= htmlspecialchars($folder) ?>">
                                    📁 <?= htmlspecialchars($folder) ?>
                                </a>

                                <div class="folder-actions">
                                    <button
                                        type="button"
                                        class="btn btn-sm btn-warning pin-btn"
                                        data-folder="<?= htmlspecialchars($folder) ?>"
                                        data-action="pin"
                                        title="Pin folder"
                                        aria-label="Pin <?= htmlspecialchars($folder) ?>">
                                        <i class="fa fa-thumbtack"></i>
                                    </button>

                                    <button
                                        type="button"
                                        class="btn btn-sm btn-secondary hide-btn"
                                        data-folder="<?= htmlspecialchars($folder) ?>"
                                        title="Hide folder"
                                        aria-label="Hide <?= htmlspecialchars($folder) ?>">
                                        <i class="fa fa-eye-slash"></i>
                                    </button>
                                </div>
                            </div>

                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <?php if (!empty($hiddenFoldersList ?? [])): ?>
            <div class="mt-5">
                <h5 class="mb-3">🙈 Hidden Folders</h5>

                <div class="row g-3" id="hiddenList">
                    <?php foreach (($hiddenFoldersList ?? []) as $folder): ?>
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3 folder-item"
                            data-name="<?= strtolower(htmlspecialchars($folder)) ?>">

                            <div class="folder-row">

                                <!-- Left side (not a link, just text) -->
                                <div class="folder-main" title="Unhide <?= htmlspecialchars($folder) ?>">
                                    📁 <?= htmlspecialchars($folder) ?>
                                </div>

                                <!-- Right side actions -->
                                <div class="folder-actions">
                                    <button
                                        type="button"
                                        class="btn btn-sm btn-primary unhide-btn"
                                        data-folder="<?= htmlspecialchars($folder) ?>"
                                        title="Unhide folder"
                                        aria-label="Unhide <?= htmlspecialchars($folder) ?>">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                </div>

                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

    </div>

    <script src="./assets/plugins/bootstrap-5.3.8/js/bootstrap.bundle.min.js"></script>
    <script src="./assets/plugins/jquery-3.7.1.min.js"></script>
    <script src="./assets/js/script.js"></script>

</body>

</html>