<?php
if (!$_GET['code']){
    exit('error code');
}

// Получаем код авторизации из URL
$code = $_GET['code'];

include 'config.php';

try {
    // Подключение к базе данных
    $pdo = new PDO("pgsql:host=postgres-db;dbname=hakaton_bd", "user", "user");
    // Устанавливаем режим обработки ошибок
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Запрос на получение токена
    $token_response = file_get_contents('http://oauth.vk.com/access_token?client_id='.ID.'&client_secret='.SECRET.'&redirect_uri='.URL.'&code='.$code);

    // Декодируем ответ
    $token_data = json_decode($token_response, true);

    // Проверяем, получили ли мы токен
    if (!$token_data || !isset($token_data['access_token'])) {
        exit('error tokenlol');
    }

    // Получаем данные о пользователе
    $user_data_response = file_get_contents('https://api.vk.com/method/users.get?access_token='.$token_data['access_token'].'&user_ids='.$token_data['user_id'].'&fields=first_name,last_name&v=5.131');

    // Декодируем данные о пользователе
    $user_data = json_decode($user_data_response, true);

    // Проверяем, получили ли мы данные о пользователе
    if (!$user_data || !isset($user_data['response'][0])) {
        exit('error data');
    }

    // Получаем имя и фамилию пользователя из данных VK
    $first_name = $user_data['response'][0]['first_name'];
    $last_name = $user_data['response'][0]['last_name'];

    // Формируем полное имя пользователя
    $full_name_user = $first_name . ' ' . $last_name;

    // Проверяем, существует ли пользователь с таким user_vk_id
    $stmt_check = $pdo->prepare("SELECT id_user FROM users WHERE user_vk_id = ?");
    $stmt_check->execute([$token_data['user_id']]);
    $existing_user = $stmt_check->fetch(PDO::FETCH_ASSOC);

    // Если пользователь уже существует, получаем его id_user
    if ($existing_user) {
        $id_user = $existing_user['id_user'];
    } else {
        // Подготавливаем и выполняем запрос на добавление нового пользователя в базу данных
        $stmt_insert = $pdo->prepare("INSERT INTO users (full_name_user, user_vk_id, role_user) VALUES (?, ?, ?)");
        $stmt_insert->execute([$full_name_user, $token_data['user_id'], 'student']);

        // Получаем id_user нового пользователя
        $id_user = $pdo->lastInsertId();
    }

    // Выводим информацию о пользователе вместе с дополнительными данными
    $user_data['authorized'] = true;
    $user_data['role_user'] = 'student';
    $user_data['id_user'] = $id_user;

    // Выводим информацию о пользователе в формате JSON
    header('Content-Type: application/json');
    echo json_encode($user_data, JSON_PRETTY_PRINT);

} catch (PDOException $e) {
    // Выводим сообщение об ошибке при подключении к базе данных
    exit("Failed to connect to database: " . $e->getMessage());
}
?>
