<?php
session_start();

if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header("Location: logowanie.php");
    exit();
}

$conn = mysqli_connect('localhost', 'root', '', 'formularz');

// Pobierz dane z bazy danych
$sql = "SELECT id, imie, nazwisko, email, telefon, zdjecia FROM dane";
$result = mysqli_query($conn, $sql);

$data = array();

while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

// Zamknij połączenie z bazą danych
mysqli_close($conn);

// Zwróć dane jako JSON
echo json_encode($data);
?>
