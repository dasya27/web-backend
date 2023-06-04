<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<link rel="stylesheet" href="style.css">

<?php
    include('connection.php');
    $conn = connect();

    $name = $_POST['name'];

    //подготавливаем запрос
    $query = $conn->prepare("INSERT INTO fields (name) VALUES(?)");
    $mass = array($name);
    $query->execute($mass);

    header('Location: fields.php');

?>
