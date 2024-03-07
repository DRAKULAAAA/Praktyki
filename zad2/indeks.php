<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Formularz z uploadem zdjęcia</title>
</head>
<body>
  <form action="upload.php" method="post" enctype="multipart/form-data">
    <label for="imageUpload">Wybierz zdjęcie (max 1MB):</label>
    <input type="file" id="imageUpload" name="image" accept="image/*" required>
    <button type="submit">Zapisz zdjęcie</button>
  </form>

  <div id="imagePreview"></div>
</body>
</html>