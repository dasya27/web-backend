<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<link rel="stylesheet" href="style.css">

<div class="right-button-margin">
    <div class="on">
    <div class="title">Редактирование отрасли и региона</div>
    <a href="fields_regions.php" class="btn btn-warning ago">Просмотр всех записей</a>
    </div>
</div>

<?php 
    include('connection.php');
    $id_region = isset($_GET["id_region"]) ? $_GET["id_region"] : die("ERROR: отсутствует ID.");
    $conn = connect();

    //получаем номер отрасли
    $query = "SELECT id_field FROM fields_regions WHERE id_region = ?";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(1, $id_region);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $id_field = $row["id_field"];

    //получаем имя региона
    $query = "SELECT name FROM regions WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(1, $id_region);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $name_region = $row["name"];

    //получаем имя региона
    $query = "SELECT name FROM fields WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(1, $id_field);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $name_field = $row["name"];

    $flag = 0;
?>

<?php
    if($_POST) {
        $name_region = $_POST["name_region"];
        $name_field = $_POST["name_field"];

        $_POST["name_region"] = $name_region;
        $_POST["name_field"] = $name_field;

        //получаем обратно их id
        $query = "SELECT id FROM fields WHERE name = ?";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(1, $name_field);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $id_field = $row["id"];

        $query = "SELECT id FROM regions WHERE name = ?";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(1, $name_region);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $id_region = $row["id"];

        //обновляем запись
        $query = "UPDATE fields_regions SET id_field=:id_field
            WHERE id_region = :id_region";
        
        $stmt = $conn->prepare($query);

        $stmt->bindParam(":id_region", $id_region);
        $stmt->bindParam(":id_field", $id_field);

        $stmt->execute();

        $flag = 1;

    }
?>

<form class="form-update" action="<?= htmlspecialchars($_SERVER["PHP_SELF"] . "?id_region={$id_region}"); ?>" method="post">
    <table class="table table-hover table-responsive table-bordered">
        <tr>
            <td>Название региона</td>
            <td><input type="text" name="name_region" value="<?= $name_region; ?>" class="form-control" readonly/></td>
        </tr>
        <tr>
            <td>Отрасль специализации</td>
            <td><input type="text" name="name_field" value="<?= $name_field; ?>" class="form-control" /></td>
        </tr>
        <tr>
            <td></td>
            <td>
                <button type="submit" class="btn btn-success">Обновить</button>
            </td>
        </tr>
    </table>
</form>

<?php
    if($flag>0) {
        echo "<div class='alert alert-success alert-dismissable'>";
        echo "Запись была обновлена.";
        echo "</div>";
    }
?>

