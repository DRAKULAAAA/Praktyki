<?php
session_start();

if(isset($_POST['product_id'])) {
    
    if(!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }
    array_push($_SESSION['cart'], $_POST['product_id']);
}

header("Location: main.php");
exit();
?>
