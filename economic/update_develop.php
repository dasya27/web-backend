<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<link rel="stylesheet" href="style.css">

<div class="right-button-margin">
    <a href="develop.php" class="btn btn-warning">Просмотр всей таблицы</a>
</div>

<?php 
    include('connection.php');
    $id_region = isset($_GET["id_region"]) ? $_GET["id_region"] : die("ERROR: отсутствует ID.");
    $conn = connect();

    $query = "SELECT id_region, health, education, happy, quality, ecology  FROM develop WHERE id_region = ?";

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
    $health = $row["health"];
    $education = $row["education"];
    $quality = $row["quality"];
    $happy = $row["happy"];
    $ecology = $row["ecology"];

    $flag = 0;
?>

<?php
    if($_POST) {
        //$name = $_POST["name"];
        $health = $_POST["health"];
        $education = $_POST["education"];
        $quality = $_POST["quality"];
        $happy = $_POST["happy"];
        $ecology = $_POST["ecology"];

        //$_POST["name"] = $name;
        $_POST["health"] = $health;
        $_POST["education"] = $education;
        $_POST["quality"] = $quality;
        $_POST["happy"] = $happy;
        $_POST["ecology"] = $ecology;

        //обновляем запись
        $query = "UPDATE develop SET health=:health, education=:education,
            happy=:happy, quality=:quality, ecology=:ecology
            WHERE id_region = :id_region";
        
        $stmt = $conn->prepare($query);

        $stmt->bindParam(":health", $health);
        $stmt->bindParam(":education", $education);
        $stmt->bindParam(":happy", $happy);
        $stmt->bindParam(":quality", $quality);
        $stmt->bindParam(":ecology", $ecology);
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
            <td>Медицина</td>
            <td><input type="text" name="health" value="<?= $health; ?>" class="form-control" /></td>
        </tr>
        <tr>
            <td>Образование</td>
            <td><input type="text" name="education" value="<?= $education; ?>" class="form-control" /></td>
        </tr>
        <tr>
            <td>Уровень счастья</td>
            <td><input type="text" name="happy" value="<?= $happy; ?>" class="form-control" /></td>
        </tr>
        <tr>
            <td>Качество жизни</td>
            <td><input type="text" name="quality" value="<?= $quality; ?>" class="form-control" /></td>
        </tr>
        <tr>
            <td>Экология"</td>
            <td><input type="text" name="ecology" value="<?= $ecology; ?>" class="form-control" /></td>
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
        echo "Товар был обновлён.";
        echo "</div>";
    }
?>
