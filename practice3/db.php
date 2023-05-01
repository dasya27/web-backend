<?php
    $servername = 'localhost';
    $username = 'u52955';
    $password = '7977617';
    $dbname = 'u52955';
    //подключаемся к базе данных
    $conn = new PDO('mysql:host=localhost;dbname=u52955',
        $username, $password,
        [PDO::ATTR_PERSISTENT => true,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    
    if(!$conn)
        echo 'Cannot';   
    else
        echo 'Yeeee';   
?>
