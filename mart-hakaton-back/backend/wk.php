<?php

// Замените на ваши данные из VK API
$client_id = '51877729';
$redirect_uri = 'http://localhost'; // Базовый домен localhost

session_start();

// Если пользователь еще не авторизован, отображаем кнопку входа через VK
if (!isset($_GET['access_token'])) {
    echo "<a href='https://oauth.vk.com/authorize?client_id={$client_id}&redirect_uri={$redirect_uri}&response_type=token&v=5.131'>Войти через VK</a>";
} else {
    // Получаем access token из параметров запроса
    $access_token = $_GET['access_token'];

    // Получаем информацию о пользователе
    $user_info_url = "https://api.vk.com/method/users.get?access_token={$access_token}&v=5.131";
    $user_info = file_get_contents($user_info_url);
    $user = json_decode($user_info, true);

    // Проверяем успешность получения информации о пользователе
    if (isset($user['response'][0]['id'])) {
        // Формируем массив с данными пользователя
        $user_data = array(
            'first_name' => $user['response'][0]['first_name'],
            'last_name' => $user['response'][0]['last_name'],
            'photo' => $user['response'][0]['photo_200'],
            'id' => $user['response'][0]['id']
            // Добавьте другие необходимые данные
        );

        // Путь к файлу
        $file_path = __DIR__ . '/papa.txt';

        // Открываем файл для записи (или создания, если его нет)
        $file = fopen($file_path, 'w');

        // Проверяем успешность открытия файла
        if ($file) {
            // Конвертируем массив данных пользователя в строку
            $user_data_str = implode(", ", $user_data);

            // Записываем данные пользователя в файл
            fwrite($file, $user_data_str);

            // Закрываем файл
            fclose($file);

            echo "<h1>Данные пользователя успешно сохранены в файл '{$file_path}'</h1>";
        } else {
            echo "<h1>Ошибка при открытии файла для записи</h1>";
        }

        // Сохраняем данные пользователя в сессию
        $_SESSION['name'] = $user['response'][0]['first_name'];
        $_SESSION['name_family'] = $user['response'][0]['last_name'];
        $_SESSION['uid'] = $user['response'][0]['id'];
        $_SESSION['access_token'] = $access_token;

        // Перенаправляем пользователя на страницу mypage.php
        header("Location: /mypage.php");
        exit; // Важно завершить выполнение скрипта после отправки заголовка перенаправления
    } else {
        // Получение информации о пользователе не удалось
        echo "<h1>Ошибка при получении информации о пользователе</h1>";
    }
}

?>
