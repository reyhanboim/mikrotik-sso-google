<?php
$client_id = '528927728124-bn1jh1or6dfadhl8gn1rncmoocs80adh.apps.googleusercontent.com';
$client_secret = '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';
$redirect_uri = 'https://testis.rspkt.com/sso/callback.php';

if (!isset($_GET['code'])) {
    header("Location: fail.php");
    exit;
}

$code = $_GET['code'];

$token = file_get_contents('https://oauth2.googleapis.com/token', false, stream_context_create([
    'http' => [
        'method'  => 'POST',
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'content' => http_build_query([
            'code' => $code,
            'client_id' => $client_id,
            'client_secret' => $client_secret,
            'redirect_uri' => $redirect_uri,
            'grant_type' => 'authorization_code',
        ]),
    ]
]));

$response = json_decode($token, true);
if (!isset($response['access_token'])) {
    header("Location: fail.php");
    exit;
}

$access_token = $response['access_token'];
$user_info = file_get_contents("https://www.googleapis.com/oauth2/v2/userinfo?access_token=$access_token");
$user = json_decode($user_info, true);

$email = $user['email'];
$allowed_domain = 'rspkt.id';

// Validasi email (opsional)
if (!str_ends_with($email, "@$allowed_domain")) {
    header("Location: fail.php");
    exit;
}

// Ambil cookie dari Mikrotik Hotspot
$mac = $_COOKIE['mac'];
$ip = $_COOKIE['ip'];
$link_login_only = $_COOKIE['link-login-only'];

// Login otomatis ke Mikrotik (gunakan dummy password)
header("Location: http://$link_login_only?username=" . urlencode($email) . "&password=" . $email );
exit;
?>

