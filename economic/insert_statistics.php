<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<link rel="stylesheet" href="style.css">

<?php
    include('connection.php');
    $conn = connect();

    $name = $_POST['name'];
    $area = $_POST['area'];
    $population = $_POST['population'];
    $production = $_POST['production'];
    $unemployment = $_POST['unemployment'];

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
        $query = $conn->prepare("INSERT INTO statistics (id_region, area, population, production, unemployment) VALUES(?, ?, ?, ?, ?)");
        $mass = array($id, $area, $population, $production, $unemployment);
        $query->execute($mass);
    }

    header('Location: statistics.php');

?>
