<?php
session_start();

$title = "Inbox";
$page = "inbox";

require "../init.php";

if (!isset($_SESSION['app_login'])) {
    header("Location: " . BASEURL . "/login");
    exit;
}


if (isset($_POST['logout'])) {
    session_unset();
    header("refresh:0;url= ");
}

$decryptUserId = decryptData($_SESSION['app_login']);
$getUser = getUser($decryptUserId);

?>

<?php require "../components/head.php" ?>

<div class="main mt-5">

    <button type="button" onclick="history.back()" class="btn border border-0 py-1 gap-2 fs-4 d-flex">
        <i class="bi bi-arrow-left m-auto"></i>
        <p class="m-auto">Back</p>
    </button>

    <p class="display-5 fw-bold">
        Inbox
    </p>
</div>

<?php require "../components/foot.php" ?>