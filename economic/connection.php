
<?php
    

    function connect()
    {
        //для подключения к базе данных
        $username = 'u52955'; 
        $password = '7977617';

        $conn = TRUE;

        //подключение к бд
        try {
            $conn = new PDO('mysql:host=localhost;dbname=u52955', $username, $password,);
            echo 'Соединились!';
        }
        catch(PDOException $e)
        {
            echo "Не получилось соединиться";
        }

        return ($conn);
    }

?>

