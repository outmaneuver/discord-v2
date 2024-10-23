<?php

// define("BASEURL", "https://ad83-2001-448a-1002-1c0d-a9f0-1fb7-3011-738f.ngrok-free.app/discord");
define("BASEURL", "https://discord.app");
// define("BASEURL", "http://localhost/discord-v2");
define("TITLE_SITE", "Discord");
define("ENCRYPT_KEY", "AESA_SDW_45_XANN_MEY_ASdaASlpqwKDMC3412ISJAO1501");
function uuid()
{
    return sprintf(
        '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0x0fff) | 0x4000,
        mt_rand(0, 0x3fff) | 0x8000,
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff)
    );
}

function redirect($url)
{
    header("Location: $url");
    exit;
}

function redirectToCurrentPage()
{
    // Ambil URL saat ini
    $currentUrl = $_SERVER['REQUEST_URI'];
    header("Location: $currentUrl");
    exit;
}

function ensureUserIsLoggedIn()
{
    global $db;

    // Memeriksa apakah pengguna sudah login
    if (!isset($_SESSION['app_login'])) {
        redirect(BASEURL . '/login');
        exit; // Keluar jika belum login
    }
}


function checkAndRetrieveUser()
{
    global $db;

    // Memeriksa apakah pengguna sudah login
    if (!isset($_SESSION['app_login'])) {
        redirect(BASEURL . '/login');
        exit; // Keluar jika belum login
    }

    // Jika sudah login, dekode user ID dan ambil data pengguna
    $decryptUserId = decryptData($_SESSION['app_login']);
    return getUser($decryptUserId); // Mengembalikan data pengguna
}

function getSanitizedServerUUID()
{
    global $db;

    // Mengambil serverUUID dari parameter GET
    return isset($_GET['v']) ? $db->real_escape_string($_GET['v']) : null; // Kembalikan null jika tidak ada
}
