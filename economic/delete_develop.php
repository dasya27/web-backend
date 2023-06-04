<?php
    //подключаемся к базе данных
        include_once('connection.php');
        $id = $_GET["id_region"];
        $conn = connect();

        $query = "DELETE FROM develop WHERE id_region = ?";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(1, $id_region);
        $stmt->execute();

        header('Location: regions.php');
?>
