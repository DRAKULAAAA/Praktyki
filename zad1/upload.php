<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $uploadDir = 'uploads/';

    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $targetFile = $uploadDir . basename($_FILES['image']['name']);
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Walidacja rozmiaru pliku (max 1MB)
    if ($_FILES['image']['size'] > 1024 * 1024) {
        echo json_encode(['success' => false, 'message' => 'Rozmiar pliku przekracza 1MB. Wybierz mniejsze zdjęcie.']);
        exit();
    }

    // Walidacja typu MIME (sprawdzanie, czy to obraz)
    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
    if (!in_array($imageFileType, $allowedTypes)) {
        echo json_encode(['success' => false, 'message' => 'Wybrany plik nie jest obrazem. Wybierz plik z rozszerzeniem obrazu.']);
        exit();
    }

    $imageData = file_get_contents($_FILES['image']['tmp_name']);

    // Zapisanie danych do bazy danych
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "formularz";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Użyj prepared statements, aby uniknąć błędów związanych z nazwą tabeli
    $stmt = $conn->prepare("INSERT INTO dane (zdjecia) VALUES (?)");
    $stmt->bind_param("b", $imageData);

    if ($stmt->execute()) {
        // Pobierz ostatni dodany ID, jeśli potrzebujesz
        $lastInsertId = $conn->insert_id;

        echo json_encode(['success' => true, 'lastInsertId' => $lastInsertId]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Wystąpił błąd podczas zapisywania zdjęcia.']);
    }

    $stmt->close();
    $conn->close();
} else {
    header('Location: indeks.html');
}
?>
