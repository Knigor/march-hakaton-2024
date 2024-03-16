<?php
session_start();

// Проверяем, есть ли данные о пользователе в сессии
if (isset($_SESSION['user_data'])) {
    $user_data = $_SESSION['user_data'];

    // Используем данные для отображения информации о пользователе
    echo "<h1>Добро пожаловать, {$user_data['first_name']} {$user_data['last_name']}!</h1>";
    echo "<img src='{$user_data['photo']}' alt='Фото профиля'>";
    echo "<p>Ваш ID: {$user_data['id']}</p>";
} else {
    // Данные пользователя не найдены
    echo "Данные пользователя не найдены";
}
?>
