<?php
    //подключаемся к базе данных
        include_once('connection.php');
        $id = $_GET["id"];
        $conn = connect();

        $query = "DELETE FROM fields WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();

        header('Location: field.php');
?>
