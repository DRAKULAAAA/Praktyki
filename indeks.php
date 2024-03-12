<?php
session_start();

if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header("Location: logowanie.php");
    exit();
}

$username = $_SESSION['login'];

$conn = mysqli_connect('localhost', 'root', '', 'formularz');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $imie = $_POST['imie'];
    $nazwisko = $_POST['nazwisko'];
    $email = $_POST['email'];
    $telefon = $_POST['telefon'];

    if (empty($imie) || empty($nazwisko) || empty($email) || empty($telefon)) {
        $message = "Wszystkie pola formularza są wymagane!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Niepoprawny format adresu e-mail!";
    } else {
        $targetDirectory = "uploads/";
        $targetFile = $targetDirectory . basename($_FILES["zdjecia"]["name"]);

        if (move_uploaded_file($_FILES["zdjecia"]["tmp_name"], $targetFile)) {
            $img = basename($_FILES["zdjecia"]["name"]);
            $sql = "INSERT INTO dane (imie, nazwisko, email, telefon, zdjecia) VALUES ('$imie', '$nazwisko', '$email', '$telefon', '$img')";
            $query = mysqli_query($conn, $sql);

            $message = $query ? "Formularz został pomyślnie wysłany!" : "Błąd przy przetwarzaniu formularza. Spróbuj ponownie.";
        } else {
            $message = "Wystąpił błąd podczas przesyłania pliku.";
        }
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Formularz</title>
</head>
<body>
    <div class="container">

    <header>
        <h1>Formularz kontaktowy</h1>
    
            <a href="wylogowanie.php">Wyloguj</a>
            <a href="podstrona.php">Usuń</a>
            <a href="update.php">Zaktualizuj</a>
   
    </header>
        
        <h2>Cześć, <?php echo $username; ?></h2>

       <?php if (isset($message)) echo "<p style='color: " . ($query ? "green" : "red") .  ";'>$message</p>"; ?>

        <form action="indeks.php" method="post" enctype="multipart/form-data">
            <label for="imie">Imię:</label>
            <input type="text" id="imie" name="imie">
            <br>
            <label for="nazwisko">Nazwisko:</label>
            <input type="text" id="nazwisko" name="nazwisko">
            <br>
            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email">
            <br>
            <label for="telefon">Numer telefonu:</label>
            <input type="tel" id="telefon" name="telefon">
            <br>
            <label for="zdjecia">Zdjęcia:</label>
            <input type="file" id="zdjecia" name="zdjecia" accept="image/*">
            <br>
            <input type="submit" value="Wyślij">
        </form>       
    </div>
</body>
</html>
