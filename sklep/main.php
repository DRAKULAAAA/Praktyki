<?php  
    session_start();
    $user = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true;
?>

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
        <h2 id="lgn"><?php echo $user ? '<a href="wylogowanie.php">Wyloguj się</a>' : '<a href="login.php">Zaloguj się</a>'; ?></h2>
    </header>

    <main>
    
        <div id="products-list">
            <?php  
            $conn = mysqli_connect('localhost', 'root', '', 'sklep');
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }
            
            $sql = "SELECT * FROM produkty";
            $result = mysqli_query($conn, $sql);
            
            if (mysqli_num_rows($result) > 0) {
                while($product = mysqli_fetch_assoc($result)) {
                    echo '<div class="product" id="product_' . $product['id'] . '">';
                    if (!empty($product['zdjecie'])) {
                        echo '<img src="' . $product['zdjecie'] . '" alt="' . $product['nazwa_produktu'] . '">';
                    }
                    echo '<h2>' . $product['nazwa_produktu'] . '</h2>';
                    echo '<p>' . $product['opis'] . '</p>';
                    echo '<p>Cena: ' . $product['cena'] . ' PLN</p>';
                    
                    if ($user) {
                        echo '<form action="dodanieDoKoszyka.php" method="post">';
                        echo '<input type="hidden" name="product_id" value="' . $product['id'] . '">';
                        echo '<div class="quantity-input">';
                        echo '<label for="quantity_' . $product['id'] . '">Ilość:</label>';
                        echo '<input type="number" name="quantity" id="quantity_' . $product['id'] . '" value="1" min="1">';
                        echo '</div>';
                        echo '<button type="submit">Dodaj do koszyka</button>';
                        echo '</form>';
                    } else {
                        echo '<p>Zaloguj się, aby dodać item do koszyka.</p>';
                    }
                    
                    echo '</div>';
                }
            } else {
                echo "Brak produktów w bazie danych.";
            }
            
            mysqli_close($conn);
            ?>
        </div>
        <script src="script.js"></script>
    </main>
</body>
</html>
