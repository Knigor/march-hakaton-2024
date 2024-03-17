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
if (!isset($_POST['subject_id']) || !isset($_POST['id_user'])) {
    // Если данные не были переданы, возвращаем ошибку
    http_response_code(400);
    echo json_encode(array("message" => "Необходимо передать subject_id и id_user"));
    exit();
}

// Получаем значения subject_id и id_user из POST запроса
$subject_id = $_POST['subject_id'];
$id_user = $_POST['id_user'];

// Начинаем транзакцию
$pdo->beginTransaction();

try {
    // Проверка, создавал ли пользователь данный предмет
    $stmt_check_user = $pdo->prepare("SELECT id_user FROM subject WHERE subject_id = :subject_id");
    $stmt_check_user->bindParam(':subject_id', $subject_id);
    $stmt_check_user->execute();
    $subject_creator = $stmt_check_user->fetch(PDO::FETCH_ASSOC);

    // Проверка наличия результата запроса и соответствия создателя предмета текущему пользователю
    if ($subject_creator && $subject_creator['id_user'] == $id_user) {
        // Удаление предмета и связанных данных, так как пользователь имеет право на это
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
    } else {
        // Запрет на удаление предмета, так как пользователь не является создателем
        http_response_code(403);
        echo json_encode(array("message" => "У вас нет прав на удаление этого предмета"));
    }
} catch (PDOException $e) {
    // Если произошла ошибка при выполнении запроса, откатываем транзакцию
    $pdo->rollBack();

    // Возвращаем ошибку
    http_response_code(500);
    echo json_encode(array("message" => "Ошибка при удалении предмета: " . $e->getMessage()));
}
?>