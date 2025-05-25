<?php
/**
 *
 * @Author: Max Base
 * @Date: 05/25/2025
 * @Repository: https://github.com/BaseMax/moadian-api-example
 *
 **/

// Config
$clientId = 'xxxxxxxxx';
$privateKeyPath = __DIR__ . '/private_key.txt';
$certificatePath = __DIR__ . '/cert.cer';

function base64url_encode($data)
{
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

$sigT = gmdate("Y-m-d\TH:i:s\Z");
$cert = file_get_contents($certificatePath);
$certClean = trim(str_replace(["-----BEGIN CERTIFICATE-----", "-----END CERTIFICATE-----", "\n", "\r"], "", $cert));

$header = [
    "alg" => "RS256",
    "x5c" => [$certClean],
    "sigT" => $sigT,
    "crit" => ["sigT"]
];
$payload = [
    "nonce" => $nonce,
    "clientId" => $clientId
];

$encodedHeader = base64url_encode(json_encode($header, JSON_UNESCAPED_SLASHES));
$encodedPayload = base64url_encode(json_encode($payload, JSON_UNESCAPED_SLASHES));
$dataToSign = $encodedHeader . '.' . $encodedPayload;

$privateKeyPem = file_get_contents($privateKeyPath);
$privateKey = openssl_pkey_get_private($privateKeyPem);
if (!$privateKey) {
    die("کلید خصوصی بارگذاری نشد.");
}

openssl_sign($dataToSign, $signature, $privateKey, OPENSSL_ALGO_SHA256);
$encodedSignature = base64url_encode($signature);

$jwsToken = $encodedHeader . '.' . $encodedPayload . '.' . $encodedSignature;
print $jwsToken;
