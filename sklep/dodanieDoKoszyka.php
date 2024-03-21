<?php
session_start();

if(isset($_POST['product_id']) && isset($_POST['quantity'])) {
    $productId = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    if(!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }

    for ($i = 0; $i < $quantity; $i++) {
        array_push($_SESSION['cart'], $productId);
    }
}

header("Location: main.php");
exit();
?>
