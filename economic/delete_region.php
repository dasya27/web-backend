<?php
    //подключаемся к базе данных
    include('connection.php');
    $conn = connect();
    //принимаем этот параметр
    $id = $_GET['id'];

    $query = "DELETE FROM regions WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(1, $id);
    $stmt->execute();

    header("location:javascript://history.go(-1)");
?>
