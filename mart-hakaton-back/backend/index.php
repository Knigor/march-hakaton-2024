<?php

// $host = 'postgres-db'; // host так же внутри контейнера, 
// $port = '5432';  // Порт используем для подключения внутри контейнера
// $dbname = 'hakaton_bd';
// $user = 'user';
// $password = 'user';

// echo "Проверка на подключение к БД <br/>";

// try {
//     $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$dbname;user=$user;password=$password");
    
//     $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
//     echo "Успешный вход В БД<br/>";
    

// } catch (PDOException $e) {
//     echo "Ошибка подключения к базе данных: " . $e->getMessage();
// }



if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Headers: Content-Type');
    header('Access-Control-Allow-Methods: POST');
    header('Content-Length: 0');
    header('Content-Type: text/plain');
    exit();
}

// Если это не предзапрос, обрабатываем POST запрос
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');


$json = json_decode(file_get_contents('php://input'));

// Записываем в файл полученный json

file_put_contents(__DIR__ . '/data.txt',  json_encode($json) . "\n", FILE_APPEND);



echo json_encode($json);


?>