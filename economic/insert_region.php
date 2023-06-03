<?php
    include('connection.php');
    $conn = connect();

    $name = $_POST['name'];
    $center = $_POST['center'];

    //подготавливаем запрос
    $query = $conn->prepare("INSERT INTO regions (name, center) VALUES(?, ?)");
    $mass = array($name, $center);
    $query->execute($mass);

    header('Location: regions.php');

?>
