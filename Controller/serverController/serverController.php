<?php

function createNewServer()
{
    global $db;

    $serverName = mysqli_real_escape_string($db, $_POST['serverName']);
    $description = mysqli_real_escape_string($db, $_POST['description']);
    $time = date("d/m/Y");

    // Membuat UUID baru untuk server
    $uuid = uuid(); // Buat UUID baru

    if (isset($_POST["visibility"])) {
        $selectedVisibility = $_POST["visibility"];
        if ($selectedVisibility == "private") {
            $visibility = "private";
        } elseif ($selectedVisibility == "public") {
            $visibility = "public";
        }
    } else {
        $visibility = "public";
    }

    //? check serverName
    if (checkServerNameAvailability($serverName) > 0) {
        $_SESSION['process'] = [
            "status" => "failed",
            "title" => "Failed,",
            "content" => "the name (" . $serverName . ") is already in use, try another name!"
        ];
        return 0;
    }

    //? check data is complete or no
    if (validateServerData($serverName) == 0) {
        $_SESSION['process'] = [
            "status" => "failed",
            "title" => "Failed,",
            "content" => "please complete all the data"
        ];
        return 0;
    }

    $decryptUserId = decryptData($_SESSION['app_login']);

    //! Create Server
    $db->query("INSERT INTO servers(server_uuid, created_by, server_name, server_description, server_visibility, created_at) VALUES('$uuid', '$decryptUserId', '$serverName', '$description', '$visibility', '$time')");

    //! Create Server Link
    $getServer = getServerByName($serverName);
    $serverUUID = $getServer['server_uuid'];
    createUniqueServerLink($serverUUID);
    createUniqueServerCode($serverUUID);

    //! Create SelfMember
    $db->query("INSERT INTO server_members(server_uuid, member_id, is_admin) VALUES('$serverUUID', '$decryptUserId', 1)");

    $_SESSION['process'] = [
        "status" => "success",
        "title" => "Successfuly",
        "content" => "created a server [ " . $serverName . " ]."
    ];
    return 1;
}


function validateServerData($serverName)
{

    // Menghapus spasi dari string
    $serverName = str_replace(' ', '', $serverName);

    // Menghitung panjang string tanpa spasi
    $lengthserverName = strlen($serverName);

    return $lengthserverName < 1 ? 0 : 1;
}

function checkServerNameAvailability($serverName)
{
    global $db;

    $isAvailabe = $db->query("SELECT server_name FROM servers WHERE server_name = '$serverName'");
    return $isAvailabe->num_rows;
}

function getServerByUUID($serverUUID)
{
    global $db;

    $serverUUID = $db->real_escape_string($serverUUID);
    $query = $db->query("SELECT * FROM servers WHERE server_uuid = '$serverUUID'");

    return $query->fetch_assoc();
}


function getServerByName($serverName)
{
    global $db;

    $query = $db->query("SELECT * FROM servers WHERE server_name = '$serverName'");

    return $query->fetch_assoc();
}

function fetchAllServers()
{
    global $db;

    $query = $db->query("SELECT * FROM servers ORDER by server_name ASC");

    return $query;
}

function createUniqueServerLink($serverUUID)
{
    global $db;

    $link = "";
    $serverUUID = $db->real_escape_string($serverUUID);

    while (true) {
        $link = strtoupper(substr(md5(rand()), 0, 8)); // Menghasilkan kode acak 8 karakter

        // Periksa apakah kode sudah ada dalam database
        $query = "SELECT COUNT(*) as count FROM server_link WHERE link = '$link'";
        $result = $db->query($query);

        $row = $result->fetch_assoc();

        if ($row['count'] == 0) {
            // Kode unik ditemukan, simpan ke database
            $insertQuery = "INSERT INTO server_link (server_uuid, link) VALUES ('$serverUUID', '$link')";
            $db->query($insertQuery);

            break;
        }
    }

    return 1;
}

function createUniqueServerCode($serverUUID)
{
    global $db;

    $code = "";
    $serverUUID = $db->real_escape_string($serverUUID);

    while (true) {
        $code = str_pad(rand(0, 99999999), 8, '0', STR_PAD_LEFT); // Menghasilkan kode acak 5 angka
        
        // Periksa apakah kode sudah ada dalam database
        $query = "SELECT COUNT(*) as count FROM server_code WHERE code = '$code'";
        $result = $db->query($query);

        $row = $result->fetch_assoc();

        if ($row['count'] == 0) {
            // Kode unik ditemukan, simpan ke database
            $insertQuery = "INSERT INTO server_code (server_uuid, code) VALUES ('$serverUUID', '$code')";
            $db->query($insertQuery);

            break;
        }
    }

    return 1;
}


function getServerLink($serverUUID)
{
    global $db;

    $serverUUID = $db->real_escape_string($serverUUID);
    $query = $db->query("SELECT * FROM server_link WHERE server_uuid = '$serverUUID'");
    return $query->fetch_assoc();
}

function getServerCodeById($serverUUID)
{
    global $db;

    $serverUUID = $db->real_escape_string($serverUUID);
    $query = $db->query("SELECT * FROM server_code WHERE server_uuid = '$serverUUID'");
    return $query->fetch_assoc();
}

function addMemberToServer($serverUUID, $memberId)
{
    global $db;

    $serverUUID = $db->real_escape_string($serverUUID);

    $server = getServerByUUID($serverUUID);
    $serverName = $server['server_name'];

    $query = $db->query("INSERT INTO server_members(server_uuid, member_id) VALUES('$serverUUID', '$memberId')");

    if($query) {
        $_SESSION['process'] = [
            "status" => "success",
            "title" => "Joined,",
            "content" => "Welcome to " . $serverName,
        ];
    } else {
        $_SESSION['process'] = [
            "status" => "failed",
            "title" => "failed,",
            "content" => "Something wrong.."
        ];
    }

    return 1;
}

function fetchTotalMembers($serverUUID)
{
    global $db;

    $serverUUID = $db->real_escape_string($serverUUID);
    $serverUUID = $db->real_escape_string($serverUUID);
    $query = $db->query("SELECT * FROM server_members WHERE server_uuid = '$serverUUID'");

    return $query;
}

function fetchNonAdminMembers($serverUUID)
{
    global $db;

    $serverUUID = $db->real_escape_string($serverUUID);
    $query = $db->query("SELECT sm.member_id, sm.is_admin, u.user_id, u.username
    FROM server_members sm
    LEFT JOIN users u ON sm.member_id = u.user_id
    WHERE sm.server_uuid = '$serverUUID'  AND sm.is_admin = 0 ORDER BY sm.id DESC");

    return $query;
}

function fetchAdminMembers($serverUUID)
{
    global $db;

    $serverUUID = $db->real_escape_string($serverUUID);
    $query = $db->query("SELECT sm.member_id, u.user_id, u.username, u.password
    FROM server_members sm
    LEFT JOIN users u ON sm.member_id = u.user_id
    WHERE sm.server_uuid = '$serverUUID' AND sm.is_admin = 1");

    return $query;
}

function getTotalServerMembers($serverUUID)
{
    global $db;

    $serverUUID = $db->real_escape_string($serverUUID);
    $query = $db->query("SELECT * FROM server_members WHERE server_uuid = '$serverUUID'");

    return $query->num_rows;
}

function requestServerJoin($serverUUID, $userId, $reason)
{
    global $db;

    $serverUUID = $db->real_escape_string($serverUUID);
    $reason = mysqli_real_escape_string($db, $reason);
    $time = date("Y:m:d H:i:s");

    $isHasSent = $db->query("SELECT * FROM server_join_requests WHERE server_uuid = '$serverUUID' AND user_id = '$userId'");

    if ($isHasSent->num_rows >= 3) {
        $_SESSION['process'] = [
            "status" => "failed",
            "title" => "Unable to send,",
            "content" => "you have exceeded the 3 request limit."
        ];
        return 0;
    } elseif ($isHasSent->num_rows <= 3) {
        $_SESSION['process'] = [
            "status" => "success",
            "title" => "Successfuly",
            "content" => "submitted request to join."
        ];
        $db->query("INSERT INTO server_join_requests(server_uuid, user_id, reason, created_at) VALUES('$serverUUID', '$userId', '$reason', '$time')");
        return 1;
    }
}

function leaveServer($serverUUID, $memberId)
{
    global $db;

    $serverUUID = $db->real_escape_string($serverUUID);


    $isServerOwner = $db->query("SELECT * FROM servers WHERE server_uuid = '$serverUUID' AND created_by = '$memberId'");
    if($isServerOwner->num_rows > 0) {
        $_SESSION['process'] = [
            "status" => "failed",
            "title" => "Cannot Leave Server,",
            "content" => "you own the server, give other people ownership first.."
        ];
        return 0;
    } else {
        $_SESSION['process'] = [
            "status" => "success",
            "title" => "Leave Server,",
            "content" => "Leaving.."
        ];
        $db->query("DELETE FROM server_members WHERE server_uuid = '$serverUUID' AND member_id = '$memberId'");
        return 1;
    }


    
}



// if (isset($_POST['deleteServer'])) {
//     $serverUUID = $_POST['server_uuid'];

//     $db->query("DELETE FROM servers WHERE server_uuid = '$serverUUID'");
//     $db->query("DELETE FROM server_members WHERE server_uuid = '$serverUUID'");
//     $db->query("DELETE FROM server_link WHERE server_uuid = '$serverUUID'");
//     $db->query("DELETE FROM server_code WHERE server_uuid = '$serverUUID'");
//     $db->query("DELETE FROM request_to_join_server WHERE server_uuid = '$serverUUID'");
// }
