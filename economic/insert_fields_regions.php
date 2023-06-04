<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<link rel="stylesheet" href="style.css">

<?php
    include('connection.php');
    $conn = connect();

    $region_name = $_POST['region_name'];
    $field_name = $_POST['field_name'];

    //id региона
    $query1 = "SELECT id FROM regions WHERE name=?";
    $stmt1 = $conn->prepare($query1);
    $stmt1->bindParam(1, $region_name);
    $stmt1->execute();
    $num1 = $stmt1->rowCount();

    //id отрасли
    $query2 = "SELECT id FROM fields WHERE name=?";
    $stmt2 = $conn->prepare($query2);
    $stmt2->bindParam(1, $field_name);
    $stmt2->execute();
    $num2 = $stmt2->rowCount();

    if($num1>0 && $num2>0)
    {
        $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
        $id_region = $row1["id"];

        $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
        $id_field = $row2["id"];

        //подготавливаем запрос
        $query = $conn->prepare("INSERT INTO fields_regions (id_region, id_field) VALUES(?, ?)");
        $mass = array($id_region, $id_field);
        $query->execute($mass);
    }

    header('Location: fields_regions.php');

?>
