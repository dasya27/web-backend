<?php
    //подключаемся к базе данных
        include('connection.php');
        $conn = connect();

        $query = "DELETE FROM regions WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();

        header('Location: regions.php');
?>
