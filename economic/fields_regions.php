<!-- jQuery (необходим для Bootstrap JavaScript) -->
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>

<!-- bootstrap JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<!-- bootbox JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js"></script>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<link rel="stylesheet" href="style.css">

<?php 
    include_once('connection.php');
    $conn = connect();
?>

<body>
<header>
        <a href="index.php" class="logo">economic</a>
        <div class="menu">
            <a href="regions.php" class="item">Regions</a>
            <a href="develop.php" class="item">Develop</a>
            <a href="statistics.php" class="item">Statistics</a>
            <a href="fields_regions.php" class="item">Fields</a>
        </div>
    </header>
    <form class="form-add" action="insert_fields_regions.php" method="post">
        <div class="form-item">
            <div class="text">region</div>
            <input type="text" name="region_name" class="form-control">
        </div>
        <div class="form-item">
            <div class="text">field</div>
            <input type="text" name="field_name" class="form-control">
        </div>
        <input type="submit" class="btn btn-warning" value="add" />
    </form>
    <?php
        $query = "SELECT * FROM fields_regions";
        $stmt = $conn->prepare($query);
        $stmt->execute();

        //количество строк
        $num = $stmt->rowCount();

        //если в таблице хоть что-то есть, выводим ее
        if ($num > 0) {
            echo "<table class='table table-hover table-responsive table-bordered'>";
            echo "<tr>";
                echo "<th>№</th>";
                echo "<th>Регион</th>";
                echo "<th>Отрасль специализации</th>";
            echo "</tr>";

            $n = 1;

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                echo "<tr>";
                    echo "<td>$n</td>";
                    //выводим название, опираясь на id
                    $query1 = "SELECT name FROM regions WHERE id=?";
                    $stmt1 = $conn->prepare($query1);
                    $stmt1->bindParam(1, $id_region);
                    $stmt1->execute();
                    $row = $stmt1->fetch(PDO::FETCH_ASSOC);
                    $name_region = $row["name"];
                    echo "<td>{$name_region}</td>";

                    //выводим отрасль, опираясь на id
                    $query2 = "SELECT name FROM fields WHERE id=?";
                    $stmt2 = $conn->prepare($query2);
                    $stmt2->bindParam(1, $id_field);
                    $stmt2->execute();
                    $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
                    $name_field = $row2["name"];
                    echo "<td>{$name_field}</td>";

                $n = $n+1;
                echo "<td>";
                    // здесь будут кнопки для просмотра, редактирования и удаления
                    echo "
                    <a href='update_fields_regions.php?id_region={$id_region}' class='btn btn-info left-margin'>
                    <span class='glyphicon glyphicon-edit'></span> Редактировать

                    <a href='delete_fields_regions.php?id_region={$id_region}' class='btn btn-danger delete-object'>
                    <span class='glyphicon glyphicon-remove'></span> Удалить
                    </a>";
                
                echo "</td>";
            }
            echo "</table>";
        }
        else {
            //сообщаем, что товаров нет
            echo "<div class='alert alert-info'>Регионы не найдены не найдены.</div>";
        }
    ?>
</body>
