<?php
// Подключение к базе данных PostgreSQL
$dsn = 'pgsql:host=postgres-db;dbname=hakaton_bd';
$username = 'user';
$password = 'user';

try {
    $pdo = new PDO($dsn, $username, $password);
} catch (PDOException $e) {
    // Обработка ошибки подключения к базе данных
    http_response_code(500);
    echo json_encode(array("message" => "Ошибка подключения к базе данных: " . $e->getMessage()));
    exit();
}

// Проверка, были ли переданы необходимые данные
if (!isset($_POST['id_lection']) || !isset($_POST['id_user'])) {
    // Если данные не были переданы, возвращаем ошибку
    http_response_code(400);
    echo json_encode(array("message" => "Необходимо передать id_lection и id_user"));
    exit();
}

// Получаем значения id_lection и id_user из POST запроса
$id_lection = $_POST['id_lection'];
$id_user = $_POST['id_user'];

// Подготовка запроса для удаления записи из таблицы favorites
$stmt = $pdo->prepare("DELETE FROM favorites WHERE id_lection = :id_lection AND id_user = :id_user");

// Привязка параметров и выполнение запроса
$stmt->bindParam(':id_lection', $id_lection);
$stmt->bindParam(':id_user', $id_user);

if ($stmt->execute()) {
    // Если запрос выполнен успешно, возвращаем успешный ответ
    http_response_code(200);
    echo json_encode(array("message" => "Лекция успешно удалена из избранного"));
} else {
    // Если произошла ошибка при выполнении запроса, возвращаем ошибку
    http_response_code(500);
    echo json_encode(array("message" => "Ошибка при удалении лекции из избранного"));
}
?>
