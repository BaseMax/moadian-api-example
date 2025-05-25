<?php
/**
 *
 * @Author: Max Base
 * @Date: 05/25/2025
 * @Repository: https://github.com/BaseMax/moadian-api-example
 *
 **/

// MIN is 10
// DEFAULT is 30
// MAX is 200
$timeToLive = 200;

$nonceUrl = "https://tp.tax.gov.ir/requestsmanager/api/v2/nonce?timeToLive=$timeToLive";
$nonceResponse = file_get_contents($nonceUrl);
if (!$nonceResponse) {
    die("دریافت nonce با خطا مواجه شد.");
}

$nonceData = json_decode($nonceResponse, true);
$nonce = $nonceData['nonce'] ?? null;
$expDate = $nonceData['expDate'] ?? null;

if (!$nonce) {
    die("nonce یافت نشد.");
}

print "Nonce: $nonce\n";
