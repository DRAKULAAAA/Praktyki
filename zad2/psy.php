<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Random Dogs</title>
</head>
<body>
    <div id="dog_image">
        <h2>Zdjęcia psów</h2>
        <?php
            function getRandomDogImage() {
                $ch = curl_init();
                $url = "https://dog.ceo/api/breeds/image/random";
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $response = curl_exec($ch);
                curl_close($ch);

                $data = json_decode($response, true);
                return $data['message'];
            }

            $imageUrl = getRandomDogImage();

            echo '<img src="' . $imageUrl . '" alt="Dog Image">';

        ?>
    
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET">
            <button type="submit">Zmień zdjęcie</button>
        </form>
    </div>
</body>
</html>
