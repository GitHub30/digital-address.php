<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: *');
header('Access-Control-Allow-Headers: *');

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(204);
    exit;
}

$search_code = $_GET['search_code'] ?? ltrim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
if (!preg_match('/^\w{3,7}$/', $search_code)) {
    http_response_code(400);
    exit;
}

$token_filename = 'access_token.json';
if (file_exists($token_filename)) {
    $json = file_get_contents($token_filename);
    $obj = json_decode($json);
    if (time() < filemtime($token_filename) + $obj->expires_in) {
        $token = $obj->token;
    }
}

if (!isset($token)) {
    $ch = curl_init('https://api.da.pf.japanpost.jp/api/v1/j/token');
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; DigitalAddress/1.0; +https://digital-address.app)');
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_POSTFIELDS, file_get_contents('credentials.json'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $json = curl_exec($ch);
    curl_close($ch);

    $code = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
    if ($code !== 200) {
        http_response_code($code);
        header('Content-Type: application/json');
        die($json);
    }

    file_put_contents($token_filename, $json);
    $token = json_decode($json)->token;
}

$ch = curl_init("https://api.da.pf.japanpost.jp/api/v1/searchcode/$search_code");
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; DigitalAddress/1.0; +https://digital-address.app)');
curl_setopt($ch, CURLOPT_HTTPHEADER, ["Authorization: Bearer $token"]);
curl_exec($ch);
http_response_code(curl_getinfo($ch, CURLINFO_RESPONSE_CODE));
header('Content-Type: application/json');
curl_close($ch);
