<?php
session_start();

$title = "Join Server";

require "../../init.php";

ensureUserIsLoggedIn();

?>


<?php require "../../components/head.php"; ?>

<?php require "../../components/foot.php"; ?>