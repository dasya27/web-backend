<?php

/**
 * Файл login.php для не авторизованного пользователя выводит форму логина.
 * При отправке формы проверяет логин/пароль и создает сессию,
 * записывает в нее логин и id пользователя.
 * После авторизации пользователь перенаправляется на главную страницу
 * для изменения ранее введенных данных.
 **/

header('Content-Type: text/html; charset=UTF-8');

$user = 'u52955';
$pass = '7977617';
$db = new PDO('mysql:host=localhost;dbname=u52955', $user, $pass,
  [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

session_start();

// В суперглобальном массиве $_SESSION хранятся переменные сессии.
// Будем сохранять туда логин после успешной авторизации.
if (!empty($_SESSION['login'])) {
    
  // Если есть логин в сессии, то пользователь уже авторизован.
  // TODO: Сделать выход (окончание сессии вызовом session_destroy()
  //при нажатии на кнопку Выход).
  // Делаем перенаправление на форму.
  header('Location: ./');
}

// если это GET-запрос
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
?>
<html>
    <head>
        <link rel="icon" type="image/x-icon" href="favicon.svg">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
        <title>Логин</title>
        <link rel="stylesheet" href="style5.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js" defer></script>
    </head>
    <style>
        .login, .pass {
            width: 250px;
            margin-top: 5px;
        }

        .btn {
            background-color: #47860d;
            border:none;
            cursor:pointer;
            color:white;
            width: 130px;
            margin-top: 5px;
        }

        .btn:hover {
            background-color: #346309;
            color:white;
        }
    </style>
    <body>
    <div class="col col-10 col-md-11" id="forma">
            <form id="form1" action="" method="POST">
                <div class="form-group">
                    <label for="name">Логин</label>
                    <input name="login" id="name" class="form-control login" placeholder="Введите ваш логин">
                </div>
                <div class="form-group">
                    <label for="pwd">Пароль</label>

                    <input name="password" class="form-control pass" id="pwd" placeholder="Введите ваш пароль" >

                </div>
            
                <input type="submit" id="btnend" class="btn btn-primary" value="Отправить">
            </form>
        </div>
        </div>
    </body>
</html>
<?php
}

// если это POST-запрос, то нужно сделать авторизацию с записью логина в сессию.
// проверяем есть такой логин и пароль в бд, если все ок, то авторизуем пользователя
else {
      try {
        $stmt = $db->prepare("SELECT * FROM users where user=?");
        $stmt->execute([$_POST['login']]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $flag = false;
        if(password_verify($_POST['password'], $result['password']))
        {
            $_SESSION['login'] = $_POST['login'];
            $_SESSION['uid'] =$result["id"];
            header('Location: ./');
        } else {
            print('Неверный пароль!');
        }
      }
      
      catch(PDOException $e){
        print('Error : ' . $e->getMessage());
        exit();
    }
}
