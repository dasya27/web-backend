<?php 
    require_once('db.php'); //подключаем файл

    //переменные
    $name = $_POST['name'];
    $mail = $_POST['mail'];
    $year = $_POST['year'];
    $sex = $_POST['sex'];
    $limbs = $_POST['limbs'];
    $skills = $_POST['skills'];
    $bio =  $_POST['bio'];

    $statement1 = $conn->prepare("INSERT INTO Applications (name, year, mail, sex, limbs, biography)
    VALUES (:name, :year, :mail, :sex, :limbs, :bio)");
    