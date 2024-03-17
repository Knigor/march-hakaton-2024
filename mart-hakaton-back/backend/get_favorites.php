<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: http://localhost:5173');
header('Access-Control-Allow-Headers: Content-Type');
header('Access-Control-Allow-Methods: POST');

// Параметры подключения к базе данных PostgreSQL
$dbhost = 'postgres-db';
$dbname = 'hakaton_bd';
$dbuser = 'user';
$dbpass = 'user';

header('Content-Type: application/json');

try {
    // Подключение к базе данных
    $pdo = new PDO("pgsql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
    
    // Устанавливаем режим выброса исключений
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Получение id_user из POST запроса
    if(isset($_POST['id_user'])) {
        $id_user = $_POST['id_user'];
    } else {
        throw new Exception("ID пользователя не указан в запросе. Переданные параметры: " . json_encode($_POST));
    }
    
    // SQL запрос для получения данных
    $sql = "SELECT DISTINCT favorites.id_user, favorites.id_lection, lection.title_lection, lection.subject_id, users.full_name_user, subject.name_item
            FROM favorites
            INNER JOIN lection ON favorites.id_lection = lection.id_lection
            INNER JOIN users ON lection.id_user = users.id_user
            INNER JOIN subject ON lection.subject_id = subject.id_user
            WHERE favorites.id_user = :id_user";
    
    // Подготовка SQL запроса
    $stmt = $pdo->prepare($sql);
    
    // Привязка параметров
    $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
    
    // Выполнение запроса
    $stmt->execute();
    
    // Получение результатов
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Вывод результатов в формате JSON
    echo json_encode($results);
    
} catch(PDOException $e) {
    // Обработка ошибок
    echo json_encode(array("error" => "Ошибка базы данных: " . $e->getMessage()));
} catch(Exception $e) {
    // Обработка ошибок
    echo json_encode(array("error" => $e->getMessage()));
}

// Закрываем соединение
unset($pdo);
?>