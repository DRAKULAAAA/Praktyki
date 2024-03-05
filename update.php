<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "formularz";

    $conn = new mysqli($host, $username, $password, $database);

    if ($conn->connect_error) {
        die("Błąd połączenia z bazą danych: " . $conn->connect_error);
    }

    $id_to_delete = $_POST["id"];

    // Validate the ID to prevent SQL injection
    $id_to_delete = intval($id_to_delete);

    $query = "DELETE FROM dane WHERE id = $id_to_delete";

    if ($conn->query($query) === TRUE) {
        echo "Rekord został pomyślnie usunięty.";
    } else {
        echo "Błąd podczas usuwania rekordu: " . $conn->error;
    }

    $conn->close();
}
?>
