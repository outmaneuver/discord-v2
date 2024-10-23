<?php
session_start();

$title = "Notfound";

require "../init.php";

if (!isset($_SESSION['app_login'])) {
    header("Location: " . BASEURL . "/login");
    exit;
}
?>


<?php require "../components/head.php"; ?>
<div class="main-createServer d-flex">
    <div class="col-12 col-lg-6 m-auto border rounded-4 p-3">
        <div class="title-content d-flex">
            <div class="m-auto d-flex gap-2 pb-3">
                <img src="<?= BASEURL ?>/favicon.ico" alt="icon" class="d-block m-auto rounded-3">
                <p class="display-5 m-auto">Page Not Found</p>
            </div>
        </div>

        <div style="height: 200px;"></div>

        <button onclick="history.back()" type="button" class="btn btn-dark px-3 py-0 gap-2 d-flex float-end">
            <i class="bi bi-arrow-left fs-4 m-auto"></i>
            <p class="m-auto">Back</p>
        </button>

    </div>
</div>
<?php require "../components/foot.php"; ?>