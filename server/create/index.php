<?php
session_start();

$title = "Create Server";

require "../../init.php";

$userData = checkAndRetrieveUser();
$code = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);

if (isset($_POST['createNewServer'])) {
    if (createNewServer($_POST) > 0) {
        redirect(BASEURL);
        exit;
    } else {
        redirectToCurrentPage();
        exit;
    }
}
?>


<?php require "../../components/head.php"; ?>
<div class="main-createServer d-flex">
    <div class="col-12 col-lg-6 m-auto border rounded-4 p-3">
        <div class="title-content d-flex">
            <div class="m-auto d-flex gap-2 pb-3">
                <img src="<?= BASEURL ?>/favicon.ico" alt="icon" class="d-block m-auto rounded-3">
                <p class="display-5 m-auto">Create Server</p>
            </div>
        </div>
        <form action="" method="POST">
            <div class="mb-3">
                <input type="text" name="serverName" class="form-control" placeholder="Server Name" value="<?= $userData['username'] ?>'s private server-<?= $code ?>">
            </div>
            <div class="mb-3">
                <textarea class="form-control" name="description" aria-describedby="descriptionHelp" placeholder="Description"></textarea>
                <div id="descriptionHelp" class="form-text">describe your server</div>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="visibility" id="privateRadio" value="private">
                <label class="form-check-label" for="privateRadio">
                    <i class="bi bi-lock"></i> Private
                </label>
            </div>

            <div class="form-check">
                <input class="form-check-input" type="radio" name="visibility" id="publicRadio" value="public">
                <label class="form-check-label" for="publicRadio">
                    <i class="bi bi-globe"></i> Public
                </label>
            </div>
            <div id="descriptionHelp" class="form-text">default visibility is public</div>

            <div class="d-flex justify-content-between mt-3">
                <button type="button" onclick="history.back()" class="btn border border-0 py-1 gap-2 d-flex">
                    <i class="bi bi-arrow-left fs-6 m-auto"></i>
                    <p class="m-auto">Back</p>
                </button>

                <button type="submit" name="createNewServer" class="btn btn-dark px-3 py-0 gap-2 d-flex">
                    <i class="bi bi-house-add fs-4 m-auto"></i>
                    <p class="m-auto">Create Server</p>
                </button>
            </div>
        </form>

    </div>
</div>
<?php require "../../components/foot.php"; ?>