<?php
require_once 'vendor/autoload.php';

// Создаем массив для ответа в формате JSON
$response = array();

$text = ""; // Переменная для хранения Markdown текста
$subject_id = isset($_POST['subject_id']) ? $_POST['subject_id'] : null;
$id_user = isset($_POST['id_user']) ? $_POST['id_user'] : null;
$title_lection = isset($_POST['title_lection']) ? $_POST['title_lection'] : null;

if (isset($_POST['submit'])) {
    // Путь к директории для загруженных файлов
    $uploadDirectory = '';

    // Полный путь к файлу в директории для загрузки
    $targetFile = $uploadDirectory . basename($_FILES["fileToUpload"]["name"]);

    // Перемещаем файл в директорию для загрузки
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile)) {
        $response['status'] = 'success';
        $response['message'] = "Файл " . basename($_FILES["fileToUpload"]["name"]) . " успешно загружен.";

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
            $responseAudio = $client->audio()->transcribe([
                'model' => 'whisper-1',
                'file' => fopen($targetFile, 'r'), // Путь к загруженному файлу
                'response_format' => 'verbose_json',
            ]);

            foreach ($responseAudio->segments as $segment) {
                $text .= $segment->text;
            }
        } else {
            $response['status'] = 'error';
            $response['message'] = "Неподдерживаемый тип файла.";
            echo json_encode($response);
            exit();
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

        // Получение векторов от OpenAI API
        $sk = getenv('OPENAI_API_KEY');
        $data = array(
            'model' => 'text-embedding-ada-002',
            'input' => $text
        );
        $data_string = json_encode($data);
        $ch = curl_init('https://api.openai.com/v1/embeddings');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . $sk
        ));
        $result = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($result, true); // Распарсим JSON-ответ
        $vector_text = $result['data'][0]['embedding']; // Извлекаем векторы

        // Преобразование массива в строку JSON
        $vector_text_json = json_encode($vector_text);

        // Подготовка запроса для вставки данных в базу данных
        $stmt = $pdo->prepare("INSERT INTO lection (markdown_text_lection, vector_text, subject_id, id_user, title_lection) VALUES (:markdown_text, :vector_text, :subject_id, :id_user, :title_lection)");

        // Привязка параметров и выполнение запроса
        $stmt->bindParam(':markdown_text', $text);
        $stmt->bindParam(':vector_text', $vector_text_json); // Привязываем переменную для векторов
        $stmt->bindParam(':subject_id', $subject_id);
        $stmt->bindParam(':id_user', $id_user);
        $stmt->bindParam(':title_lection', $title_lection);

        // Устанавливаем значения для новых параметров
        // Эти значения мы получаем из формы
        // $subject_id = ...;
        // $id_user = ...;
        // $title_lection = ...;

        $stmt->execute();

        // Получение последнего вставленного идентификатора
        $id_lection = $pdo->lastInsertId();

        $response['database_status'] = 'success';
        $response['database_message'] = 'Текст успешно сохранен в базе данных.';
        $response['id_lection'] = $id_lection; // Добавляем id_lection в ответ.
    } else {
        $response['status'] = 'error';
        $response['message'] = "Произошла ошибка при загрузке файла.";
    }

    // Добавляем текст в JSON-ответ
    $response['text'] = $text;

    // Выводим ответ в формате JSON
    echo json_encode($response);
    exit(); // Завершаем выполнение скрипта после отправки ответа
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
        <input type="text" name="subject_id" placeholder="Subject ID">
        <input type="text" name="id_user" placeholder="User ID">
        <input type="text" name="title_lection" placeholder="Lection Title">
        <br>
        <input type="submit" name="submit" value="Submit">
        <p><?php echo htmlspecialchars($text); ?></p>
    </form>
</body>
</html>
