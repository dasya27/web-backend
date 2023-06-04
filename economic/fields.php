

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
            <a href="develop.php" class="item">Develop</a>
            <a href="statistics.php" class="item">Statistics</a>
            <a href="fields_regions.php" class="item">Fields & Regions</a>
            <a href="fields.php" style="color:#f3b600"class="item">Fields</a>
        </div>
    </header>
    <form class="form-add" action="insert_field.php" method="post">
        <div class="form-item">
            <div class="text">Отрасль специализации</div>
            <input type="text" name="name" class="form-control">
        </div>
        <input type="submit" class="btn btn-warning" value="add" />
    </form>



<?php
    //вывод записей в таблицу
    $query = "SELECT * FROM fields";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    //количество строк
    $num = $stmt->rowCount();

    //если в таблице хоть что-то есть, выводим ее
    if ($num > 0) {
        echo "<table class='table table-hover table-responsive table-bordered'>";
        echo "<tr>";
            echo "<th>№</th>";
            echo "<th>Отрасль специализации</th>";
        echo "</tr>";

        $n = 1;

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            extract($row);
            echo "<tr>";
                echo "<td>$n</td>";
                echo "<td>{$name}</td>";
            $n = $n+1;
            echo "<td>";
                // здесь будут кнопки для просмотра, редактирования и удаления
                echo "
                <a href='update_field.php?id={$id}' class='btn btn-success left-margin'>
                <span class='glyphicon glyphicon-edit'></span> Редактировать

                <a href='delete_field.php?id={$id}' class='btn btn-danger delete-object'>
                <span class='glyphicon glyphicon-remove'></span> Удалить
                </a>";
                
            echo "</td>";
        }

        echo "</table>";
    }
    else {
        //сообщаем, что товаров нет
        echo "<div class='alert alert-info'>Записи в таблице не найдены.</div>";
    }
?>

</body>
