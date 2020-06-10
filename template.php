<!DOCTYPE html>
<html lang="de">
    <head>
        <meta charset="utf-8" />
        <title>It's Friday!</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="refresh" content="60" />
        <style type="text/css">
            html, body, * {
                font-family: Arial;
                font-size: 15px;
                line-height: 1.5rem;
            }

            h1 {
                font-size: 20px;
            }
        </style>
    </head>
    <body>
        <h1>Ergebnisse für <?php echo date('d.m.Y'); ?></h1>
        <ul>
            <?php
                $fileContents = file(PLAYLIST_FILE_NAME);
                foreach($fileContents as $line) {
                    echo "<li>$line</li>";
                }
            ?>
        </ul>
    </body>
</html>
