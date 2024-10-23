<?php
if (isset($_POST['logout'])) {
    session_unset();
    redirectToCurrentPage();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="<?= BASEURL ?>/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= BASEURL ?>/style.css">
    <link rel="stylesheet" href="<?= BASEURL ?>/assets/css/form.css">
    <link rel="shortcut icon" href="<?= BASEURL ?>/favicon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.min.css" rel="stylesheet">
</head>

<body>
    <div class="bg-secondary w-full py-2">
        <p class="text-center fw-bold mb-0">Aplikasi dalam tahap development - Stage: Production - Coder: Pandjie Aldino</p>
    </div>
    <?php

    if (isset($_SESSION['app_login'])) {
    ?>

        <nav class="navbar navbar-dark navbar-expand-lg bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand d-flex gap-1" href="#">
                    <img src="<?= BASEURL ?>/favicon.ico" alt="group" class="d-block m-auto rounded-3" style="width: 35px; height: 35px;">
                    <p class="m-auto"><?= TITLE_SITE ?></p>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                    <div class="navbar-nav">
                        <button type="button" onclick="window.location.href='<?= BASEURL ?>'" class="nav-link <?= $page == 'home' ? 'active' : '' ?> d-flex btn border border-0">
                            <div class="d-flex gap-2">
                                <i class="bi <?= $page == 'home' ? 'bi-house-fill' : 'bi-house' ?> m-auto"></i>
                                <p class="m-auto">Home</p>
                            </div>
                        </button>

                        <button type="button" onclick="window.location.href='<?= BASEURL ?>/server/all'" class="nav-link <?= $page == 'allServers' ? 'active' : '' ?> d-flex btn border border-0">
                            <div class="d-flex gap-2">
                                <i class="bi <?= $page == 'allServers' ? 'bi-people-fill' : 'bi-people' ?> m-auto"></i>
                                <p class="m-auto">All Servers</p>
                            </div>
                        </button>

                        <button type="button" onclick="window.location.href='<?= BASEURL ?>/inbox'" class="nav-link <?= $page == 'inbox' ? 'active' : '' ?> d-flex btn border border-0">
                            <div class="d-flex gap-2">
                                <i class="bi bi-envelope m-auto"></i>
                                <p class="m-auto">Inbox</p>
                            </div>
                        </button>

                        <form action="" method="post" class="d-flex">
                            <button name="logout" type="submit" class="nav-link btn border border-0">
                                <div class="d-flex gap-2">
                                    <i class="bi bi-door-open m-auto"></i>
                                    <p class="m-auto">logout</p>
                                </div>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

    <?php }
    ?>

    <div class="container mt-5">
        <?php
        if (isset($_SESSION['process'])) {
            if ($_SESSION['process']['status'] == "success") {
        ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= $_SESSION['process']['title'] ?> <strong><?= $_SESSION['process']['content'] ?></strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php
            } elseif ($_SESSION['process']['status'] == "failed") {
            ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= $_SESSION['process']['title'] ?> <strong><?= $_SESSION['process']['content'] ?></strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
        <?php
            }
            unset($_SESSION['process']);
        }

        ?>