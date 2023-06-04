<?php
    //подключаемся к базе данных
        include_once('connection.php');
        $id_region = $_GET["id_region"];
        $conn = connect();

        $query = "DELETE FROM fields_regions WHERE id_region = ?";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(1, $id_region);
        $stmt->execute();

        header('Location: fields_regions.php');
?>
