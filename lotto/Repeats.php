<?php
$connection = mysqli_connect('localhost', 'root', '', 'lotto');

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

$repeats = [];

echo "<h1>Pomyślnie obliczono i zapisano liczbę powtórzeń w bazie danych.</h1>";

for ($i = 1; $i <= 25; $i++) {
    $query = "SELECT COUNT(*) AS count FROM results WHERE $i IN (n1, n2, n3, n4, n5, n6)";
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_assoc($result);
    $repeats[$i] = $row['count'];

    $insertQuery = "INSERT INTO repeats (number, repeats) VALUES ($i, $repeats[$i])";
    mysqli_query($connection, $insertQuery);

    echo "Liczba $i wystąpiła $repeats[$i] razy.<br>";
}
mysqli_close($connection);
?>
