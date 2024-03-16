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
if (!isset($_POST['id_lection'])) {
    // Если данные не были переданы, возвращаем ошибку
    http_response_code(400);
    echo json_encode(array("message" => "Необходимо передать id_lection"));
    exit();
}

// Получаем значение id_lection из POST запроса
$id_lection = $_POST['id_lection'];

// Начинаем транзакцию
$pdo->beginTransaction();

try {
    // Удаление записей из таблицы questions, если они ссылаются на удаляемую лекцию
    $stmt_questions = $pdo->prepare("DELETE FROM questions WHERE id_lection = :id_lection");
    $stmt_questions->bindParam(':id_lection', $id_lection);
    $stmt_questions->execute();
    
    // Удаление записей из таблицы last_view, если они ссылаются на удаляемую лекцию
    $stmt_last_view = $pdo->prepare("DELETE FROM last_view WHERE id_lection = :id_lection");
    $stmt_last_view->bindParam(':id_lection', $id_lection);
    $stmt_last_view->execute();
    
    // Удаление записей из таблицы favorites, если они ссылаются на удаляемую лекцию
    $stmt_favorites = $pdo->prepare("DELETE FROM favorites WHERE id_lection = :id_lection");
    $stmt_favorites->bindParam(':id_lection', $id_lection);
    $stmt_favorites->execute();
    
    // Удаление записей из таблицы lection
    $stmt_lection = $pdo->prepare("DELETE FROM lection WHERE id_lection = :id_lection");
    $stmt_lection->bindParam(':id_lection', $id_lection);
    $stmt_lection->execute();
    
    // Если запрос выполнен успешно, фиксируем изменения
    $pdo->commit();
    
    // Возвращаем успешный ответ
    http_response_code(200);
    echo json_encode(array("message" => "Лекция успешно удалена из таблицы лекций и связанных таблиц"));
} catch (PDOException $e) {
    // Если произошла ошибка при выполнении запроса, откатываем транзакцию
    $pdo->rollBack();
    
    // Возвращаем ошибку
    http_response_code(500);
    echo json_encode(array("message" => "Ошибка при удалении лекции: " . $e->getMessage()));
}
?>
