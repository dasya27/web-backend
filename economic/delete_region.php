<?php
    //подключаемся к базе данных
        include_once('connection.php');
        $id = isset($_GET["id"]) ? $_GET["id"] : die("ERROR: отсутствует ID.");
        $conn = connect();

        $query = "DELETE FROM regions WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();

        header('Location: regions.php');
?>
