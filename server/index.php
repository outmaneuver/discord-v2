<?php
session_start();
require "../init.php";

$userData = checkAndRetrieveUser();
$serverUUID = getSanitizedServerUUID();
$fetchServer = getServerByUUID($serverUUID);

$decryptedUserId = $userData['user_id'];

if (empty($fetchServer)) {
    redirect(BASEURL . '/notfound');
    exit;
}

$title = "Server | " . $fetchServer['server_name'];

$isValidMember = $db->query("SELECT * FROM server_members WHERE server_uuid = '$serverUUID' AND member_id = '$decryptedUserId'");

if ($isValidMember->num_rows < 1) {
    header("Location: " . BASEURL . "/server/about/?v=$serverUUID");
    exit;
}

$getAllMembers = fetchNonAdminMembers($serverUUID);
$getAdminMembers = fetchAdminMembers($serverUUID);

$totalMember = getTotalServerMembers($serverUUID);


if(isset($_POST['leaveServer'])) {
    if (leaveServer($serverUUID, $decryptedUserId) > 0) {
        redirect(BASEURL);
        exit;
    } else {
        redirectToCurrentPage();
        exit;
    }
}
?>

<?php require "../components/head.php"; ?>


<p>server: <?= $fetchServer['server_name'] ?></p>
<div class="d-flex gap-4">


    <div class="allMember">
        <p>Server Members :</p>
        <?php
        // echo $getAllMembers->num_rows < 1 ? "This server not have members" : "";
        echo $totalMember;

        while ($allMembers = $getAllMembers->fetch_assoc()) :
            if ($allMembers['member_id'] === NULL) {
        ?>
                <p class="fw-bold">@DELETED USER</p>
            <?php } ?>
            <p>@<?= $allMembers['username'] ?></p>
        <?php endwhile; ?>
    </div>

    <div class="admin">
        <ul>
            <p>Server Admin :</p>
            <?php
            echo $getAdminMembers->num_rows < 1 ? "This server not have admin" : "";
            while ($allAdmin = $getAdminMembers->fetch_assoc()) : ?>
                <li><?= $allAdmin['username'] ?></li>
            <?php endwhile; ?>
        </ul>
    </div>

</div>

<div>
    <form action="" method="post">
        <button type="submit" name="leaveServer" class="btn btn-dark px-3 py-1 rounded-2">Leave Server</button>
    </form>
</div>


<?php require "../components/foot.php"; ?>