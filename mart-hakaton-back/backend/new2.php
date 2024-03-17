<?php
require_once 'vendor/autoload.php';

// Создаем массив для ответа в формате JSON
$response = array();

if (isset($_POST['submit'])) {
    // Путь к директории для загруженных файлов
    $uploadDirectory = '';

    // Полный путь к файлу в директории для загрузки
    $targetFile = $uploadDirectory . basename($_FILES["fileToUpload"]["name"]);

    // Перемещаем файл в директорию для загрузки
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile)) {
        $response['status'] = 'success';
        $response['message'] = "Файл " . basename($_FILES["fileToUpload"]["name"]) . " успешно загружен.";
    } else {
        $response['status'] = 'error';
        $response['message'] = "Произошла ошибка при загрузке файла.";
    }

    // Определение типа файла
    $fileType = mime_content_type($targetFile);

    if ($fileType === 'text/plain') {
        // Если файл текстовый, считываем его содержимое
        $text = file_get_contents($targetFile);
    } elseif (strpos($fileType, 'audio/') === 0) {
        // Если файл аудио, используем Whisper API для преобразования аудио в текст
        $yourApiKey = getenv('OPENAI_API_KEY');
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
    } else {
        $response['status'] = 'error';
        $response['message'] = "Неподдерживаемый тип файла.";
    }

    // Подключение к базе данных PostgreSQL
    $dsn = 'pgsql:host=postgres-db;dbname=hakaton_bd';
    $username = 'user';
    $password = 'user';

    try {
        $pdo = new PDO($dsn, $username, $password);
    } catch (PDOException $e) {
        $response['status'] = 'error';
        $response['message'] = 'Ошибка подключения к базе данных: ' . $e->getMessage();
        echo json_encode($response);
        exit();
    }

    // Подготовка запроса для вставки данных в базу данных
    $stmt = $pdo->prepare("INSERT INTO lection (markdown_text_lection, subject_id, id_user, title_lection) VALUES (:markdown_text, :subject_id, :id_user, :title_lection)");

    // Привязка параметров и выполнение запроса
    $stmt->bindParam(':markdown_text', $text);
    $stmt->bindParam(':subject_id', $subject_id);
    $stmt->bindParam(':id_user', $id_user);
    $stmt->bindParam(':title_lection', $title_lection);

    // Устанавливаем значения для новых параметров
    $subject_id = 1; // Значение для subject_id
    $id_user = 1;    // Значение для id_user
    $title_lection = "Название лекции"; // Значение для title_lection

    $stmt->execute();

    $response['database_status'] = 'success';
    $response['database_message'] = 'Текст успешно сохранен в базе данных.';
}

// Выводим ответ в формате JSON
echo json_encode($response);
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
        <input type="submit" name="submit" value="Submit">
        <p><?php echo $text; ?></p>
    </form>
</body>
</html>