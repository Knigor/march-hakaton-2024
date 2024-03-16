<?php

// Замените на ваши данные из VK API
$client_id = '51877729';
$redirect_uri = 'http://localhost/mypage.php'; // Перенаправление на mypage.php после успешной авторизации

session_start();

// Если пользователь еще не авторизован, отображаем кнопку входа через VK
if (!isset($_SESSION['access_token'])) {
    echo "<a href='https://oauth.vk.com/authorize?client_id={$client_id}&redirect_uri={$redirect_uri}&response_type=token&v=5.131'>Войти через VK</a>";
} else {
    // Перенаправляем пользователя на страницу mypage.php
    header("Location: /mypage.php");
    exit; // Важно завершить выполнение скрипта после отправки заголовка перенаправления
}

?>
