<?php
header("Access-Control-Allow-Origin: *"); // Разрешает доступ со всех источников
header("Access-Control-Allow-Methods: GET, POST, OPTIONS"); // Разрешенные HTTP методы
header("Access-Control-Allow-Headers: Content-Type"); // Разрешенные заголовки

// Получаем значения параметров из GET запроса
$name = $_GET['name'] ?? '';
$age = $_GET['age'] ?? '';

// Возвращаем данные
echo json_encode(['name' => $name, 'age' => $age]);
?>