<?php
header('Content-Type: text/html; charset=UTF-8');


$user = 'u52955';
$pass = '7977617';
$db = new PDO('mysql:host=localhost;dbname=u52955', $user, $pass,
  [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);


// если это GET-запрос
if ($_SERVER['REQUEST_METHOD'] == 'GET')
{
    $msg = array();
    
    // если перед этим был POST-запрос, который успешно сохранил данные,
    // то извещаем об этом пользователя и удаляем соответствующую куку
    if (!empty($_COOKIE['success'])) {
        setcookie('success', '', 1);
        setcookie('login', '', 1);
        setcookie('password', '', 1);

        $msg[] = '<div id="success">Данные были успешно обработаны!</div>';

        // если в куках есть пароль, то выводим информацию для входа
        if (!empty($_COOKIE['password'])) {
            $msg[] = sprintf('Вы можете <a href="login.php">войти</a> с логином <strong>%s</strong>
              и паролем <strong>%s</strong> для изменения данных.',
              strip_tags($_COOKIE['login']),
              strip_tags($_COOKIE['password']));
        }
    }
    
    // если перед этим был POST-запрос, который отловил ошибки во введенных данных,
    // то мы собираем всю информацию об этих ошибках из куков, показываем ее пользователю
    // и удаляем соответствующие куки
    
    $err = array();
    $err['name'] = !empty($_COOKIE['name_error']);
    $err['email'] = !empty($_COOKIE['email_error']);
    $err['birthday'] = !empty($_COOKIE['birthday_error']);
    $err['gender'] = !empty($_COOKIE['gender_error']);
    $err['limbs'] = !empty($_COOKIE['limbs_error']);
    $err['abilities'] = !empty($_COOKIE['abilities_error']);
    $err['bio'] = !empty($_COOKIE['bio_error']);
    $err['contract'] = !empty($_COOKIE['contract_error']);


    if ($err['name']) {
        $msg[] = '<div id="error">Некорректно введено имя</div>';
    }

    if ($err['email']) {
        $msg[] = '<div id="error">Некорректно введена почта</div>';
    }

    if ($err['birthday']) {
        $msg[] = '<div id="error">Неверный формат даты рождения</div>';
    }

    if ($err['gender']) {
        $msg[] = '<div id="error">Выберите пол</div>';
    }

    if ($err['limbs']) {
        $msg[] = '<div id="error">Выберите количество конечностей</div>';
    }

    if ($err['abilities']) {
        $msg[] = '<div id="error">Выберите хотя бы одну способность</div>';
    }

    if ($err['bio']) {
        $msg[] = '<div id="error">Введите свою биографию (да, это обязательно)</div>';
    }

    if ($err['contract']) {
        $msg[] = '<div id="error">Вы не согласились с контрактом</div>';
    }

    // берем ранее введенные значения из куков, если они есть
    $values = array();
    $values['name'] = empty($_COOKIE['name']) ? '' : strip_tags($_COOKIE['name']);
    $values['email'] = empty($_COOKIE['email']) ? '' : strip_tags($_COOKIE['email']);
    $values['birthday'] = empty($_COOKIE['birthday']) ? '' : strip_tags($_COOKIE['birthday']);
    $values['gender'] = empty($_COOKIE['gender']) ? '' : strip_tags($_COOKIE['gender']);
    $values['limbs'] = empty($_COOKIE['limbs']) ? '' : strip_tags($_COOKIE['limbs']);
    $values['abilities'] = empty($_COOKIE['abilities']) ? array() : unserialize($_COOKIE['abilities']);
    $values['bio'] = empty($_COOKIE['bio']) ? '' : strip_tags($_COOKIE['bio']);
    $values['contract'] = empty($_COOKIE['contract']) ? '' : strip_tags($_COOKIE['contract']);


    // если нет ошибок ввода, есть кука сессии, сессия была начата и ранее записан факт успешного логина,
    // то тогда берем соответствующие значения из БД
    if (count(array_filter($err)) === 0 && !empty($_COOKIE[session_name()]) && session_start() && !empty($_SESSION['login'])) {

        // ищем заявку пользователя с uid
        $stmt = $db->prepare("SELECT * FROM applications2 where user_id=?");
        $stmt -> execute([$_SESSION['uid']]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // заполняем values значениями из БД
        $values['name'] = empty($result[0]['name']) ? '' : strip_tags($result[0]['name']);
        $values['email'] = empty($result[0]['email']) ? '' : strip_tags($result[0]['email']);
        $values['birthday'] = empty($result[0]['birthday']) ? '' :strip_tags($result[0]['birthday']);
        $values['gender'] = empty($result[0]['gender']) ? '' : strip_tags($result[0]['gender']); // TODO: gender
        $values['limbs'] = empty($result[0]['limbs']) ? '' : strip_tags($result[0]['limbs']);
        $values['bio'] = empty($result[0]['bio']) ? '' : strip_tags($result[0]['bio']);
        $values['contract'] = empty($result[0]['contract']) ? '' : strip_tags($result[0]['contract']);

        $stmt = $db->prepare("SELECT * FROM application_ability2 where application_id=(SELECT application_id FROM applications2 where user_id=?)");
        $stmt->execute([$_SESSION['uid']]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
      
        // TODO: переделать из id в name
        foreach ($result as $res) {
          $values['abilities'][$res['ability_id'] - 1] = empty($res) ? '' : strip_tags($res['ability_id']);
        }

        $msg[] = "Вход с логином {$_SESSION['login']}, uid: {$_SESSION['uid']}";
    }

    // включаем файл index.php, 
    // в нем будут доступны заполненные переменные msg, err, values
    include('form.php');

} else {

    // иначе, это POST-запрос, в котором необходимо
    // проверить значения полей на корректность, 
    // выдать куки с ошибками, если это необходимо,
    // и поместить значения в базу данных, если они корректны

    // если разлогинился, закрываем сессию, удаляем соотв. куки и завершаем работу скрипта
    if (isset($_POST['logout']) && $_POST['logout'] == 'true') {
        session_destroy();
        setcookie(session_name(), '', 1);
        // также удаляем куку по умолчанию
        setcookie('PHPSESSID', '', 1, '/');
       
        header('Location: ./');

        exit();
    }

    $errors = FALSE;

    // проверяем поле на ошибки
    if (empty($_POST['name']) || !preg_match('/^([а-яА-ЯЁёa-zA-Z\s-]+)$/u', $_POST['name']))
    {
        // если есть ошибка, то выдаем куку до конца сессии
        setcookie('name_error', '1');
        $errors = TRUE;
    } else {
        // если ошибок нет, то удаляем куку
        setcookie('name_error', '1', 1);
    }
    // сохраняем введенное значение на год
    setcookie('name', $_POST['name'], time() + 365 * 24 * 60 * 60);
    

    // валидация почты
    if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
    {
        setcookie('email_error', '1');
        $errors = TRUE;
    } else {
        setcookie('email_error', '1', 1);
    }
    setcookie('email', $_POST['email'], time() + 365 * 24 * 60 * 60);

    // валидация даты рождения
    if (empty($_POST['birthday']) || !preg_match('%[1-2][0-9][0-9][0-9]-[0-1][0-9]-[0-3][0-9]%', $_POST['birthday']))
    {
        setcookie('birthday_error', '1');
        $errors = TRUE;
    } else {
        setcookie('birthday_error', '1', 1);
    }
    setcookie('birthday', $_POST['birthday'], time() + 365 * 24 * 60 * 60);

    // валидация пола    
    if (empty($_POST['gender']) || !in_array($_POST['gender'], ['male','female']))
    {
        setcookie('gender_error', '1');
        $errors = TRUE;
    } else {
        setcookie('gender_error', '1', 1);
    }
    setcookie('gender', $_POST['gender'], time() + 365 * 24 * 60 * 60);
   
    // валидация числа конечностей
    if (empty($_POST['limbs']))
    {
        setcookie('limbs_error', '1');
        $errors = TRUE;
    } else {
        setcookie('limbs_error', '1', 1);
    }
    setcookie('limbs', $_POST['limbs'], time() + 365 * 24 * 60 * 60);
    
    // валидация способностей
    if (empty($_POST['abilities']))
    {
        setcookie('abilities_error', '1');
        $errors = TRUE;
    } else {
        setcookie('abilities_error', '1', 1);
    }
    setcookie('abilities', serialize($_POST['abilities']), time() + 365 * 24 * 60 * 60);
    
    // валидация биографии
    if (empty($_POST['bio']))
    {
        setcookie('bio_error', '1');
        $errors = TRUE;
    } else {
        setcookie('bio_error', '1', 1);
    }
    setcookie('bio', $_POST['bio'], time() + 365 * 24 * 60 * 60);

    // валидация чекбокса
    if (empty($_POST['contract'])) {
        setcookie('contract_error', '1');
        $errors = TRUE;
    } else {
        setcookie('contract_error', '1', 1);
    }
    setcookie('contract', $_POST['contract'], time() + 365 * 24 * 60 * 60);


    // проверка наличия ошибок
    if ($errors)
    {
        // если есть ошибки, то перезагружаем страницу и завершаем скрипт
        header('Location: index.php');
        exit();
    } else {
        // удаляем все куки с ошибками
        setcookie('name_error', '', 1);
        setcookie('email_error', '', 1);
        setcookie('birthday_error', '', 1);
        setcookie('gender_error', '', 1);
        setcookie('limbs_error', '', 1);
        setcookie('abilities_error', '', 1);
        setcookie('contract_error', '', 1);
    }


    if (!empty($_COOKIE[session_name()]) && session_start() && !empty($_SESSION['login'])) {

        // обновляем уже существующие данные у пользователя с uid
        $stmt = $db->prepare("UPDATE applications2 SET name = ?, email = ?, birthday = ?, gender = ?, limbs = ?, bio = ? WHERE user_id = ?");
        $gender = ($_POST['gender'] == 'female') ? 1 : 0;
        $stmt->execute([$_POST['name'], $_POST['email'], $_POST['birthday'], $gender, $_POST['limbs'], $_POST['bio'],   $_SESSION['uid']]);

        
        $stmt = $db->prepare("SELECT * FROM application_ability2 where application_id=(SELECT application_id FROM applications2 where user_id=?) ");
        $stmt->execute([$_SESSION['uid']]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // определяем, нужно ли обновлять способности
        $flag = false;
        foreach ($_POST['abilities'] as $ability) {
            if ($result[$ability] != $ability) {
                $flag = true;
                break;
            }
        }

 
        if ($flag) {
            // удаляем из таблицы application_ability все предыдущие способности, связанные с заявкой пользователя uid
            //$stmt = $db->prepare("DELETE FROM application_ability2 WHERE application_id=(SELECT id FROM applications2 where user_id=?) ");
            //$stmt->execute([$_SESSION['uid']]);

            // находим номер заявки по идентификатору пользователя
            $stmt = $db->prepare("SELECT application_id FROM applications2 where user_id=? ");
            $stmt->execute([$_SESSION['uid']]);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // вставляем новые способности
            foreach ($_POST['abilities'] as $ability) 
            {
                echo($ability);
                $stmt = $db->prepare("INSERT INTO application_ability2 (application_id, ability_id)
                    VALUES (:application_id, (SELECT ability_id FROM abilities2 WHERE ability_name=:ability_name))");
                $stmt->bindParam(':application_id', $result[0]["id"]);
                $stmt->bindParam(':ability_name', $ability);
        
                $stmt->execute();
            }
        }
  } else {
    
    // генерируем уникальный логин и пароль и сохраняем их в куки
    $login = substr(uniqid('', true), -8, 8);
    $pass = uniqid();

    setcookie('login', $login);
    setcookie('password', $pass);

    try {
        // вставляем запись в таблицу users
        $stmt = $db->prepare("INSERT INTO users (user, password) VALUES (?,?)");
        $stmt->execute([$login, password_hash($pass, PASSWORD_DEFAULT)]);

        $uid = $db->lastInsertId();

        $stmt = $db->prepare("INSERT INTO applications2 (name, email, birthday, gender, limbs, bio, user_id) 
        VALUES (:name, :email, :birthday, :gender, :limbs, :bio, :user_id)");

        $gender = ($_POST['gender'] == 'female') ? 1 : 0;

        $stmt->bindParam(':name', $_POST['name']);
        $stmt->bindParam(':email', $_POST['email']);
        $stmt->bindParam(':birthday', $_POST['birthday']);
        $stmt->bindParam(':gender', $gender);
        $stmt->bindParam(':limbs', $_POST['limbs']);
        $stmt->bindParam(':bio', $_POST['bio']);
        $stmt->bindParam(':user_id', $uid);

        $stmt->execute();

        $app_id = $db->lastInsertId();

        foreach ($_POST['abilities'] as $ability) 
        {
            $stmt = $db->prepare("INSERT INTO application_ability2 (application_id, ability_id)
                VALUES (:application_id, (SELECT ability_id FROM abilities2 WHERE ability_name=:ability_name))");
            $stmt->bindParam(':application_id', $app_id);
            $stmt->bindParam(':ability_name', $ability);

            $stmt->execute();
        }
    }
    catch(PDOException $e) {
        print('Error : ' . $e->getMessage());
        exit();
    }

  }
    
    // сохраняем куку с признаком успешной обработки данных
    setcookie('success', 1);
    header('Location: index.php');  
}

//ваня
//67111657
//64761a7be9007
