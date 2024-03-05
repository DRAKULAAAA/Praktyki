<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "formularz";

$conn = new mysqli($host, $username, $password, $database);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_do_edycji'])) {
    $id_do_edycji = $_POST['id_do_edycji'];

    $sql_select = "SELECT id, imie, nazwisko, email, telefon FROM dane WHERE id = $id_do_edycji";
    $result_select = $conn->query($sql_select);

    if ($result_select && $row_select = $result_select->fetch_assoc()) {
        $imie = $row_select['imie'];
        $nazwisko = $row_select['nazwisko'];
        $email = $row_select['email'];
        $telefon = $row_select['telefon'];
    } else {
        die("Błąd podczas pobierania danych do edycji: " . $conn->error);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $id_do_edycji = $_POST['id_do_edycji'];
    $imie = $_POST['imie'];
    $nazwisko = $_POST['nazwisko'];
    $email = $_POST['email'];
    $telefon = $_POST['telefon'];

    $sql_update = "UPDATE dane SET imie = '$imie', nazwisko = '$nazwisko', email = '$email', telefon = '$telefon' WHERE id = $id_do_edycji";
    
    if ($conn && $conn->query($sql_update) !== TRUE) {
        die("Błąd podczas aktualizacji rekordu: " . $conn->error);
    }
}

$sql = "SELECT id, imie, nazwisko, email, telefon FROM dane";
$result = $conn->query($sql);

echo "<table border='1'>
<tr>
<th>ID</th>
<th>Imię</th>
<th>Nazwisko</th>
<th>Email</th>
<th>Telefon</th>
<th>Edytuj</th>
<th>Usuń</th>
</tr>";

while ($row = $result->fetch_assoc()) {
    echo "<tr>
            <td>{$row['id']}</td>
            <td>{$row['imie']}</td>
            <td>{$row['nazwisko']}</td>
            <td>{$row['email']}</td>
            <td>{$row['telefon']}</td>
            <td>
                <form method='post' action='{$_SERVER['PHP_SELF']}'>
                    <input type='hidden' name='id_do_edycji' value='{$row['id']}'>
                    <input type='submit' value='Edytuj'>
                </form>
            </td>
            <td>
                <form method='post' action='{$_SERVER['PHP_SELF']}'>
                    <input type='hidden' name='id_do_usuniecia' value='{$row['id']}'>
                    <input type='submit' value='Usuń'>
                </form>
            </td>
          </tr>";
}

echo "</table>";

if (isset($id_do_edycji)) {
    echo "<h2>Edycja rekordu</h2>
        <form method='post' action='{$_SERVER['PHP_SELF']}'>
            <input type='hidden' name='id_do_edycji' value='$id_do_edycji'>
            Imię: <input type='text' name='imie' value='$imie'><br>
            Nazwisko: <input type='text' name='nazwisko' value='$nazwisko'><br>
            Email: <input type='text' name='email' value='$email'><br>
            Telefon: <input type='text' name='telefon' value='$telefon'><br>
            <input type='submit' name='update' value='Aktualizuj'>
        </form>";
}

$conn->close();
?>