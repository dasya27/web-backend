<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>web4</title>

    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap" rel="stylesheet">


</head>
<body>

    
    <form action="" method="POST">
        <div class="left">
            <img src="humming-bird.png" alt="">
        </div>
        <div class="right">
            <div class="title">Contact us</div>
            <?php
            //выводим все сообщения об ошибках
            //это блок ошибок
                if (!empty($messages)) {
                    print('<div id="messages">');
                    // Выводим все сообщения.
                    foreach ($messages as $message) {
                        print($message);
                    }

                print('</div>');
                }

    //дальше выводим форму,отмечаем элементы с ошибками калссом error
    //задаем начальные значения элементов ранними
    ?>
            <div class="title-name">
                Your name
            </div>
            <input type="text" name="name" class="text <?php if ($errors['name']) {print '';} ?>" value="<?php print $values['name']; ?>"><br>
            <div class="title-mail">
                Your email address
            </div>
            <input type="email" name="mail" class="text <?php if ($errors['mail']) {print '';} ?>" value="<?php print $values['mail']; ?>"><br>

            <div class="sub">
                <div class="sub-left">
                <input name="year" type="date" class="year <?php if ($errors['year']) {print '';} ?>" value="<?php print $values['year']; ?>" />

                    <div class="sex">
                        <div class="sex-text">You are:</div>
                        <input type="radio" name="sex" value="man" <?php if ($values['sex']=='man') {print 'checked';}?> checked>
                        <label for="man">Man</label>
                        <input type="radio" name="sex" value="woman" <?php if ($values['sex']=='woman') {print 'checked';}?>>
                        <label for="woman">Woman</label> <br>
                    </div>

                    <div class="limbs">
                        Limbs:
                        <input type="radio" name="limbs" value="4" <?php if ($values['limbs']=='4') {print 'checked';} ?> checked>
                        <label for="4">4</label>
                        <input type="radio" name="limbs" value="6" <?php if ($values['limbs']=='6') {print 'checked';} ?> >
                        <label for="6">6</label>
                        <input type="radio" name="limbs" value="8" <?php if ($values['limbs']=='8') {print 'checked';} ?>>
                        <label for="8">8</label><br>
                    </div>
                </div>
                <div class="sub-right">
                    <div class="title-skills">
                        Skills:
                    </div>
                    <select multiple class="skills <?php if ($errors['skills']) {print 'skills';} ?>" name="skills[]">
                        <option value="1" <?php if(!empty($values['skills'][0])) {if ($values['skills'][0]=='1') {print 'selected';}} ?>>Kind</option>
                        <option value="2" <?php if(!empty($values['skills'][1])) {if ($values['skills'][1]=='2') {print 'selected';}} ?>>Honest</option>
                        <option value="3" <?php if(!empty($values['skills'][2])) {if ($values['skills'][2]=='3') {print 'selected';}} ?>>Funny</option>
                    </select><br>
                </div>
            </div>
        
            <br>
            <textarea rows="4" placeholder="Your bio" name="bio" class="<?php if ($errors['bio']) {print '';} ?>"><?php print $values['bio']; ?></textarea><br>

            <input type="checkbox" name="agree" value="1" class="agree <?php if ($errors['agree']) {print '';} ?>" <?php if ($values['agree']=='1') {print 'checked';} ?>>
            <label for="agree" >I am familiar with the contract</label><br>

            <input type="submit" class="btn" value="Submit" />
        </div>
    </form>

</body>
</html>
