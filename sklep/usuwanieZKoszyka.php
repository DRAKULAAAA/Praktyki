<?php
session_start();

// Usunięcie pojedynczego produktu z koszyka
if(isset($_POST['product_id'])) {
    $productId = $_POST['product_id'];
    
    if(isset($_SESSION['cart'])) {
        $key = array_search($productId, $_SESSION['cart']);
        if($key !== false) {
            unset($_SESSION['cart'][$key]);
        }
    }
}

// Usunięcie wszystkich produktów z koszyka
elseif(isset($_POST['remove_all'])) {
    unset($_SESSION['cart']);
}

header("Location: koszyk.php");
exit();
?>
