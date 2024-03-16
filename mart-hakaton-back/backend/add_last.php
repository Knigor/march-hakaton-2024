<?php
// Параметры подключения к базе данных
$host = 'postgres-db';
$dbname = 'hakaton_bd';
$user = 'user';
$password = 'user';

$response = array();

try {
    // Подключение к базе данных с помощью PDO
    $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
    // Устанавливаем режим ошибок PDO на исключение
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Получение id_user и id_lection из POST запроса
    $id_user = $_POST['id_user'];
    $id_lection = $_POST['id_lection'];

    // Получение текущей даты и времени
    $current_datetime = date('Y-m-d H:i:s');

    // Подготовка запроса на добавление данных в таблицу last_view
    $stmt = $pdo->prepare("INSERT INTO last_view (id_user, id_lection, date) VALUES (:id_user, :id_lection, :current_datetime)");
    // Привязка параметров
    $stmt->bindParam(':id_user', $id_user);
    $stmt->bindParam(':id_lection', $id_lection);
    $stmt->bindParam(':current_datetime', $current_datetime);
    // Выполнение запроса
    $stmt->execute();

    // Получение дополнительной информации из таблицы lection и users
    $stmt_info = $pdo->prepare("SELECT l.markdown_text_lection, l.title_lection, l.subject_id, l.audio_lection, u.full_name_user
                                FROM lection l
                                JOIN users u ON l.id_user = u.id_user
                                WHERE l.id_lection = :id_lection");
    $stmt_info->bindParam(':id_lection', $id_lection);
    $stmt_info->execute();
    $info = $stmt_info->fetch(PDO::FETCH_ASSOC);

    // Формирование полного ответа в формате JSON
    $response['status'] = 'success';
    $response['message'] = 'Успешно добавлено в последние просмотры.';
    $response['added_to_last_view'] = array(
        'id_user' => $id_user,
        'id_lection' => $id_lection,
        'date' => $current_datetime
    );
    $response['lection_info'] = $info;

} catch(PDOException $e) {
    // Возвращаем ошибку в формате JSON
    $response['status'] = 'error';
    $response['message'] = 'Ошибка при добавлении в последние просмотры: ' . $e->getMessage();
}

// Выводим результат в формате JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
