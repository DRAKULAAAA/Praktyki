<?php
session_start();

if(isset($_POST['product_id'])) {
    $productId = $_POST['product_id'];
    
    if(isset($_SESSION['cart'])) {
        $key = array_search($productId, $_SESSION['cart']);
        if($key !== false) {
            unset($_SESSION['cart'][$key]);
        }
    }
}

elseif(isset($_POST['remove_all'])) {
    unset($_SESSION['cart']);
}

header("Location: koszyk.php");
exit();
?>