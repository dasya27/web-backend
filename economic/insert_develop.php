<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<link rel="stylesheet" href="style.css">

<?php
    include('connection.php');
    $conn = connect();

    $name = $_POST['name'];
    $health = $_POST['health'];
    $education = $_POST['education'];
    $happy = $_POST['happy'];
    $quality = $_POST['quality'];
    $ecology = $_POST['ecology'];

    $query1 = "SELECT id FROM regions WHERE name=?";
    $stmt1 = $conn->prepare($query1);
    $stmt1->bindParam(1, $name);
    $stmt1->execute();
    
    $num = $stmt1->rowCount();

    if($num>0)
    {
        $row = $stmt1->fetch(PDO::FETCH_ASSOC);
        $id = $row["id"];

        //подготавливаем запрос
        $query = $conn->prepare("INSERT INTO develop (id_region, health, education, happy, quality, ecology) VALUES(?, ?, ?, ?, ?, ?)");
        $mass = array($id, $health, $education, $happy, $quality, $ecology);
        $query->execute($mass);
    }

    header('Location: develop.php');

?>
