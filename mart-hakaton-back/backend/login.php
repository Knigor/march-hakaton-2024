<?php
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
            // Отправка JSON-ответа
            header('Content-Type: application/json');
            echo json_encode(array('status' => 'success', 'user' => $user));
            exit();
        } else {
            // Ошибка авторизации
            header('Content-Type: application/json');
            echo json_encode(array('status' => 'error', 'message' => 'Неверное имя пользователя или пароль.'));
            exit();
        }
    }
}

        ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Форма входа и регистрации</title>
    <style>
        .tabs {
            display: flex;
            justify-content: space-around;
            margin-bottom: 30px;
        }

        .tab {
            cursor: pointer;
            padding: 8px 20px;
            border: 2px solid #ccc;
            border-radius: 5px;
        }

        .tab.active {
            background-color: #101820;
        }

        .form-container {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .form-container form {
            display: none;
            width: 300px;
            margin-top: 20px;
        }

        .form-container form.active {
            display: block;
        }
    </style>
</head>
<body>
    <h1>Вход и регистрация</h1>

    <div class="tabs">
        <div class="tab active" onclick="showForm('loginForm', this)">Вход</div>
        <div class="tab" onclick="location.href='registration.php'">Регистрация</div>
    </div>

    <div class="form-container">
        <!-- Форма авторизации -->
        <form id="loginForm" class="active" method="post" action="login.php">
            <label for="username">Имя пользователя:</label>
            <input type="text" name="username" required><br>
            <label for="password">Пароль:</label>
            <input type="password" name="password" required><br>
            <input type="submit" value="Войти">
        </form>

    </div>

    <script>
        function showForm(formId, clickedTab) {
            const tabs = document.querySelectorAll('.tab');
            tabs.forEach(tab => tab.classList.remove('active'));
            clickedTab.classList.add('active');

            const forms = document.querySelectorAll('.form-container form');
            forms.forEach(form => form.classList.remove('active'));

            const activeForm = document.getElementById(formId);
            activeForm.classList.add('active');
            
        }
    </script>
</body>
</html>
