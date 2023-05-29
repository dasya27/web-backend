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

    //проверка полей на пустоту

    //подключение к базе данных
    //PDO может выбрасывать исключения, поэтому используем блок try catch
    try {

        $conn = new PDO('mysql:host=localhost;dbname=u52955', $username, $password,);

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
                $stmt = $conn->prepare("INSERT INTO Applications_skills (application_id, ability_id)
                    VALUES (:application_id, (SELECT id FROM Skills WHERE name=:skill_name))");
                $stmt->bindParam(':application_id', $last_id);
                $stmt->bindParam(':skill_name', $element);

                $stmt->execute();
            }
        echo "<div class='good'>
            Successfully submitted:)
        </div>
        <img src='https://img.freepik.com/free-icon/check_318-760859.jpg?size=626&ext=jpg&ga=GA1.2.70674923.1683627705&semt=sph' alt=''>
        <style type='text/css'>
            .good {
                color:#1c233c;
                font-family: sans-serif;
                font-size: 30px;
                font-weight: 600;
                text-align: center;
                margin-top: 100px;
            }
            body {
                background-color: #7282ba;
            }
            img {
                display: block;
                margin: 30px auto;
                width: 100px;
            }
        </style>";
    }
    catch(PDOException $e)
    {
        echo "Не получилось соединиться";
    }
 
?>
    
