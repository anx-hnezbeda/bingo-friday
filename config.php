<?php

define('CLIENT_ID', getenv('CLIENT_ID'));
define('CLIENT_SECRET', getenv('CLIENT_SECRET'));
define('OAUTH_REFRESH_TOKEN', getenv('OAUTH_REFRESH_TOKEN'));

define('S3_KEY', getenv('S3_KEY'));
define('S3_SECRET', getenv('S3_SECRET'));
define('S3_REGION', getenv('S3_REGION'));
define('S3_BUCKET', getenv('S3_BUCKET'));
define('S3_ENDPOINT', getenv('S3_ENDPOINT', null));

define('PLAYLIST_FILE_NAME', 's3://'.S3_BUCKET.'/results/'.date('Y-m-d').'.txt');
