<?php
/**
 *
 * @Author: Max Base
 * @Date: 05/25/2025
 * @Repository: https://github.com/BaseMax/moadian-api-example
 *
 **/

// Config
$jwsToken = "";

$headers = [
    "Authorization: Bearer $jwsToken",
    "Accept: */*"
];

$context = stream_context_create([
    "http" => [
        "method" => "GET",
        "header" => implode("\r\n", $headers),
    ]
]);

$response = file_get_contents("https://tp.tax.gov.ir/requestsmanager/api/v2/server-information", false, $context);

if ($response === false) {
    die("خطا در فراخوانی سرویس دوم (server-information).");
}

$result = json_decode($response, true);
print_r($result);
