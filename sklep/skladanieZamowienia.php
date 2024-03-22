<?php
session_start();

if(isset($_POST['platnosc']) && isset($_POST['wysylka']) && isset($_POST['adres']) && isset($_POST['imie']) && isset($_POST['nazwisko']) && isset($_POST['email']) && isset($_POST['telefon'])) {
    $platnosc = $_POST['platnosc'];
    $wysylka = $_POST['wysylka'];
    $adres = $_POST['adres'];
    $imie = $_POST['imie'];
    $nazwisko = $_POST['nazwisko'];
    $email = $_POST['email'];
    $telefon = $_POST['telefon'];

    $conn = mysqli_connect('localhost', 'root', '', 'sklep');
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    $userId = 1; 

    $sql = "INSERT INTO zamowienia (user_id, platnosc, wysylka, adres_dostawy, imie, nazwisko, email, telefon) 
            VALUES ('$userId', '$platnosc', '$wysylka', '$adres', '$imie', '$nazwisko', '$email', '$telefon')";
    if (mysqli_query($conn, $sql)) {
        $orderId = mysqli_insert_id($conn);

        if(isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
            foreach($_SESSION['cart'] as $productId) {
                $productId = (int)$productId; 
                $sql = "INSERT INTO zamowienia_produkty (zamowienie_id, produkt_id) VALUES ('$orderId', '$productId')";
                mysqli_query($conn, $sql);
            }
        }

        unset($_SESSION['cart']);

        mysqli_close($conn);

        header("Location: main.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
?>
