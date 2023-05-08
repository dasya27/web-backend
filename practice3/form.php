<?php 
    //переменные и их значения
    $name = $_POST['name'];
    $mail = $_POST['mail'];
    $year = $_POST['year'];
    $sex = $_POST['sex'];
    $limbs = $_POST['limbs'];
    $bio =  $_POST['bio'];

    //для подключения к базе данных
    $username = 'u52955'; 
    $password = '7977617';

    //подключение к базе данных
    //PDO может выюрасывать исключения, поэтому используем блок try catch
    try {
        $conn = new PDO('mysql:host=localhost;dbname=u52955', $username, $password,);
        
        //проверка полей на пустоту
        if(empty($_POST['name'])) exit("Поле name не заполнено");
        if(empty($_POST['mail'])) exit("Поле email не заполнено");

        //подготавливаем запрос
        $query1 = $conn->prepare("INSERT INTO Applications (name, year, mail, sex, limbs, biography) VALUES(?,?,?,?,?,?)");
        //создаем массив с переменными из формы
        $data = array($name, $year, $mail, $sex, $limbs, $bio);
        //отправляем в базу данных этот массив
        $query1->execute($data);

        //получаем id последней добавленной заявки
        $query2 = $conn->prepare("SELECT id FROM Applications WHERE id = LAST_INSERT_ID()");
        //отправлвяем этот запрос
        $query2->execute();
        //получаем этот id
        $last_id = $query2->fetchColumn();

        //нужно отправить способности во вторую таблицу
        //просматриваем полученный массив
        foreach ($_POST['skills'] as $element)
            {
                $query3 = $conn->prepare("INSERT INTO Applications_skills VALUES($last_id, $element)");
                $query3->execute();
            }
        echo "Все отправлено!!!";
    }
    catch(PDOException $e)
    {
        echo "Не получилось соединиться";
    }
 
?>
    
