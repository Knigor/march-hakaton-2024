<?php
header('Access-Control-Allow-Origin: http://localhost:5173');
header('Access-Control-Allow-Headers: Content-Type');
header('Access-Control-Allow-Methods: POST');
session_start();

// Подключение к базе данных
$pdo = new PDO("pgsql:host=postgres-db; dbname=hakaton_bd", "user", "user");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["username"])) {
        // Обработка формы входа
        $login = $_POST["username"];
        $password = $_POST["password"];

        // Проверка логина и пароля в базе данных
        $stmt = $pdo->prepare("SELECT * FROM users WHERE login_user = ? AND password_user = ?");
        $stmt->execute([$login, hash('sha256', $password)]);
        $user = $stmt->fetch();

        if ($user) {
            // Успешная аутентификация
            $_SESSION["user"] = $user;
            
            // Добавляем выборку роли пользователя
            $role = $user['role_user'];
            
            // Отправка JSON-ответа
            header('Content-Type: application/json');
            echo json_encode(array('status' => 'success', 'id_user' => $user['id_user'], 'role' => $role));
            exit();
        } else {
            // Ошибка авторизации
            header('Content-Type: application/json');
            echo json_encode(array('status' => 'error', 'message' => 'Неверное имя пользователя или пароль.'));
            exit();
        }
    }
}

// Дополнительный код, если нужно
?>
