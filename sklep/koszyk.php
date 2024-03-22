<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Koszyk</title>
    <link rel="stylesheet" href="style4.css">
</head>
<body>
    <header>
        <h2><a href="koszyk.php">Koszyk</a></h2>
        <h2 id="mid">Zawartość koszyka</h2>
        <h2 id="right"><a href="main.php">Wróć do sklepu</a></h2>
    </header>

    <main>
        <div id="cart">
            <h3>Zawartość koszyka:</h3>
            <ul class="product-list">
                <?php
                $conn = mysqli_connect('localhost', 'root', '', 'sklep');
                if (!$conn) {
                    die("Connection failed: " . mysqli_connect_error());
                }

                if(isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
                    foreach($_SESSION['cart'] as $productId) {
                        $productId = (int)$productId; 
                        $sql = "SELECT * FROM produkty WHERE id = $productId";
                        $result = mysqli_query($conn, $sql);
                        if(mysqli_num_rows($result) > 0) {
                            $product = mysqli_fetch_assoc($result);
                            echo '<li class="product-item">';
                            if (!empty($product['zdjecie'])) {
                                echo '<img src="' . $product['zdjecie'] . '" alt="' . ($product['nazwa_produktu']) . '" style="width: 100px; height: 100px;">';
                            }
                          
                            echo '<div class="produkt">' . $product['nazwa_produktu'] . ', Cena: ' . $product['cena'] . ' PLN</div>';
                            echo '<form action="usuwanieZKoszyka.php" method="post">';
                            echo '<input type="hidden" name="product_id" value="' . $productId . '">';
                            echo '<button type="submit">Usuń</button>';
                            echo '</form>';
                            echo '</li>';
                        }
                    }
                } else {
                    echo '<li>Koszyk jest pusty.</li>';
                }

                mysqli_close($conn);
                ?>
            </ul>

            <form action="skladanieZamowienia.php" method="post">
                <h3>Składanie zamówienia:</h3>
                <label for="platnosc">Wybierz sposób płatności:</label><br>
                <input type="radio" id="przelew" name="platnosc" value="przelew" checked>
                <label for="przelew">Przelew</label><br>
                <input type="radio" id="karta" name="platnosc" value="karta">
                <label for="karta">Karta płatnicza</label><br>
                <input type="radio" id="gotowka" name="platnosc" value="gotowka">
                <label for="gotowka">Gotówka przy odbiorze</label><br><br>

                <label for="wysylka">Wybierz sposób wysyłki:</label><br>
                <input type="radio" id="kurier" name="wysylka" value="kurier" checked>
                <label for="kurier">Kurier</label><br>
                <input type="radio" id="poczta" name="wysylka" value="poczta">
                <label for="poczta">Poczta</label><br>
                <input type="radio" id="osobisty" name="wysylka" value="osobisty">
                <label for="osobisty">Odbiór osobisty</label><br><br>

                <label for="adres">Adres dostawy:</label><br>
                <textarea name="adres" id="adres" rows="4" cols="50"></textarea><br><br>

                <label for="imie">Imię:</label><br>
                <input type="text" id="imie" name="imie"><br><br>

                <label for="nazwisko">Nazwisko:</label><br>
                <input type="text" id="nazwisko" name="nazwisko"><br><br>

                <label for="email">Email:</label><br>
                <input type="email" id="email" name="email"><br><br>

                <label for="telefon">Telefon:</label><br>
                <input type="tel" id="telefon" name="telefon"><br><br>

                <button type="submit">Złóż zamówienie</button>
            </form>
        </div>
    </main>
</body>
</html>
