<?php

function createAccount()
{
    global $db;

    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password = mysqli_real_escape_string($db, $_POST['password']);
    $verifyPassword = mysqli_real_escape_string($db, $_POST['verifyPassword']);

    //? check username
    if (usernameAvailable($username) > 0) {
        $_SESSION['process'] = [
            "status" => "failed",
            "title" => "Failed,",
            "content" => "username(" . $username . ") is already in use, try another username"
        ];
        return 0;
    }

    //? check data is complete or no
    if (isCompleteCreateAccount($username, $password, $verifyPassword) == 0) {
        $_SESSION['process'] = [
            "status" => "failed",
            "title" => "Failed,",
            "content" => "please complete all the data.."
        ];
        return 0;
    }

    //? check password and verifyPassword match or no
    if ($password != $verifyPassword) {
        $_SESSION['process'] = [
            "status" => "failed",
            "title" => "Failed,",
            "content" => "password do not match!"
        ];
        return 0;
    }

    //* Hashing Password
    $password = password_hash($password, PASSWORD_DEFAULT);

    //! Create Account
    $db->query("INSERT INTO users(username, password) VALUES('$username', '$password')");


    //! Get UserId for Session and encrypt
    $fetch = getUserByUsername($username);
    $userId = $fetch['user_id'];
    $_SESSION['process'] = [
        "status" => "success",
        "title" => "Successfuly",
        "content" => "created an account [ " . $username . " ].."
    ];

    $_SESSION['app_login'] = encryptData($userId);

    return 1;
}

function getUser($userId)
{
    global $db;

    $query = $db->query("SELECT * FROM users WHERE user_id = '$userId'");
    $fetch = $query->fetch_assoc();

    return $fetch;
}

function getUserByUsername($username)
{
    global $db;

    $query = $db->query("SELECT * FROM users WHERE username = '$username'");
    $fetch = $query->fetch_assoc();

    return $fetch;
}

function isCompleteCreateAccount($username, $password, $verifyPassword)
{

    // Menghapus spasi dari string
    $username = str_replace(' ', '', $username);

    // Menghitung panjang string tanpa spasi
    $lengthUsername = strlen($username);

    return $lengthUsername < 1 ? 0 : 1;

    return $username && $password && $verifyPassword ? 1 : 0;
}

function usernameAvailable($username)
{
    global $db;

    $isAvailabe = $db->query("SELECT username FROM users WHERE username = '$username'");
    return $isAvailabe->num_rows;
}

function userLogin()
{
    global $db;

    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password = mysqli_real_escape_string($db, $_POST['password']);

    $isValidUser = usernameAvailable($username);

    $query = mysqli_query($db, "SELECT * FROM users WHERE username = '$username'");
    $data = mysqli_fetch_assoc($query);


    if ($username != "" && $password != "") {
        if ($isValidUser > 0) {
            if (password_verify($password, $data['password'])) {
                $_SESSION['process'] = [
                    "status" => "success",
                    "title" => "Successfuly",
                    "content" => "logged in as " . $username . ", welcome back.."
                ];

                //! Get UserId for Session and encrypt
                $fetch = getUserByUsername($username);
                $userId = $fetch['user_id'];
                $_SESSION['app_login'] = encryptData($userId);

                return 1;
            } else {
                $_SESSION['process'] = [
                    "status" => "failed",
                    "title" => "Failed,",
                    "content" => "incorrect username or password!"
                ];
                return 0;
            }
        } else {
            $_SESSION['process'] = [
                "status" => "failed",
                "title" => "Failed,",
                "content" => "username not found.."
            ];
            return 0;
        }
    } else {
        $_SESSION['process'] = [
            "status" => "failed",
            "title" => "Failed,",
            "content" => "please complete your data.."
        ];
        return 0;
    }
}

function encryptData($data)
{
    $key = ENCRYPT_KEY;

    // Membuat Initialization Vector (IV) secara acak
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));

    // Enkripsi data dengan IV
    $encrypted_data = openssl_encrypt($data, 'aes-256-cbc', $key, 0, $iv);

    // Menyimpan IV dan ciphertext dalam sesi
    $_SESSION['iv'] = base64_encode($iv);
    $_SESSION['encrypted_data'] = $encrypted_data;

    return $encrypted_data;
}

// Fungsi untuk mendekripsi data
function decryptData($encrypted_data)
{
    $key = ENCRYPT_KEY;

    // Mendapatkan IV dari sesi
    $iv = base64_decode($_SESSION['iv']);

    // Mendekripsi data dengan IV
    $decrypted_data = openssl_decrypt($encrypted_data, 'aes-256-cbc', $key, 0, $iv);

    return $decrypted_data;
}

// Mendapatkan daftar server berdasarkan ID pengguna
function getServerListByUserId($userId)
{
    global $db;

    // Menggunakan prepared statement untuk keamanan
    $stmt = $db->prepare("
        SELECT S.* 
        FROM servers S 
        INNER JOIN server_members M ON S.server_uuid = M.server_uuid 
        WHERE M.member_id = ? 
        ORDER BY S.server_name ASC
    ");

    // Mengikat parameter dan menjalankan query
    $stmt->bind_param('s', $userId); // 's' indicates that it's a string
    $stmt->execute();

    // Mendapatkan hasil
    $result = $stmt->get_result();

    // Mengembalikan daftar server sebagai array
    return $result->fetch_all(MYSQLI_ASSOC);
}
