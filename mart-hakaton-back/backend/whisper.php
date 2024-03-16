<?php
require_once 'vendor/autoload.php';

$text = '';

if (isset($_POST['submit'])) {
    // Путь к директории для загруженных файлов
    $uploadDirectory = '';
    
    // Полный путь к файлу в директории для загрузки
    $targetFile = $uploadDirectory . basename($_FILES["fileToUpload"]["name"]);

    // Перемещаем файл в директорию для загрузки
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile)) {
        echo "Файл ". basename( $_FILES["fileToUpload"]["name"]). " успешно загружен.";
    } else {
        echo "Произошла ошибка при загрузке файла.";
    }

    // API ключ
    $yourApiKey = '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';
    $client = OpenAI::client($yourApiKey);

    // Используем путь к загруженному файлу вместо жестко закодированного пути
    $response = $client->audio()->transcribe([
        'model' => 'whisper-1',
        'file' => fopen($targetFile, 'r'), // Путь к загруженному файлу
        'response_format' => 'verbose_json',
    ]);

    foreach ($response->segments as $segment) {
        $text .= $segment->text;
    }

    // Запись текста в файл text.txt
    file_put_contents('text.txt', $text);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Upload</title>
</head>
<body>
    <form method="post" enctype="multipart/form-data">
        <input type="file" name="fileToUpload" id="fileToUpload">
        <br>
        <input type="submit" name="submit" value="Submit"> <!-- Добавлено имя кнопки "submit" -->
        <p><?php echo $text; ?></p>
    </form>
</body>
</html>
