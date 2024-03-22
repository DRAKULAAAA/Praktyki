<?php
session_start();


if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: loginAdmin.php"); 
    exit();
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Panel administracyjny</title>
    <link rel="stylesheet" href="style7.css">
</head>
<body>
    <header>
        <h3 class="login"><a href="wylogowanieAdmin.php">Wyloguj</a></h3> 
    </header>

    <div class="container">
        <h1>Produkty:</h1>
        <table>
            <tr>
                <th>ID</th>
                <th>Nazwa</th>
                <th>Cena</th>
                <th>Opis</th>
                <th>Akcje</th>
            </tr>
            <?php
            $connect = mysqli_connect("localhost", "root", "", "sklep");

            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_edit_item'])) {
                $id = $_POST['product_id'];
                $nazwa = $_POST['nazwa'];
                $cena = $_POST['cena'];
                $opis = $_POST['opis'];

                $update_query = "UPDATE produkty SET nazwa_produktu='$nazwa', cena='$cena', opis='$opis' WHERE id=$id";
                mysqli_query($connect, $update_query);
            }

            $select_query = "SELECT * FROM produkty";
            $result = mysqli_query($connect, $select_query);
            while ($row = mysqli_fetch_assoc($result)) :
            ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['nazwa_produktu']; ?></td>
                <td><?php echo $row['cena']; ?></td>
                <td><?php echo $row['opis']; ?></td>
                <td>
                    <form method="post" action="">
                        <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                        <input type="text" name="nazwa" value="<?php echo $row['nazwa_produktu']; ?>" placeholder="Nazwa">
                        <input type="text" name="cena" value="<?php echo $row['cena']; ?>" placeholder="Cena">
                        <textarea name="opis" placeholder="Opis"><?php echo $row['opis']; ?></textarea>
                        <input type="submit" name="submit_edit_item" value="Zapisz zmiany">
                    </form>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>
