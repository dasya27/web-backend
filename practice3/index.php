<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>web3</title>

    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap" rel="stylesheet">


</head>
<body>
    <form action="form.php" method="post">
        <div class="left">
            <img src="humming-bird.png" alt="">
        </div>
        <div class="right">
        <div class="title">Contact us</div>
        <div class="title-name">
            Your name
        </div>
        <input type="text" name="name" class="text" required><br>
        <div class="title-mail">
            Your email address
        </div>
        <input type="email" name="mail" class="text" required><br>

        <div class="sub">
            <div class="sub-left">
                <select name="year" class="year" required>
                    <option value="">Choose year</option>
                    <?php
                        for ($year = 2004; $year < 2023; $year++) {
                            echo '<option '.$selected.' value="'.$year.'">'.$year.'</option>';
                        }
                    ?>
                </select><br>

                <div class="sex">
                    <div class="sex-text">You are:</div>
                    <input type="radio" name="sex" value="man" checked>
                    <label for="man">Man</label>
                    <input type="radio" name="sex" value="woman">
                    <label for="woman">Woman</label> <br>
                </div>

                <div class="limbs">
                    Limbs:
                    <input type="radio" name="limbs" value="4" checked>
                    <label for="4">4</label>
                    <input type="radio" name="limbs" value="6">
                    <label for="6">6</label>
                    <input type="radio" name="limbs" value="8">
                    <label for="8">8</label><br>
                </div>
            </div>
            <div class="sub-right">
                <div class="title-skills">
                    Skills:
                </div>
                <select multiple class="skills" name="skills[]" required>
                    <option value="1">Kind</option>
                    <option value="2">Honest</option>
                    <option value="3">Funny</option>
                </select><br>
            </div>
        </div>

        <br>
        <textarea rows="4" placeholder="Your bio" name="bio" required></textarea><br>

        <input type="checkbox" name="agree" value="yes" class="agree" required>
        <label for="agree" >I am familiar with the contract</label><br>

        <input type="submit" class="btn" value="Submit" />
        </div>
    </form>

</body>
</html>
