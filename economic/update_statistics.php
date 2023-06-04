<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<link rel="stylesheet" href="style.css">

<div class="right-button-margin">
    <a href="statistics.php" class="btn btn-warning">Просмотр всей таблицы</a>
</div>

<?php 
    include('connection.php');
    $id_region = isset($_GET["id_region"]) ? $_GET["id_region"] : die("ERROR: отсутствует ID.");
    $conn = connect();

    $query = "SELECT id_region, area, population, production, unemployment  FROM statistics WHERE id_region = ?";

    $stmt = $conn->prepare($query);
    $stmt->bindParam(1, $id_region);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    //поиск имени
    $query1 = "SELECT name FROM regions WHERE id=?";
    $stmt1 = $conn->prepare($query1);
    $stmt1->bindParam(1, $id_region);
    $stmt1->execute();
    $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
    
    $name = $row1["name"];
    $area = $row["area"];
    $population = $row["population"];
    $production = $row["production"];
    $unemployment = $row["unemployment"];

    $flag = 0;
?>

<?php
    if($_POST) {
        //$name = $_POST["name"];
        $area = $_POST["area"];
        $population = $_POST["population"];
        $production = $_POST["production"];
        $unemployment = $_POST["unemployment"];

        //$_POST["name"] = $name;
        $_POST["area"] = $area;
        $_POST["population"] = $population;
        $_POST["production"] = $production;
        $_POST["unemployment"] = $unemployment;

        //обновляем запись
        $query = "UPDATE statistics SET area=:area, population=:population,
            production=:production, unemployment=:unemployment
            WHERE id_region = :id_region";
        
        $stmt = $conn->prepare($query);

        $stmt->bindParam(":area", $area);
        $stmt->bindParam(":population", $population);
        $stmt->bindParam(":production", $production);
        $stmt->bindParam(":unemployment", $unemployment);
        $stmt->bindParam(":id_region", $id_region);

        $stmt->execute();

        $flag = 1;

    }
?>

<form class="form-update" action="<?= htmlspecialchars($_SERVER["PHP_SELF"] . "?id_region={$id_region}"); ?>" method="post">
    <table class="table table-hover table-responsive table-bordered">
        <tr>
            <td>Название региона</td>
            <td><input type="text" name="name" value="<?= $name; ?>" class="form-control" readonly/></td>
        </tr>
        <tr>
            <td>Площадь</td>
            <td><input type="text" name="area" value="<?= $area; ?>" class="form-control" /></td>
        </tr>
        <tr>
            <td>Население</td>
            <td><input type="text" name="population" value="<?= $population; ?>" class="form-control" /></td>
        </tr>
        <tr>
            <td>Производство</td>
            <td><input type="text" name="production" value="<?= $production; ?>" class="form-control" /></td>
        </tr>
        <tr>
            <td>Безработица</td>
            <td><input type="text" name="unemployment" value="<?= $unemployment; ?>" class="form-control" /></td>
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
