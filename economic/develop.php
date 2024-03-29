<!-- jQuery (необходим для Bootstrap JavaScript) -->
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>

<!-- bootstrap JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<!-- bootbox JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js"></script>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<link rel="stylesheet" href="style.css">

</body>

<?php 
    include_once('connection.php');
    $conn = connect();
?>

<body>
    <header>
        <a href="index.php" class="logo">economic</a>
        <div class="menu">
            <a href="regions.php" class="item">Regions</a>
            <a href="develop.php" style="text-decoration:underline" class="item">Develop</a>
            <a href="statistics.php" class="item">Statistics</a>
            <a href="fields_regions.php" class="item">Fields & Regions</a>
            <a href="fields.php" class="item">Fields</a>
        </div>
    </header>
    <div style="text-align:center; margin:20px 0 10px 0; font-weight:bold; font-size:20px">Показатели развития региона</div>
    <form class="form-add" action="insert_develop.php" method="post">
        <div class="form-item">
            <div class="text">region</div>
            <input type="text" name="name" class="form-control">
        </div>
        <div class="form-item">
            <div class="text">health</div>
            <input type="text" name="health" class="form-control">
        </div>
        <div class="form-item">
            <div class="text">education</div>
            <input type="text" name="education" class="form-control">
        </div>
        <div class="form-item">
            <div class="text">happy</div>
            <input type="text" name="happy" class="form-control">
        </div>
        <div class="form-item">
            <div class="text">quality</div>
            <input type="text" name="quality" class="form-control">
        </div>
        <div class="form-item">
            <div class="text">ecology</div>
            <input type="text" name="ecology" class="form-control">
        </div>
        <input type="submit" class="btn btn-warning" value="добавить" />
    </form>
    <?php
        $query = "SELECT * FROM develop";
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
                echo "<th>Медицина</th>";
                echo "<th>Образование</th>";
                echo "<th>Уровень счастья</th>";
                echo "<th>Качество жизни</th>";
                echo "<th>Экология</th>";
            echo "</tr>";

            $n = 1;

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                echo "<tr>";
                    echo "<td>$n</td>";
                    //смотрим на имя по этому id
                    $query1 = "SELECT name FROM regions WHERE id=?";
                    $stmt1 = $conn->prepare($query1);
                    $stmt1->bindParam(1, $id_region);
                    $stmt1->execute();
                    $row = $stmt1->fetch(PDO::FETCH_ASSOC);
                    $name = $row["name"];
                    echo "<td>{$name}</td>";

                    echo "<td>{$health}</td>";
                    echo "<td>{$education}</td>";
                    echo "<td>{$happy}</td>";
                    echo "<td>{$quality}</td>";
                    echo "<td>{$ecology}</td>";
                $n = $n+1;
                echo "<td>";
                    // здесь будут кнопки для просмотра, редактирования и удаления
                    echo "
                    <a href='update_develop.php?id_region={$id_region}' class='btn btn-success left-margin'>
                    <span class='glyphicon glyphicon-edit'></span> Редактировать

                    <a href='delete_develop.php?id_region={$id_region}' class='btn btn-danger delete-object'>
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
