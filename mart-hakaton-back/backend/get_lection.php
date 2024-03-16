<?php
// Параметры подключения к базе данных
$host = 'postgres-db';
$dbname = 'hakaton_bd';
$user = 'user';
$password = 'user';

// Подключение к базе данных
try {
    $dbh = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
} catch (PDOException $e) {
    die("Error: Could not connect. " . $e->getMessage());
}

// subject_id
$subject_id = $_POST['id_subject'] ?? ''; // Учитываем возможность отсутствия параметра в POST запросе

// Подготовка SQL запроса
$sql = "SELECT l.title_lection 
        FROM lection l 
        INNER JOIN subject s ON l.subject_id = s.subject_id 
        WHERE s.subject_id = :subject_id";

// Подготовка и выполнение запроса
$stmt = $dbh->prepare($sql);
$stmt->bindParam(':subject_id', $subject_id, PDO::PARAM_INT);
$stmt->execute();

// Получение результатов запроса
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Создание массива для хранения результатов
$lectures = [];

// Заполнение массива результатами
foreach ($result as $row) {
    $lectures[] = $row['title_lection'];
}

// Преобразование массива в JSON
$json_result = json_encode($lectures);

// Вывод JSON
echo $json_result;

// Закрытие соединения с базой данных
$dbh = null;
?>
