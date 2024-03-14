<?php
session_start();

if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
    header("Location: indeks.php");
    exit();
}
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['login'];
    $password = $_POST['haslo'];
    $db = mysqli_connect('localhost','root','','uzytkownicy');
    $query = "SELECT * FROM dane WHERE login='$username' AND haslo='$password'";
    $result = mysqli_query($db, $query);
    $count = mysqli_num_rows($result);
    if($count == 1) {
        $_SESSION['logged_in'] = true;
        $_SESSION['login'] = $username;
        header("Location:  indeks.php");
    } else {
        $error = "Błędny login lub hasło";
    }
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logowanie</title>
</head>
<body>
    <h2>Logowanie</h2>
    <?php
    if(isset($error)) {
        echo "<div>$error</div>";
    }
    ?>
    <form method="post" action="">
        <label for="login">Nazwa użytkownika:</label><br>
        <input type="text" id="login" name="login" required><br>
        <label for="haslo">Hasło:</label><br>
        <input type="password" id="haslo" name="haslo" required><br><br>
        <input type="submit" value="Zaloguj">
    </form>
    <p>Nie masz jeszcze konta? <a href="rejestracja.php">Zarejestruj się</a></p>
</body>
</html>