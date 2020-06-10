<?php

define('CLIENT_ID', getenv('CLIENT_ID'));
define('CLIENT_SECRET', getenv('CLIENT_SECRET'));
define('OAUTH_REFRESH_TOKEN', getenv('OAUTH_REFRESH_TOKEN'));

define('AWS_S3_KEY', getenv('AWS_S3_KEY'));
define('AWS_S3_SECRET', getenv('AWS_S3_SECRET'));
define('AWS_S3_REGION', getenv('AWS_S3_REGION'));
define('AWS_S3_BUCKET', getenv('AWS_S3_BUCKET'));

define('PLAYLIST_FILE_NAME', 's3://'.AWS_S3_BUCKET.'/results/'.date('Y-m-d').'.txt');
