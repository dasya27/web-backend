<?php
header('Content-Type: text/html; charset=UTF-8');
//если запрос 
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    //массив для временного хранения сообщений пользователю
    $messages =array();

    //если все успешно сохранилось
    if(!empty($_COOKIE['save']))
    {
        setcookie('save', '', 100000); //удаляем
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

    //складываем признак ошибок в массив
    $errors = array();
    $errors['name'] = !empty($_COOKIE['name_error']);
    $errors['mail'] = !empty($_COOKIE['mail_error']);
    $errors['year'] = !empty($_COOKIE['year_error']);
    $errors['skills'] = !empty($_COOKIE['skills_error']);
    $errors['bio'] = !empty($_COOKIE['bio_error']);
    $errors['agree'] = !empty($_COOKIE['agree_error']);

    //Выдаем сообщения об ошибках
    //сохраняем в массив эти сообщения
    if ($errors['name']) {
        // Удаляем куку, указывая время устаревания в прошлом.
        setcookie('name_error', '', 100000);
        // Выводим сообщение.
        $messages[] = '<div class="error">Заполните имя корректно. <br>Допустимые символы: А-Я, а-я, A-Z, a-z, 0-9, -, ., запятая, пробел</div>';
    }
    if ($errors['mail']) {
        setcookie('mail_error', '', 100000);
        $messages[] = '<div class="error">Заполните email корректно. <br> Email должен содержать символ "@" </div>';
    }
    if ($errors['year']) {
        setcookie('year_error', '', 100000);
        $messages[] = '<div class="error">Укажите год рождения </div>';
    }
    if ($errors['skills']) {
        setcookie('skills_error', '', 100000);
        $messages[] = '<div class="error">Укажите хотя бы одну способность. </div>';
    }
    if ($errors['bio']) {
        setcookie('bio_error', '', 100000);
        $messages[] = '<div class="error">Заполните биографию. </div>';
    }
    if ($errors['agree']) {
        setcookie('agree_error', '', 100000);
        $messages[] = '<div class="error">Согласитесь с контрактом</div>';
    }


    // Складываем предыдущие значения полей в массив, если есть.
  $values = array();
  $values['name'] = empty($_COOKIE['name_value']) ? '' : $_COOKIE['name_value'];
  $values['mail'] = empty($_COOKIE['mail_value']) ? '' : $_COOKIE['mail_value'];
  $values['year'] = empty($_COOKIE['year_value']) ? '' : $_COOKIE['year_value'];
  $values['sex'] = empty($_COOKIE['sex_value']) ? '' : $_COOKIE['sex_value'];
  $values['limbs'] = empty($_COOKIE['limbs_value']) ? '' : $_COOKIE['limbs_value'];
  $values['skills'] = empty($_COOKIE['skills_value']) ? array() : unserialize($_COOKIE['skills_value']);
  $values['bio'] = empty($_COOKIE['bio_value']) ? '' : $_COOKIE['bio_value'];
  $values['agree'] = empty($_COOKIE['agree_value']) ? '' : $_COOKIE['agree_value'];


  //включаем содержимое файла form.php
  //в этом файле будут доступны переменные $messages, $efforts, $values для вывода
  //сообщений, ранних полей и признаками ошибок
  include('form.php');
}
//если запрос был методом POST, то нужно проверить данные и сохранить их в xml файле
else {
    
    //проверяем ошибки
    $errors = FALSE; //флажок ошибки

    //поле name 
    if (empty($_POST['name']))
    {
        //заносим в cookie информацию об ошибке, если поле пустое
        setcookie('name_error', $_POST['name'], time() + 24*60*60);
        $errors = TRUE;
    }
    else {
        //проверяем соответствие регулярному выражению
        if(!preg_match('/^([а-яА-ЯЁёa-zA-Z0-9_,.\s-]+)$/u',$_POST['name']))
        {
            setcookie('name_error', '1', time() + 24*60*60);
            $errors = TRUE;
        }
        //Сохраняем значение на месяц
        setcookie('name_value', $_POST['name'], time() + 365 * 24 * 60 * 60);
    }

    //поле mail
    if(empty($_POST['mail']))
    {
        //заносим в cookie информацию об ошибке, если поле пустое
        setcookie('mail_error', $_POST['mail'], time() + 24 * 60 * 600);
        $errors = TRUE;
    }
    else {
        //проверяем соответствие регулярному выражению
        if(!preg_match("/@/", $_POST['mail']))
        {
            setcookie('mail_error', $_POST['mail'], time() + 24 * 60 * 60);
            $errors = TRUE;
        }
            //Сохраняем значение на месяц
            setcookie('mail_value', $_POST['mail'], time() + 365 * 24 * 60 * 60);
    }


    //поле year
    //проверка на пустоту
    if (empty($_POST['year'])) {
        $errors = TRUE;
        setcookie('year', '1', time() + 24 * 60 * 60);
    }
    else {
        setcookie('year_value', $_POST['year'], time() + 365 * 24 * 60 * 60);
    }

    setcookie('sex_value', $_POST['sex'], time() + 365 * 24 * 60 * 60);
    setcookie('limbs_value', $_POST['limbs'], time() + 365 * 24 * 60 * 60);

    //skills
    if (empty($_POST['skills'])) 
    {
      setcookie('skills_error', '1', time() + 24 * 60 * 60);
      $errors = TRUE;
    }
    else {
        foreach ($_POST['skills'] as $skill) {
            if (!in_array($skill, [1,2,3])){
                setcookie('skills_error', '1', time() + 24 * 60 * 60);
                $errors = TRUE;
                break;
            }
        }
        $abs=array();
        
        foreach ($_POST['skills'] as $res) {
            $abs[$res-1] = $res;
        }
        setcookie('skills_value', serialize($abs), time() + 365 * 24 * 60 * 60);
    }

    //bio
    if (empty($_POST['bio']))
    {
        setcookie('bio_error', '1', time() + 24 * 60 * 60);
        setcookie('bio_value', $_POST['bio'], time() + 365 * 24 * 60 * 60);
        $errors = TRUE;
    }
    else
    {
        if(!preg_match('/^([а-яА-ЯЁёa-zA-Z0-9_,.\s-]+)$/u', $_POST['bio']))
        {
            setcookie('bio_error', '1', time() + 24 * 60 * 60);
            $errors = TRUE;
        }
        setcookie('bio_value', $_POST['bio'], time() + 365 * 24 * 60 * 60);
    }

    //check
    if (empty($_POST['agree'])) 
    {
        setcookie('agree_error', '1', time() + 24 * 60 * 60);
        setcookie('agree_value', '0', time() + 365 * 24 * 60 * 60);
        $errors = TRUE;
    }
    else 
    {
        setcookie('agree_value', '1', time() + 365 * 24 * 60 * 60);
    }


    //при наличии ошибок перезагружаем страницу и завершаем работу скрипта
    if($errors)
    {
        header('Location:index.php');
        exit();
    }
    else
    {
        //удаляем все cookies с признаками ошибок
        setcookie('name_error', '', 100000);
        setcookie('mail_error', '', 100000);
        setcookie('year_error', '', 100000);
        setcookie('skills_error', '', 100000);
        setcookie('bio_error', '', 100000);
        setcookie('agree_error', '', 100000);
    }

    //сохранение в базу данных
    $name = $_POST['name'];
    $mail = $_POST['mail'];
    $year = $_POST['year'];
    $sex = $_POST['sex'];
    $limbs = $_POST['limbs'];
    $bio =  $_POST['bio'];

    try {
        
        if(empty($_POST['name'])) 
        {
            echo '<script>alert("Поле name не заполнено")</script>';
            exit();
        }
        if(empty($_POST['mail']))
        {
            echo '<script>alert("Поле mail не заполнено")</script>';
            exit();
        }

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
                $query3 = $conn->prepare("INSERT INTO Applications_skills VALUES($last_id, $element)");
                $query3->execute();
            }
        
    }
    catch(PDOException $e)
    {
        echo "Не получилось соединиться";
    }

    //сохраняем в cookie флажок успешного сохранения
    setcookie('save', '1');

    //делаем перенаправление
    header('Location: index.php');
}
