<?php

header('Access-Control-Allow-Origin: http://localhost:5173');
header('Access-Control-Allow-Headers: Content-Type');
header('Access-Control-Allow-Methods: POST');


$pdo = new PDO("pgsql:host=postgres-db; dbname=hakaton_bd", "user", "user");

if (isset($_POST["register"])) {
    // Обработка формы регистрации
    $login = $_POST["login"];
    $full_name = $_POST["full_name"];
    $password = $_POST["password"];
    $date_birth = $_POST["date_birth"];
    $role_user = ($_POST["role"] == "student") ? "student" : "teacher"; // Определение роли пользователя

    // Валидация данных (в данном примере простая валидация)
    if (empty($login) ||  empty($password) || empty($full_name)) {
        // Возвращаем ошибку, если не все поля заполнены
        header('Content-Type: application/json');
        echo json_encode(array('status' => 'error', 'message' => 'Заполните все поля и подтвердите согласие на обработку персональных данных.'));
        exit();
    } 
     else {
        // Проверка уникальности логина
        $stmtLogin = $pdo->prepare("SELECT * FROM users WHERE login_user = ?");
        $stmtLogin->execute([$login]);
        $userLogin = $stmtLogin->fetch();

        if ($userLogin) {
            // Возвращаем ошибку, если пользователь с таким логином уже существует
            header('Content-Type: application/json');
            echo json_encode(array('status' => 'error', 'message' => 'Пользователь с таким логином уже существует.'));
            exit();
        } else {
            // Хеширование пароля
            $hashedPassword = hash('sha256', $password);

            // Подготовка данных для вставки в таблицу users
            $data = [
                'login' => $login,
                'hashedPassword' => $hashedPassword,
                'full_name_user' => $full_name,
                'role_user' => $role_user,
                'date_of_birth' => $date_birth
            ];

            // Вставка данных в таблицу users
            $stmtInsert = $pdo->prepare("INSERT INTO users (login_user, password_user, role_user, full_name_user, date_of_birth) VALUES (:login, :hashedPassword, :role_user, :full_name_user, :date_of_birth)");
            $stmtInsert->execute($data);

            // Получение id новой записи
            $id_user = $pdo->lastInsertId();

            // Добавление id_user к данным
            $data['id_user'] = $id_user;

            // Запись данных в файл
            $userDataString = json_encode(array('status' => 'success', 'user' => $data));
            file_put_contents('dataa.txt', $userDataString . PHP_EOL, FILE_APPEND);

            // Формируем JSON-ответ с данными пользователя и статусом регистрации
            header('Content-Type: application/json');
            echo $userDataString;
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
    <title>Регистрация</title>
</head>
<body>
    <h1>Регистрация</h1>
    <form id="registerForm" method="post" action="">
        <label for="login">Логин:</label>
        <input type="text" name="login" required><br>
        <label for="password">Пароль:</label>
        <input type="password" name="password" required><br>
        <label for="full_name">Полное имя:</label>
        <input type="text" name="full_name" required><br>
        <label for="date_birth">Дата рождения:</label>
        <input type="date" name="date_birth" required><br>
        <label>Роль:</label><br>
        <input type="radio" name="role" value="student" checked> Я студент<br>
        <input type="radio" name="role" value="teacher"> Я преподаватель<br>
        <input type="submit" name="register" value="Зарегистрироваться">
    </form>
</body>
</html>