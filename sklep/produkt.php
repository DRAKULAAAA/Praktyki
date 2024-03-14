<?php
 $connect = mysqli_connect("localhost", "root", "", "sklep");
 $r = mysqli_query($connect, "SELECT * FROM `produkty`");

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM produkty WHERE id = ?");
    $stmt->execute([$id]);
    $produkt = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    header("Location: main.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title><?php echo $produkt['name']; ?></title>
</head>
<body>
    <container>
        <header>
            <h2><a href="main.php">Sklep</a></h2>
            <h2 id="mid"><?php echo $produkt['name']; ?></h2>
            <h2 id="right"><a href="cart.php">Koszyk</a></h2>
        </header>
        <div class="product-details">
            <img src="<?php echo $produkt['zdjecie']; ?>" alt="<?php echo $produkt['nazwa_produktu']; ?>">
            <h3><?php echo $produkt['name']; ?></h3>
            <p><?php echo $produkt['description']; ?></p>
            <p>Cena: <?php echo $produkt['price']; ?> PLN</p>
            <form action="addToCart.php" method="post">
                <input type="hidden" name="produkt_id" value="<?php echo $produkt['id']; ?>">
                <label for="quantity">Ilość:</label>
                <input type="number" id="quantity" name="quantity" value="1" min="1">
                <button type="submit">Dodaj do koszyka</button>
            </form>
        </div>
    </container>
</body>
</html>
