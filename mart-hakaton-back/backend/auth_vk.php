<?php

// Замените на ваши данные из VK API
$client_id = '51877729';
$client_secret = 'OuwotoxqXPgVk9nlMuJ9';
$redirect_uri = 'http://localhost/vk.php';

session_start();

// Если пользователь еще не авторизован, отображаем кнопку входа через VK
if (!isset($_GET['code'])) {
    echo "<a href='https://oauth.vk.com/authorize?client_id={$client_id}&redirect_uri={$redirect_uri}&response_type=code&v=5.131'>Войти через VK</a>";
} else {
    // Получаем code из параметров запроса
    $code = $_GET['code'];

    // Получаем access token для пользователя
    $token_url = "https://oauth.vk.com/access_token?client_id={$client_id}&client_secret={$client_secret}&redirect_uri={$redirect_uri}&code={$code}";
    $response = file_get_contents($token_url);
    $params = json_decode($response, true);

    // Проверяем успешность авторизации
    if (isset($params['access_token'])) {
        // Получаем информацию о пользователе
        $user_info_url = "https://api.vk.com/method/users.get?user_ids={$params['user_id']}&fields=photo_200&access_token={$params['access_token']}&v=5.131";
        $user_info = file_get_contents($user_info_url);
        $user = json_decode($user_info, true);

        // Формируем массив с данными пользователя
        $user_data = array(
            'first_name' => $user['response'][0]['first_name'],
            'last_name' => $user['response'][0]['last_name'],
            'photo' => $user['response'][0]['photo_200'],
            'id' => $user['response'][0]['id']
            // Добавьте другие необходимые данные
        );

        // Путь к файлу
        $file_path = __DIR__ . '/user_data.json';

        // Записываем данные пользователя в файл в формате JSON
        $json_data = json_encode($user_data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        $result = file_put_contents($file_path, $json_data);

        // Проверяем, была ли запись в файл успешной
        if ($result !== false) {
            echo "<h1>Данные пользователя успешно сохранены в файл '{$file_path}'</h1>";
        } else {
            echo "<h1>Ошибка при сохранении данных пользователя в файл</h1>";
        }

        // Сохраняем данные пользователя в сессию
        $_SESSION['name'] = $user['response'][0]['first_name'];
        $_SESSION['name_family'] = $user['response'][0]['last_name'];
        $_SESSION['uid'] = $params['user_id'];
        $_SESSION['access_token'] = $params['access_token'];

        // Перенаправляем пользователя на страницу mypage.php
        header("Location: /mypage.php");
        exit; // Важно завершить выполнение скрипта после отправки заголовка перенаправления
    } else {
        // Авторизация не удалась
        echo "<h1>Авторизация не удалась</h1>";
    }
}

?>
