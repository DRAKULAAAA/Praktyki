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
                <h1>Formularz kontaktowy</h1>
        <form action="indeks.php" method="post">
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
            <input type="submit" value="Wyślij">
          </form>

          <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
            if (empty($_POST['imie']) || empty($_POST['nazwisko']) || empty($_POST['email']) || empty($_POST['telefon'])) {
                echo "<p style='color: red;'>Wszystkie pola formularza są wymagane!</p>";
            } else {
                
                if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                    echo "<p style='color: red;'>Niepoprawny format adresu e-mail!</p>";
                } else {
                    $conn = mysqli_connect('localhost', 'root', '', 'Formularz');
                    $imie =  $_POST['imie'];
                    $nazwisko =  $_POST['nazwisko'];
                    $email = $_POST['email'];
                    $telefon =  $_POST['telefon'];

                    $sql = "INSERT INTO Dane (imie, nazwisko, email, telefon) VALUES ('$imie', '$nazwisko', '$email', '$telefon')";
                    $query = mysqli_query($conn, $sql);

                    if ($query) {
                        echo "<p style='color: green;'>Formularz został pomyślnie wysłany!</p>";
                    } else {
                        echo "<p style='color: red;'>Błąd przy przetwarzaniu formularza. Spróbuj ponownie.</p>";
                    }

                    mysqli_close($conn);
                }
            }
        }
        ?>
        </div>
</body>
</html>