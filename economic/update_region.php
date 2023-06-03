<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<link rel="stylesheet" href="style.css">

<div class="right-button-margin">
    <a href="regions.php" class="btn btn-warning">Просмотр всех товаров</a>
</div>

<?php 
    include('connection.php');
    $id = isset($_GET["id"]) ? $_GET["id"] : die("ERROR: отсутствует ID.");
    $conn = connect();

    $query = "SELECT name, center FROM regions WHERE id = ?";

    $stmt = $conn->prepare($query);
    $stmt->bindParam(1, $id);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $name = $row["name"];
    $center = $row["center"];
?>

<form action="<?= htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}"); ?>" method="post">
    <table class="table table-hover table-responsive table-bordered">
        <tr>
            <td>Название региона</td>
            <td><input type="text" name="name" value="<?= $name; ?>" class="form-control" /></td>
        </tr>
        <tr>
            <td>Административный центр</td>
            <td><input type="text" name="name" value="<?= $center; ?>" class="form-control" /></td>
        </tr>
        <tr>
            <td></td>
            <td>
                <button type="submit" class="btn btn-success">Обновить</button>
            </td>
        </tr>
    </table>
</form>
