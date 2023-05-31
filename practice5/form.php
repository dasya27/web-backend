<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="style.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap" rel="stylesheet">
    <title>web-5</title>
</head>
<body>

<div class="content">

    <?php
        if (!empty($messages)) {
            print('<div id="messages">');
            foreach ($messages as $message) {
                print($message);
            }
            print('</div>');
        }
    ?>


    <form  class="form1" action="index.php" method="POST">

        <h2>Registration</h2>

        <div class="fields">
            <div class="item">
                <label for="name">Your name</label><br>
                <input type="text" name="name" value="<?php print $values['name'];?>">
            </div>
            <div class="item">
                    <label for="email">Your e-mail:</label><br>
                    <input type="text" name="email" value="<?php print $values['email'];?>" placeholder="Введите e-mail">     
            </div>
            <div class="item">
                Your biography:<br>
            <textarea name="biography" value="<?php print $values['biography'];?>" placeholder="Расскажите о себе..." ><?php print $values['biography'];?></textarea>
            </div>
        </div>

        <div class="inlblock">
            <div class="colblock">

                <div class="gender">
                    You are:<br> 
                    <div class="changeGen">
                        <label>
                            <input type="radio" name="gender" value="F" <?php if ($values['gender']=='F') {print 'checked';} ?> >
                            Woman &#9792;
                        </label>
                        <br>
                        <label>
                            <input type="radio" name="gender" value="M"  <?php if ($values['gender']=='M') {print 'checked';} ?> >
                            Man &#9794;
                        </label>
                    </div>
                </div>  

                <div class="birth">
                    <label>
                        Birthday:<br>
                        <input name="birth" type="date" value="<?php print $values['birth'];?>">
                    </label> 
                </div>
            

                
            </div>
        
            <div class="colblock">

                <div class="limbss">
                Limbs: <br> 
                    <div class="rad">
                        <label>
                            <input type="radio" name="limbs" value="1" <?php if ($values['limbs']=='1') {print 'checked';}?> > 1
                        </label>
                        <label>
                            <input type="radio" name="limbs" value="2" <?php if ($values['limbs']=='2') {print 'checked';}?>> 2
                        </label>
                        <label>
                            <input type="radio" name="limbs" value="3" <?php if ($values['limbs']=='3') {print 'checked';}?>> 3
                        </label>
                        <label>
                            <input type="radio" name="limbs" value="4" <?php if ($values['limbs']=='4') {print 'checked';}?>> 4
                        </label>
                    </div>
                </div>

                <div class="superpowers">   
                    <label>
                        Your skills: <br>
                        <div class="powers">
                            <select name="ability[]" multiple="multiple">
                                <option value="immortality" <?php if(!empty($values['ability'][0])) {if ($values['ability'][0]=="immortality") {print 'selected';}} ?>> Бессмертие </option>
                                <option value="passingWalls" <?php if(!empty($values['ability'][1])) {if ($values['ability'][1]=="passingWalls") {print 'selected';}} ?>> Прохождение сквозь стены </option>
                                <option value="levitation" <?php if(!empty($values['ability'][2])) {if ($values['ability'][2]=="levitation") {print 'selected';}} ?>> Левитация </option>
                            </select>
                        </div>
                    </label> 
                </div>
        
            </div>
        
        </div>
        
        <div class="сheck">
            <input class="сheckbox" type="checkbox" id="agree" name="agree" <?php if ($values['agree']== "1") {print 'checked';}?>>
            <label for="agree">Familiar with the contract</label>
        </div>

        <div>
            <button  type="submit">Send</button>
        </div>

    </form>

    <?php
if (!empty($_COOKIE[session_name()]) && !empty($_SESSION['login'])){
    echo '
        <form class="form2" action="" method="POST" >
            <button name="exit" value="true" type="submit">Выйти</button>
        </form>
    ';
}
?>

</div>

</body>
</html>
