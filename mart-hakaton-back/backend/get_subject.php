<?php
// Подключение к базе данных (замените значения на ваши)
$host = 'postgres-db';
$dbname = 'hakaton_bd';
$username = 'user';
$password = 'user';

try {
    // Подключение к базе данных
    $conn = new PDO("pgsql:host=$host;dbname=$dbname", $username, $password);
    
    // Установка режима обработки ошибок
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // SQL запрос
    $sql = "SELECT s.subject_id, s.faculty, s.class, s.name_item, u.full_name_user 
            FROM subject s
            LEFT JOIN users u ON s.id_user = u.id_user";
    
    // Подготовка и выполнение запроса
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    
    // Формирование результата в формате JSON
    $result = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // Создание отдельного объекта для каждой строки сущности
        $subject_data = array(
            'subject_id' => $row['subject_id'],
            'faculty' => $row['faculty'],
            'class' => $row['class'],
            'name_item' => $row['name_item'],
            'full_name_user' => $row['full_name_user']
        );
        // Добавление объекта в массив результата
        $result[] = $subject_data;
    }
    
    // Вывод результата в формате JSON
    echo json_encode($result);
} catch(PDOException $e) {
    // В случае ошибки выводим сообщение об ошибке
    echo "Connection failed: " . $e->getMessage();
}
?>
