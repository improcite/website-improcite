<?php
// Prerequisites
// guzzlehttp/guzzle
// firebase/php-jwt
// cf. composer.json
// L'API autorise les connexions deouis improcite.com et localhost:8888
// install composer : https://getcomposer.org/download/
// php composer.phar install
// 'tention à la version de php, je me suis fait niquer et ça marchait pas

require __DIR__ . '/vendor/autoload.php';

// From https://developer.box.com/guides/authentication/jwt/without-sdk/#1-read-json-configuration

// 1. Read JSON Configuration

$json = file_get_contents('getBoxToken.json');
$config = json_decode($json);

// 2. Decrypt private key

$private_key = $config->boxAppSettings->appAuth->privateKey;
$passphrase = $config->boxAppSettings->appAuth->passphrase;
$key = openssl_pkey_get_private($private_key, $passphrase);

// 3. Create JWT assertion

$authenticationUrl = 'https://api.box.com/oauth2/token';

// On récupère le userId du compte via https://api.box.com/2.0/users/ et un token de dev
$userId = '13545946182';

$claims = [
  'iss' => $config->boxAppSettings->clientID,
  'sub' => $userId,
  'box_sub_type' => 'user',
  'aud' => $authenticationUrl,
  'jti' => base64_encode(random_bytes(64)),
  'exp' => time() + 45,
  'kid' => $config->boxAppSettings->appAuth->publicKeyID
];

// Sign the JWT assertion

use \Firebase\JWT\JWT;
$assertion = JWT::encode($claims, $key, 'RS512');

// 4. Request Access Token

use GuzzleHttp\Client;

$params = [
  'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
  'assertion' => $assertion,
  'client_id' => $config->boxAppSettings->clientID,
  'client_secret' => $config->boxAppSettings->clientSecret
];

$client = new Client();
$response = $client->request('POST', $authenticationUrl, [
  'form_params' => $params
]);

$data = $response->getBody()->getContents();
$access_token = json_decode($data)->access_token;

// Returns access token
echo $access_token;

?>
