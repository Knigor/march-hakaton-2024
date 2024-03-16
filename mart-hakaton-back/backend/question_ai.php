<?php

// Подключение к базе данных
$dsn = 'pgsql:host=postgres-db;dbname=hakaton_bd';
$username = 'user';
$password = 'user';

try {
    $dbconn = new PDO($dsn, $username, $password);
} catch (PDOException $e) {
    die("Ошибка подключения к базе данных: " . $e->getMessage());
}

// Установка режима обработки ошибок для PDO
$dbconn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Получение текста лекции из базы данных
$id_lection = $_POST['id_lection']; // Предполагается, что идентификатор лекции передается в POST-запросе
$query = "SELECT markdown_text_lection FROM lection WHERE id_lection = ?";
$stmt = $dbconn->prepare($query);
$stmt->execute([$id_lection]);

$row = $stmt->fetch(PDO::FETCH_ASSOC);
$markdown_text_lection = $row['markdown_text_lection'];

// Отправка запроса к API ChatGPT
$question = $_POST['question']; // Предполагается, что вопрос передается в POST-запросе
$api_url = 'https://api.openai.com/v1/chat/completions'; // Обновляем эндпоинт для чат-моделей
$api_key = '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'; // Замените YOUR_API_KEY на ваш API ключ от OpenAI

$data = array(
    'model' => 'gpt-3.5-turbo', // Добавляем параметр модели
    'messages' => array(
        array(
            'role' => 'system',
            'content' => 'User: ' . $markdown_text_lection . "\n" . 'Исходя из этого текста ' . $question,
        )
    ),

);

$curl = curl_init($api_url);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($curl, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Authorization: Bearer ' . $api_key
));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($curl);
curl_close($curl);

// Получаем ответ от API ChatGPT
$response_data = json_decode($response, true);

// Получаем содержимое ответа из поля content
$answer_content = $response_data['choices'][0]['message']['content'];

// Запись данных в базу данных
$id_user = $_POST['id_user']; // Предполагается, что идентификатор пользователя передается в POST-запросе
$data_question = date('Y-m-d H:i:s'); // Текущая дата и время

// Записываем данные в таблицу questions
$query = "INSERT INTO questions (id_user, id_lection, text_questions, answer_questions, data_questions) VALUES (?, ?, ?, ?, ?)";
$stmt = $dbconn->prepare($query);
$stmt->execute([$id_user, $id_lection, $question, $answer_content, $data_question]);

// Возвращаем ответ от API ChatGPT
echo $response;

// Закрытие соединения с базой данных
$dbconn = null;

?>
