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
        throw new Exception("ID пользователя не указан в запросе.");
    }
    
    // SQL запрос для получения данных
    $sql = "SELECT DISTINCT last_view.id_user, last_view.date, last_view.id_lection, lection.title_lection, lection.subject_id, users.full_name_user
    FROM last_view
    INNER JOIN lection ON last_view.id_lection = lection.id_lection
    INNER JOIN users ON lection.id_user = users.id_user
    WHERE last_view.id_user = :id_user
    ORDER BY last_view.date DESC
    LIMIT 5";
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