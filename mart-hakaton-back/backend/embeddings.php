<?php

require 'vendor/autoload.php';

use Openai\Client;

$host = 'postgres-db'; // host также внутри контейнера
$port = '5432';  // Порт используется для подключения внутри контейнера
$dbname = 'hakaton_bd';
$user = 'user';
$password = 'user';

try {
    // Подключение к базе данных PostgreSQL
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";
    $pdo = new PDO($dsn, $user, $password);

    // Запрос для получения данных о лекциях
    $stmt = $pdo->query('SELECT id_lection, markdown_text_lection FROM lection');
    $lectures = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Ваш запрос пользователя
    $userQuery = "пример";

    // Создание клиента OpenAI
    $client = new Client('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
    ');

    // Генерируем эмбеддинги для каждой лекции
    $lectureEmbeddings = [];
    foreach ($lectures as $lecture) {
        $response = $client->embeddings()->create(['text' => $lecture['markdown_text_lection']]);
        $embedding = $response['embedding'];
        $lectureEmbeddings[$lecture['id_lection']] = $embedding;
    }

    // Генерируем эмбеддинг запроса пользователя
    $userQueryResponse = $client->embeddings()->create(['text' => $userQuery]);
    $userQueryEmbedding = $userQueryResponse['embedding'];

    // Находим наиболее похожую лекцию на основе косинусного сходства
    $highestSimilarity = -1;
    $closestLectureId = -1;
    foreach ($lectureEmbeddings as $id_lection => $lectureEmbedding) {
        $similarity = cosineSimilarity($lectureEmbedding, $userQueryEmbedding);
        if ($similarity > $highestSimilarity) {
            $highestSimilarity = $similarity;
            $closestLectureId = $id_lection;
        }
    }

    // Выводим наиболее подходящую лекцию
    if ($closestLectureId !== -1) {
        echo "Наиболее подходящая лекция:\n";
        echo "id_lection: $closestLectureId\n";
    } else {
        echo "Лекции не найдены.\n";
    }
} catch (PDOException $e) {
    echo 'Ошибка подключения к базе данных: ' . $e->getMessage();
}

// Функция для подсчета косинусного сходства между двумя векторами
function cosineSimilarity($vector1, $vector2)
{
    // Реализация функции остается без изменений
}
