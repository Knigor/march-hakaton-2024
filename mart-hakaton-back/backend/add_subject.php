<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: http://localhost:5173');
header('Access-Control-Allow-Headers: Content-Type');
header('Access-Control-Allow-Methods: POST');

// Параметры подключения к базе данных
$host = 'postgres-db';
$dbname = 'hakaton_bd';
$user = 'user';
$password = 'user';

$response = array();

// Установка соединения с базой данных
$dsn = "pgsql:host=$host;dbname=$dbname;user=$user;password=$password";
try {
    $db = new PDO($dsn);
    $response['status'] = 'success';
    $response['message'] = 'Соединение установлено';

    // Получение данных из POST-запроса
    $name_item = $_POST['name_item'];
    $faculty = $_POST['faculty'];
    $class = $_POST['class'];
    $foto_name = $_FILES['foto']['name'];
    $foto_tmp_name = $_FILES['foto']['tmp_name'];
    $id_user = $_POST['id_user']; // Значение id_user

    // Чтение изображения и его представление в формате base64
    $foto_data = file_get_contents($foto_tmp_name);
    $foto_base64 = base64_encode($foto_data);

    // Подготовка SQL запроса для добавления атрибутов в сущность "subject"
    $sql = "INSERT INTO subject (name_item, faculty, class, foto, id_user) VALUES (:name_item, :faculty, :class, :foto, :id_user)";
    $stmt = $db->prepare($sql);

    // Выполнение запроса с параметрами
    $stmt->bindParam(':name_item', $name_item);
    $stmt->bindParam(':faculty', $faculty);
    $stmt->bindParam(':class', $class);
    $stmt->bindParam(':foto', $foto_base64);
    $stmt->bindParam(':id_user', $id_user);
    
    if ($stmt->execute()) {
        $response['status'] = 'success';
        $response['message'] = 'Данные успешно добавлены в таблицу subject';
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Ошибка при выполнении запроса';
    }

    // Закрытие соединения с базой данных
    $db = null;
} catch (PDOException $e) {
    $response['status'] = 'error';
    $response['message'] = 'Ошибка: ' . $e->getMessage();
}

echo json_encode($response);
exit; // Добавляем exit для предотвращения вывода HTML-кода
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Subject</title>
</head>
<body>
    <h2>Add Subject</h2>
    <form action="add_subject.php" method="post" enctype="multipart/form-data">
        <label for="name_item">Name:</label><br>
        <input type="text" id="name_item" name="name_item"><br>
        <label for="faculty">Faculty:</label><br>
        <input type="text" id="faculty" name="faculty"><br>
        <label for="class">Class:</label><br>
        <input type="text" id="class" name="class"><br>
        <label for="foto">Photo:</label><br>
        <input type="file" id="foto" name="foto"><br><br>
        <label for="id_user">User ID:</label><br>
        <input type="number" id="id_user" name="id_user" value="1"><br><br>
        <input type="submit" value="Submit">
    </form>
</body>
</html>
