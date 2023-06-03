<?php
    include('connection.php');
    $conn = connect();

    //подготавливаем запрос
    $query = $conn->prepare("INSERT INTO regions (name, center) VALUES(?, ?)");
    $mass = array($name, $center);
    $query->execute($mass);

?>