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

// Проверка, был ли передан необходимый параметр
if (!isset($_POST['subject_id'])) {
    // Если данные не были переданы, возвращаем ошибку
    http_response_code(400);
    echo json_encode(array("message" => "Необходимо передать subject_id"));
    exit();
}

// Получаем значение subject_id из POST запроса
$subject_id = $_POST['subject_id'];

// Начинаем транзакцию
$pdo->beginTransaction();

try {
    // Удаление записей из связанных таблиц (например, questions)
    $stmt_questions = $pdo->prepare("DELETE FROM questions WHERE id_lection IN (SELECT id_lection FROM lection WHERE subject_id = :subject_id)");
    $stmt_questions->bindParam(':subject_id', $subject_id);
    $stmt_questions->execute();

    // Затем удаляем записи из таблицы last_view
    $stmt_last_view = $pdo->prepare("DELETE FROM last_view WHERE id_lection IN (SELECT id_lection FROM lection WHERE subject_id = :subject_id)");
    $stmt_last_view->bindParam(':subject_id', $subject_id);
    $stmt_last_view->execute();

    // Затем удаляем записи из таблицы favorites
    $stmt_favorites = $pdo->prepare("DELETE FROM favorites WHERE id_lection IN (SELECT id_lection FROM lection WHERE subject_id = :subject_id)");
    $stmt_favorites->bindParam(':subject_id', $subject_id);
    $stmt_favorites->execute();

    // Затем удаляем записи из таблицы lection
    $stmt_lection = $pdo->prepare("DELETE FROM lection WHERE subject_id = :subject_id");
    $stmt_lection->bindParam(':subject_id', $subject_id);
    $stmt_lection->execute();

    // Затем удаляем предмет из таблицы subject
    $stmt_subject = $pdo->prepare("DELETE FROM subject WHERE subject_id = :subject_id");
    $stmt_subject->bindParam(':subject_id', $subject_id);
    $stmt_subject->execute();
    
    // Если запрос выполнен успешно, фиксируем изменения
    $pdo->commit();
    
    // Возвращаем успешный ответ
    http_response_code(200);
    echo json_encode(array("message" => "Предмет успешно удален из таблицы и связанных таблиц"));
} catch (PDOException $e) {
    // Если произошла ошибка при выполнении запроса, откатываем транзакцию
    $pdo->rollBack();
    
    // Возвращаем ошибку
    http_response_code(500);
    echo json_encode(array("message" => "Ошибка при удалении предмета: " . $e->getMessage()));
}
?>
