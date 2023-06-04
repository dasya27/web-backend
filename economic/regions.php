

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
    include('connection.php');
    $conn = connect();
?>

<body>
    <header>
        <a href="index.php" class="logo">economic</a>
        <div class="menu">
            <a href="regions.php" class="item">Regions</a>
            <a href="develop.php" class="item">Develop</a>
            <a href="statistics.php" class="item">Statistics</a>
            <a href="fields.php" class="item">Fields</a>
        </div>
    </header>
    <form class="form-add" action="insert_region.php" method="post">
        <div class="form-item">
            <div class="text">name</div>
            <input type="text" name="name" class="form-control">
        </div>
        <div class="form-item">
            <div class="text">center</div>
            <input type="text" name="center" class="form-control">
        </div>
        <input type="submit" class="btn btn-warning" value="add" />
    </form>



<?php
    //вывод записей в таблицу
    $query = "SELECT * FROM regions";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    //количество строк
    $num = $stmt->rowCount();

    //если в таблице хоть что-то есть, выводим ее
    if ($num > 0) {
        echo "<table class='table table-hover table-responsive table-bordered'>";
        echo "<tr>";
            echo "<th>id</th>";
            echo "<th>Название региона</th>";
            echo "<th>Административный центр</th>";
        echo "</tr>";

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            extract($row);
            echo "<tr>";
                echo "<td>{$id}</td>";
                echo "<td>{$name}</td>";
                echo "<td>{$center}</td>";

            echo "<td>";
                // здесь будут кнопки для просмотра, редактирования и удаления
                echo "
                <a href='update_region.php?id={$id}' class='btn btn-info left-margin'>
                <span class='glyphicon glyphicon-edit'></span> Редактировать

                <a delete-id='{$id}' onClick=confirm_region($id) class='btn btn-danger delete-object'>
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

<script>
    function confirm_region(id) {
        let result = confirm("Вы действительно хотите удалить запись?");
        if(result)
        {
            window.location.href = 'delete_region.php/?id='+id;
        }
    }
</script>

</body>
