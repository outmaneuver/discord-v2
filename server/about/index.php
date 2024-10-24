<?php
session_start();

require "../../init.php";

$userData = checkAndRetrieveUser();
$serverUUID = getSanitizedServerUUID();
$server = getServerByUUID($serverUUID);

$decryptUserId = $userData['user_id'];

if (empty($server)) {
    header("Location: " . BASEURL . "/notfound");
    exit;
}

$serverUUID = $server['server_uuid'];
$ownerServer = getUser($server['created_by']);
$title = "Server | " . $server['server_name'];

$isValidMember = $db->query("SELECT * FROM server_members WHERE server_uuid = '$serverUUID' AND member_id = '$decryptUserId'");

if ($isValidMember->num_rows > 0) {
    header("Location: " . BASEURL . "/server/?v=$serverUUID");
    exit;
}

if (isset($_POST['joinServer'])) {
    if (addMemberToServer($server['server_uuid'], $decryptUserId)) {
        header("Location: " . BASEURL . "/server/?v=$serverUUID");
        exit;
    } else {
        header("refresh:0;url= ");
        exit;
    }
}

if (isset($_POST['requestJoin'])) {
    if (requestServerJoin($serverUUID, $decryptUserId, $_POST['reason']) > 0) {
        header("refresh:0;url= ");
        exit;
    } else {
        header("refresh:0;url= ");
        exit;
    }
}

?>


<?php require "../../components/head.php"; ?>
<div class="main-createServer d-flex">
    <div class="col-12 col-lg-6 m-auto border rounded-4 p-3">
        <div class="title-content d-flex">
            <div class="m-auto d-flex gap-2 pb-3">
                <img src="<?= BASEURL ?>/server-profile.webp" alt="icon" class="d-block m-auto rounded-3 shadow-sm">
                <p class="display-5 m-auto"><?= $server['server_name'] ?></p>
            </div>
        </div>

        <?php
        if ($server['server_visibility'] === "private") {
        ?>
            <div class="visibility-private d-flex col-1 text-danger">
                <i class="bi bi-lock-fill fs-5 m-auto"></i>
                <p class="m-auto fw-bold">Private</p>
            </div>
        <?php
        } elseif ($server['server_visibility'] === "public") {
        ?>
            <div class="visibility-public d-flex col-1 text-success gap-1">
                <i class="bi bi-globe fs-5 m-auto"></i>
                <p class="m-auto fw-bold">Public</p>
            </div>
        <?php
        }
        ?>
        <div class="main-content">
            <?php if ($ownerServer === NULL) { ?>
                <p class="fs-6 mb-0">This server was created by <span class="fw-bold">@DELETED USER</span></p>
            <?php } elseif ($ownerServer['username'] != NULL) { ?>
                <p class="fs-6 mb-0">This server was created by <span class="fw-bold">@<?= $ownerServer['username'] ?></span></p>
            <?php } ?>
            <p class="fs-6">Description: "<?= $server['server_description'] ?>".</p>
        </div>
        <form action="" method="post">
            <div class="d-flex justify-content-between">
                <button type="button" onclick="history.back()" class="btn border border-0 py-1 gap-2 d-flex">
                    <i class="bi bi-arrow-left fs-6 m-auto"></i>
                    <p class="m-auto">Back</p>
                </button>

                <?php
                if ($server['server_visibility'] === "private") {
                ?>
                    <button type="button" class="btn btn-dark px-3 py-0 gap-2 d-flex" data-bs-toggle="modal" href="#exampleModalToggle" role="button">
                        <i class="bi bi-house-lock fs-4 m-auto"></i>
                        <p class="m-auto">Ask for Join</p>
                    </button>
                <?php
                } elseif ($server['server_visibility'] === "public") {
                ?>
                    <button type="submit" name="joinServer" class="btn btn-dark px-3 py-0 gap-2 d-flex">
                        <i class="bi bi-house-add fs-4 m-auto"></i>
                        <p class="m-auto">Join Server</p>
                    </button>
                <?php
                }
                ?>
            </div>
        </form>

        <div class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="modal-title fs-5 d-flex gap-1" id="exampleModalToggleLabel">
                            <img src="<?= BASEURL ?>/server-profile.webp" alt="icon" class="rounded-3 m-auto shadow-sm" style="width: 35px; height: 35px">
                            <p class="m-auto fw-bold fs-6"><?= $server['server_name'] ?></p>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="" method="post">
                        <div class="modal-body">
                            <span class="fw-bold"><?= $server['server_name'] ?></span> server is private, please fill in the column below why you want to join the server
                            <div class="mb-3">
                                <input type="text" name="reason" class="form-control" placeholder="Why?">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn border border-0 d-flex gap-2" data-bs-target="#exampleModalToggle2" data-bs-toggle="modal">
                                <i class="bi bi-code-slash m-auto"></i>
                                <p class="m-auto">I have the code</p>
                            </button>
                            <button type="submit" name="requestJoin" class="btn btn-dark px-3 py-1 d-flex gap-2">
                                <i class="bi bi-send m-auto"></i>
                                <p class="m-auto">Send</p>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="exampleModalToggle2" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="modal-title fs-5 d-flex gap-1" id="exampleModalToggleLabel">
                            <img src="<?= BASEURL ?>/server-profile.webp" alt="icon" class="rounded-3 m-auto shadow-sm" style="width: 35px; height: 35px">
                            <p class="m-auto fw-bold fs-6"><?= $server['server_name'] ?></p>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="" method="post">
                        <div class="modal-body">
                            <div class="card border border-0 p-2 text-center">
                                <h6>Please enter the server code <br> to join this server</h6>
                                <div> <small class="text-muted">ask the server owner to get the server code.</small> </div>
                                <div id="otp" class="inputs d-flex flex-row justify-content-center mt-2">
                                    <input class="m-2 text-center form-control rounded" type="number" id="first" maxlength="1" />
                                    <input class="m-2 text-center form-control rounded" type="number" id="second" maxlength="1" />
                                    <input class="m-2 text-center form-control rounded" type="number" id="third" maxlength="1" />
                                    <input class="m-2 text-center form-control rounded" type="number" id="fourth" maxlength="1" />
                                    <input class="m-2 text-center form-control rounded" type="number" id="fifth" maxlength="1" />
                                    <input class="m-2 text-center form-control rounded" type="number" id="sixth" maxlength="1" />
                                    <input class="m-2 text-center form-control rounded" type="number" id="seventh" maxlength="1" />
                                    <input class="m-2 text-center form-control rounded" type="number" id="eighth" maxlength="1" />
                                </div>
                                <div class="mt-4"> <button class="btn btn-dark px-3 py-1" id="validateCode"> <i class="bi bi-stars"></i> Validate</button> </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require "../../components/foot.php"; ?>