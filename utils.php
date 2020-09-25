<?php

function render_template($templateName = 'template') {
    ob_start();
    include "./$templateName.php";
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
}

function refresh_token($clientId, $clientSecret, $oAuthRefreshToken) {
    $oAuthToken = null;
    $apiUrl = 'https://accounts.spotify.com/api/token';

    $file = file_get_contents($apiUrl, false, stream_context_create([
        'http' => [
            'method' => 'POST',
            'header' => 'Content-Type: application/x-www-form-urlencoded',
            'content' => http_build_query([
                'client_id' => $clientId,
                'client_secret' => $clientSecret,
                'grant_type' => 'refresh_token',
                'refresh_token' => $oAuthRefreshToken,
            ])
        ]
    ]));

    if (!empty($file)) {
        $data = json_decode($file);
        if ($data) {
            return $data->access_token;
        }
    }

    else {
        throw new Exception('Could not decode JSON data from API');
    }
}

function s3_register_sream_wrapper($region, $key, $secret, $endpoint = null) {
    $s3Config = [
        'region'  => $region,
        'version' => 'latest',
        'use_path_style_endpoint' => false,
        'credentials' => [
            'key'    => $key,
            'secret' => $secret,
        ]
    ];

    if ($endpoint) {
        $s3Config['endpoint'] = $endpoint;
    }

    $s3 = new Aws\S3\S3Client($s3Config);
    $s3->registerStreamWrapper();
}
