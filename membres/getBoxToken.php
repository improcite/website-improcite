<?php

# Verification de la session
session_start();

if (!isset ($_SESSION[ "id_impro_membre" ])) {
    die(0);
}

require '../vendor/autoload.php';

// From https://developer.box.com/guides/authentication/jwt/without-sdk/#1-read-json-configuration

// 1. Read JSON Configuration

require_once("../config.inc.php");
$config = json_decode($box_settings);

// 2. Decrypt private key

$private_key = $config->boxAppSettings->appAuth->privateKey;
$passphrase = $config->boxAppSettings->appAuth->passphrase;
$key = openssl_pkey_get_private($private_key, $passphrase);

// 3. Create JWT assertion

$authenticationUrl = $box_token_url;

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
