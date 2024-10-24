<?php
session_start();

$title = "Join Server";

require "../../init.php";

ensureUserIsLoggedIn();

?>

<?php require "../../components/head.php"; ?>

<div class="main-createServer d-flex">
    <div class="col-12 col-lg-6 m-auto border rounded-4 p-3">
        <div class="title-content d-flex">
            <div class="m-auto d-flex gap-2 pb-3">
                <img src="<?= BASEURL ?>/favicon.ico" alt="icon" class="d-block m-auto rounded-3">
                <p class="display-5 m-auto">Join Server</p>
            </div>
        </div>
        <form action="" method="POST">
        <div class="text-center">
        <h6>Please enter the server code <br> to join this server</h6>
        <div> 
            <small class="text-muted">Ask the server owner to get the server code.</small> 
        </div>
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
        </div>

            <div class="d-flex justify-content-between mt-3">
                <button type="button" onclick="history.back()" class="btn border border-0 py-1 gap-2 d-flex">
                    <i class="bi bi-arrow-left fs-6 m-auto"></i>
                    <p class="m-auto">Back</p>
                </button>

                <button class="btn btn-dark px-3 py-1" id="validateCode">
                    <i class="bi bi-stars"></i> Validate
                </button>
            </div>
        </form>

    </div>
</div>

<?php require "../../components/foot.php"; ?>