<?php
session_start();
if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
    header("Location: administracja.php");
    exit();
}
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['login'];
    $password = $_POST['haslo'];
    $db = mysqli_connect('localhost','root','','sklep');
    if (!$db) {
        die("połączenie nie powiodło się: " . mysqli_connect_error());
    }
    $query = "INSERT INTO admin1 (login, haslo) VALUES ('$username', '$password')";
    if(mysqli_query($db, $query)) {
        $_SESSION['logged_in'] = true;
        $_SESSION['login'] = $username;
        header("Location: administracja.php");
        exit();
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($db);
    }
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style6.css">
    <title>Rejestracja</title>
</head>
<body>
<header><h2>Rejestracja</h2></header>
    <form method="post" action="">
        <label for="login">Nazwa użytkownika:</label><br>
        <input type="text" id="login" name="login" required><br>
        <label for="haslo">Hasło:</label><br>
        <input type="password" id="haslo" name="haslo" required><br><br>
        <input type="submit" value="Zarejestruj">
    </form>
</body>
</html>
