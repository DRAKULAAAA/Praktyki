<?php

$host = "localhost"; 
$username = "root"; 
$password = ""; 
$database = "formularz"; 

$conn = new mysqli($host, $username, $password, $database);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_do_usuniecia'])) {
    $id_do_usuniecia = $_POST['id_do_usuniecia'];

    $sql_usun = "DELETE FROM dane WHERE id = $id_do_usuniecia";
    if ($conn && $conn->query($sql_usun) !== TRUE) {
        die("Błąd podczas usuwania rekordu: " . $conn->error);
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
                    <input type='hidden' name='id_do_usuniecia' value='{$row['id']}'>
                    <input type='submit' value='Usuń'>
                </form>
            </td>
          </tr>";
}

echo "</table>";

$conn->close();
?>
