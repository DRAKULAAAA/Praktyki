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
                session_start();

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

            <form action="usuwanieZKoszyka.php" method="post">
                <input type="hidden" name="remove_all" value="true">
                <button type="submit">Usuń wszystkie produkty z koszyka</button>
            </form>
        </div>
    </main>
</body>
</html>