<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sklep internetowy</title>
    <link rel="stylesheet" href="style3.css">
</head>
<body>
    <header>
        <h2><a href="main.php">Sklep</a></h2>
        <h2 id="mid">Produkty</h2>
        <h2 id="right"><a href="koszyk.php">Koszyk</a></h2>
    </header>

    <main>
        <div id="products-list">
            <?php
            session_start(); 

            $conn = mysqli_connect('localhost', 'root', '', 'sklep');
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }
            
            $sql = "SELECT * FROM produkty";
            $result = mysqli_query($conn, $sql);
            
            if (mysqli_num_rows($result) > 0) {
                while($product = mysqli_fetch_assoc($result)) {
                    echo '<div class="product">';
                    if (!empty($product['zdjecie'])) {
                        echo '<img src="' . $product['zdjecie'] . '" alt="' . $product['nazwa_produktu'] . '">';
                    }
                    echo '<h2>' . $product['nazwa_produktu'] . '</h2>';
                    echo '<p>' . $product['opis'] . '</p>';
                    echo '<p>Cena: ' . $product['cena'] . ' PLN</p>';
                    echo '<form action="dodanieDoKoszyka.php" method="post">';
                    echo '<input type="hidden" name="product_id" value="' . $product['id'] . '">';
                    echo '<button type="submit">Dodaj do koszyka</button>';
                    echo '</form>';
                    echo '</div>';
                }
            } else {
                echo "Brak produktów w bazie danych.";
            }
            
            mysqli_close($conn);
            ?>
        </div>
    </main>
    <script src="script.js"></script>
</body>
</html>
