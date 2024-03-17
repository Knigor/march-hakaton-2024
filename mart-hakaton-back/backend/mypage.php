<?php

session_start();

// Проверяем, авторизован ли пользователь
if (isset($_SESSION['access_token'])) {
    // Отображаем данные авторизованного пользователя
    echo "<h1>Добро пожаловать, {$_SESSION['name']} {$_SESSION['name_family']}!</h1>";
    echo "<p>Ваш ID: {$_SESSION['uid']}</p>";
    echo "<p><a href='logout.php'>Выйти</a></p>"; // Ссылка на страницу выхода
} else {
    // Если пользователь не авторизован, перенаправляем на страницу авторизации
    header("Location: /index.php");
    exit;
}

?>
