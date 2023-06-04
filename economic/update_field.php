<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<link rel="stylesheet" href="style.css">

<div class="right-button-margin">
    <div class="on">
    <div class="title">Редактирование отрасли специализации</div>
    <a href="fields.php" class="btn btn-warning ago">Просмотр всех записей</a>
    </div>
</div>

<?php 
    include('connection.php');
    $id = isset($_GET["id"]) ? $_GET["id"] : die("ERROR: отсутствует ID.");
    $conn = connect();

    $query = "SELECT name FROM fields WHERE id = ?";

    $stmt = $conn->prepare($query);
    $stmt->bindParam(1, $id);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $name = $row["name"];

    $flag = 0;
?>

<?php
    if($_POST) {
        $name = $_POST["name"];

        $_POST["name"] = $name;

        //обновляем запись
        $query = "UPDATE fields SET name=:name
            WHERE id = :id";
        
        $stmt = $conn->prepare($query);

        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":id", $id);

        $stmt->execute();

        $flag = 1;

    }
?>

<form class="form-update" action="<?= htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}"); ?>" method="post">
    <table class="table table-hover table-responsive table-bordered">
        <tr>
            <td>Отрасль специализации</td>
            <td><input type="text" name="name" value="<?= $name; ?>" class="form-control" /></td>
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

