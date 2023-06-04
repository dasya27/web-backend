<?php
    //подключаемся к базе данных

        //принимаем этот параметр
        $id = $_GET['id'];

        $query = "DELETE FROM regions WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();

        header('Location: regions.php');
?>
