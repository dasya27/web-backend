<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<link rel="stylesheet" href="style.css">

<?php 
    include('connection.php');
    connect();
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
    <form action="insert_region.php" method="post">
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
</body>