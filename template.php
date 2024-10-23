<?php
session_start();

$title = "Create Group";

require "../init.php";

if (!isset($_SESSION['app_login'])) {
    header("Location: " . BASEURL . "/login");
    exit;
}

?>


<?php require "../components/head.php"; ?>

<?php require "../components/foot.php"; ?>