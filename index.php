<?php
session_start();

$title = "Home";
$page = "home";

require "./init.php";

$userData = checkAndRetrieveUser();


if (isset($_POST['easterEgg'])) {
    $keyword = mysqli_real_escape_string($db, $_POST['keywords']);
    if ($keyword === 'admincg') {
        $_SESSION['app_admin'] = true;
        redirectToCurrentPage();
        exit;
    }
    if ($keyword === 'removecg') {
        unset($_SESSION['app_admin']);
        redirectToCurrentPage();

        exit;
    }
    redirectToCurrentPage();

    exit;
}

?>

<?php require "./components/head.php" ?>

<div class="cta d-flex gap-2">

    <div class="dropdown">
        <button class="btn btn-dark rounded-pill px-4 py-1 dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Servers
        </button>

        <ul class="dropdown-menu">
            <li class="d-flex">
                <button class="dropdown-item d-flex" onclick="window.location.href='<?= BASEURL ?>/server/create'">
                    <i class="bi bi-house-add fs-4"></i>
                    <p class="m-auto">Create Server</p>
                </button>
            </li>
            <li class="d-flex">
                <button class="dropdown-item d-flex" onclick="window.location.href='<?= BASEURL ?>/server/join'">
                    <i class="bi bi-box-arrow-in-right fs-4"></i>
                    <p class="m-auto">Join Server</p>
                </button>
            </li>
        </ul>
    </div>

    <form action="" method="post">
        <div class="input-group">
            <div class="form-outline col-10">
                <input type="search" name="keywords" class="form-control" />
            </div>
            <button type="submit" name="easterEgg" class="btn btn-dark">
                <i class="bi bi-search"></i>
            </button>
        </div>
    </form>
</div>

<div class="main mt-5">


    <div class="welcome">
        hello <?= $userData['username'] ?>, welcome to <?= TITLE_SITE ?>,
    </div>

    <p class="display-5 fw-bold">
        Server List
    </p>
    <ul class="list-group col-12 col-lg-6">
        <?php

        // Mengambil daftar server untuk pengguna saat ini
        $serverList = getServerListByUserId($userData['user_id']);

        if (empty($serverList)) {
        ?>

            <p class="display-6 fs-2">You don't have any server yet.</p>

        <?php
        }
        foreach ($serverList as $server) :
            $serverUUID = $server['server_uuid'];
        ?>

            <button onclick="window.location.href='<?= BASEURL ?>/server/?v=<?= $serverUUID ?>'" class="list-group-item d-flex justify-content-between align-items-center">
                <div class="d-flex gap-2">
                    <img src="favicon.ico" alt="servers" class="d-block mx-auto rounded-3" style="width: 35px; height: 35px;">
                    <p class="server-name m-auto fw-bold"><?= $server['server_name'] ?></p>
                </div>
                <div class="d-flex gap-2">
                    <span class="badge bg-primary rounded-pill">3</span>
                    <?php if (isset($_SESSION['app_admin'])) { ?>
                        <form action="" method="post">
                            <input type="hidden" name="server_uuid">
                        </form>
                    <?php } ?>
                </div>
            </button>

        <?php endforeach; ?>

    </ul>
</div>


<?php require "./components/foot.php" ?>