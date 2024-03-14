<?php
session_start();

// Sprawdzenie czy produkt został dodany do koszyka
if(isset($_POST['product_id'])) {
    // Dodanie produktu do tablicy koszyka w sesji
    if(!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }
    array_push($_SESSION['cart'], $_POST['product_id']);
}

// Przekierowanie do strony głównej po dodaniu produktu do koszyka
header("Location: main.php");
exit();
?>
