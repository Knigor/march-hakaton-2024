<?php
// Параметры подключения к базе данных PostgreSQL
$host = 'postgres-db';
$dbname = 'hakaton_bd';
$username = 'user';
$password = 'user';

try {
    // Подключение к базе данных с использованием PDO
    $conn = new PDO("pgsql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // ID пользователя, для которого нужно выполнить запрос
    $id_user = $_POST['id_user'] ?? null; // Предполагается, что id_user передается в POST-запросе

    if ($id_user) {
        // SQL запрос для получения данных
        $query = "SELECT lv.date, lv.id_lection, l.title_lection, l.subject_id, u.full_name_user 
                  FROM last_view lv
                  JOIN lection l ON lv.id_lection = l.id_lection
                  JOIN users u ON l.id_user = u.id_user
                  WHERE lv.id_user = :id_user";

        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
        $stmt->execute();

        // Вывод результатов запроса
        echo "<table>\n";
        echo "<tr><th>Date</th><th>ID Lection</th><th>Title Lection</th><th>Subject ID</th><th>Full Name User</th></tr>\n";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>" . $row['date'] . "</td>";
            echo "<td>" . $row['id_lection'] . "</td>";
            echo "<td>" . $row['title_lection'] . "</td>";
            echo "<td>" . $row['subject_id'] . "</td>";
            echo "<td>" . $row['full_name_user'] . "</td>";
            echo "</tr>\n";
        }
        echo "</table>\n";
    } else {
        echo "Ошибка: Не удалось получить id_user из POST-запроса.";
    }
} catch (PDOException $e) {
    echo "Ошибка подключения к базе данных: " . $e->getMessage();
}
?>
