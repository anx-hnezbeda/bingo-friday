<?php
    require_once 'config.php';
    require_once 'utils.php';

    function lambda_handler($event, $context) {

        date_default_timezone_set('Europe/Vienna');
        $today9am = strtotime("today 9am") * 1000;

        $apiUrl = "https://api.spotify.com/v1/me/player/recently-played?limit=50&after=$today9am";
        $playlistFile = './recently-played.txt';

        $file = file_get_contents($apiUrl, false, stream_context_create([
            'http' => [
                'method' => 'GET',
                'header' => "Authorization: Bearer ".refresh_token(CLIENT_ID, CLIENT_SECRET, OAUTH_REFRESH_TOKEN)
            ]
        ]));

        if (!empty($file)) {
            $data = json_decode($file);
            if ($data) {
                $fileContents = file($playlistFile);

                $replaceCharacters = [
                    chr(10) => '',
                    chr(13) => ''
                ];

                foreach ($data->items as $item) {
                    $playedAt = strtr($item->played_at, $replaceCharacters);
                    $playedAtFormatted = date('H:i:s', strtotime($playedAt));
                    $trackId = strtr($item->track->id, $replaceCharacters);
                    $trackName = strtr($item->track->name, $replaceCharacters);
                    $albumName = strtr($item->track->album->name, $replaceCharacters);
                    $artistNames = [];
        
                    foreach ($item->track->artists as $artist) {
                        $artistNames[] = $artist->name;
                    }
                    $artistNames = strtr(implode(' & ', $artistNames), $replaceCharacters);

                    $contentString = "$playedAtFormatted | $artistNames: $trackName ($albumName)\n";
                    if (!in_array($contentString, $fileContents)) {
                        $fileContents[] = $contentString;
                    }
                }

                $fileContents = array_unique($fileContents);
                rsort($fileContents);

                $filePointer = fopen($playlistFile, 'w');
                fwrite($filePointer, implode('', $fileContents));
                fclose($filePointer);
            } else {
                throw new Exception('Could not decode JSON data from API');
            }
        }

        return [
            'status' => 200,
            'type' => 'binary',
            'response_headers' => [
                'Content-Type' => 'text/html'
            ],
            'data' => base64_encode(render_template())
        ];
    }
