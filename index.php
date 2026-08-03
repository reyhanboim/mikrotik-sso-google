<?php
$client_id = '528927728124-bn1jh1or6dfadhl8gn1rncmoocs80adh.apps.googleusercontent.com';
$redirect_uri = 'https://testis.rspkt.com/sso/callback.php';
$scope = 'email profile openid';
$state = 'xyz123';

$url = "https://accounts.google.com/o/oauth2/v2/auth?" . http_build_query([
    'client_id' => $client_id,
    'redirect_uri' => $redirect_uri,
    'response_type' => 'code',
    'scope' => $scope,
    'state' => $state,
    'access_type' => 'offline',
    'prompt' => 'consent'
]);

header('Location: ' . $url);
exit;
?>

