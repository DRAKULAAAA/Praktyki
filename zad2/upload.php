<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $uploadDir = 'uploads/';

    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $targetFile = $uploadDir . basename($_FILES['image']['name']);
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

   
    if ($_FILES['image']['size'] > 1024 * 1024) {
        echo json_encode(['success' => false, 'message' => 'Rozmiar pliku przekracza 1MB. Wybierz mniejsze zdjęcie.']);
        exit();
    }

   
    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
    if (!in_array($imageFileType, $allowedTypes)) {
        echo json_encode(['success' => false, 'message' => 'Wybrany plik nie jest obrazem. Wybierz plik z rozszerzeniem obrazu.']);
        exit();
    }

    if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
        $imageBase64 = base64_encode(file_get_contents($targetFile));

        echo json_encode(['success' => true, 'imageBase64' => $imageBase64]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Wystąpił błąd podczas zapisywania zdjęcia.']);
    }
} else {
    header('Location: indeks.php');
}
?>