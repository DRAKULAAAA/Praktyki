<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prognoza pogody</title>
    <link rel="stylesheet" href="style1.css">
</head>
<body>
    <h1>Prognoza pogody</h1>

    <form method="GET" action="">
        <label for="city">Wprowadź miasto:</label>
        <input type="text" id="city" name="city" required>
        <button type="submit">Sprawdź pogodę</button>
    </form>

    <div class="container">
        <!-- Tutaj będzie wyświetlana pogoda -->
    </div>

    <?php
    if(isset($_GET['city'])) {
        $city = urlencode($_GET['city']);
        $apiKey = "1bcb7b59a891321066c7ec4e2b6288d1";
        $forecastUrl = "https://api.openweathermap.org/data/2.5/forecast?q=$city&appid=$apiKey&units=metric";

        $forecastResponse = @file_get_contents($forecastUrl);
        if($forecastResponse === false) {
            echo "<p>Nie udało się połączyć z serwerem pogodowym. Spróbuj ponownie później.</p>";
            exit;
        }

        $forecastData = json_decode($forecastResponse, true);

        if(isset($forecastData['list'])) {
            echo "<h2>Prognoza pogody na przyszłe 6 dni dla $city:</h2>";
            echo "<div class='container'>";

            $previousDate = '';
            foreach ($forecastData['list'] as $item) {
                $date = date('Y-m-d', strtotime($item['dt_txt']));
                $temp = $item['main']['temp'];
                $feels_like = $item['main']['feels_like'];
                $min_temp = $item['main']['temp_min'];
                $max_temp = $item['main']['temp_max'];
                $humidity = $item['main']['humidity'];
                $pressure = $item['main']['pressure'];
                $weatherDesc = $item['weather'][0]['description'];
                $icon = $item['weather'][0]['icon'];
                $windSpeed = $item['wind']['speed'];

                if ($date !== $previousDate) {
                    echo "<div class='weather-card'>";
                    echo "<h3>$date</h3>";
                    echo "<img src='http://openweathermap.org/img/wn/$icon.png' alt='weather icon' class='weather-icon'>";
                    echo "<p>Opis pogody: $weatherDesc</p>";
                    echo "<p>Temperatura: $temp °C</p>";
                    echo "<p>Odczuwalna temperatura: $feels_like °C</p>";
                    echo "<p>Minimalna temperatura: $min_temp °C</p>";
                    echo "<p>Maksymalna temperatura: $max_temp °C</p>";
                    echo "<p>Wilgotność: $humidity%</p>";
                    echo "<p>Ciśnienie: $pressure hPa</p>";
                    echo "<p>Prędkość wiatru: $windSpeed m/s</p>";
                    echo "</div>";

                    $previousDate = $date;
                }
            }

            echo "</div>";
        } else {
            echo "<p>Nie udało się pobrać prognozy pogody dla podanego miasta.</p>";
        }
    }
    ?>
</body>
</html>
