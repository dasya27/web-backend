<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>web3</title>

    <link rel="stylesheet" href="style.css">
</head>
<body>
    <form action="form.php" method="post">
        <div class="title">Form</div>
        <input type="text" name="name" placeholder="Your name" class="text"><br>
        <input type="email" name="mail" placeholder="Your email" class="text"><br>

        <select name="year"class="year">
            <option value="">Choose year</option>
            <?php
            for ($year = 1990; $year < 2023; $year++) {
                echo '<option '.$selected.' value="'.$year.'">'.$year.'</option>';
            }
            ?>
        </select><br>

        <div class="sex">
            You are:
            <input type="radio" name="sex" value="man">
            <label for="man">Man</label>
            <input type="radio" name="sex" value="woman">
            <label for="woman">Woman</label> <br>
        </div>

        <div class="limbs">
            Limbs:
            <input type="radio" name="limbs" value="1">
            <label for="1">1</label>
            <input type="radio" name="limbs" value="2">
            <label for="2">2</label>
            <input type="radio" name="limbs" value="3">
            <label for="3">3</label>
            <input type="radio" name="limbs" value="4">
            <label for="4">4</label><br>
        </div>

        <select multiple class="skills" name="skills">
            <option value="">Your skills</option>
            <option value="kind">Kind</option>
            <option value="honest">Honest</option>
            <option value="funny">Funny</option>
        </select><br>

        <br>
        <textarea rows="4" placeholder="Your bio"></textarea><br>

        <input type="checkbox" name="agree" value="yes" class="agree">
        <label for="agree" >I agree</label><br>

        <input type="submit" class="btn" value="Отправить" />
    </form>

</body>
</html>