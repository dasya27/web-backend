<?php
    //подключаемся к базе данных
        include_once('connection.php');
        $id = $_GET["id"];
        $conn = connect();

        //удаляем из отраслей и регионов
        $query = "DELETE FROM fields_regions WHERE id_field = ?";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();

        //удаляем из отраслей
        $query = "DELETE FROM fields WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();

        header('Location: fields.php');
?>
