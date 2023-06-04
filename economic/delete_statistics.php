<?php
    //подключаемся к базе данных
        include_once('connection.php');
        $id = $_GET["id_region"];
        $conn = connect();

        $query = "DELETE FROM statistics WHERE id_region = ?";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();

        header('Location: statistics.php');
?>
