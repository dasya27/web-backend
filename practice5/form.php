<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
  <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="style.css">
  <script defer src="script.js"></script>

  <title>Контактная форма</title>
</head>
<body>
  <div class="p-0 card text-bg-light" id="form">
    <div class="card-header">
      <h4>Свяжитесь с нами</h4>
    </div>
    <div class="card-body">
      <div class="card-text">
        <form action="" method="POST">

          <div class="row mb-2">
            <div class="col-md-8 mb-4 mb-md-0">
              <label for="name" class="form-label">Имя</label>
              <input type="text" class="form-control <?php print($err['name'] ? "is-invalid" : ($values['name'] ? "is-valid" : ""))?>" 
                id="name" name="name" value=<?php print($values['name'])?>>

              <label for="email" class="form-label">E-mail:</label>
              <input type="email" class="form-control <?php print($err['email'] ? "is-invalid" : ($values['email'] ? "is-valid" : ""))?>" id="email" name="email" value=<?php print($values['email'])?>>
              
              <label for="birthday" class="form-label" id="<?php print($err['birthday'] ? "error" : ($values['birthday'] ? "success" : ""))?>">Дата рождения:</label> <br>
              <input type="date" id="birthday" name="birthday" value=<?php print($values['birthday'])?>>
              
            </div>
            
            <div class="col-md-4">
              <p  id="<?php print($err['gender'] ? "error" : ($values['gender'] ? "success" : ""))?>">Пол:</p>
              <input class="form-check-input" <?php print($values["gender"] == "male" ? "checked" : "")?> type="radio" name="gender" value="male" id="gender-male">
              <label class="form-check-label me-2" for="gender-male">Мужской</label>
              <input class="form-check-input" <?php print($values["gender"] == "female" ? "checked" : "")?> type="radio" name="gender" value="female" id="gender-female">
              <label class="form-check-label" for="gender-female">Женский</label>
              
              <p id="<?php print($err['limbs'] ? "error" : ($values['limbs'] ? "success" : ""))?>" class="mt-3">Количество конечностей:</p>
              <input class="form-check-input" value="4" <?php print($values["limbs"] == "4" ? "checked" : "")?> type="radio" name="limbs" id="limbs">
              <label class="form-check-label me-2" for="limbs">4</label>
              <input class="form-check-input" value="8" <?php print($values["limbs"] == "8" ? "checked" : "")?> type="radio" name="limbs" id="limbs">
              <label class="form-check-label me-2" for="limbs">8</label>
              <input class="form-check-input" value="12" <?php print($values["limbs"] == "12" ? "checked" : "")?> type="radio" name="limbs" id="limbs">
              <label class="form-check-label me-2" for="limbs">12</label>
              
            </div>
          </div>
          
          <div class="row mb-2 mt-4">
  
            <div class="col-md-4" id="abilities">
  
              <p>Сверхспособности:</p>
              <select class="form-select <?php print($err['abilities'] ? "is-invalid" : ($values['abilities'] ? "is-valid" : ""))?>" name="abilities[]" multiple="multiple">
                <option value="immortality" <?php print(!empty($values["abilities"]) && (in_array("immortality", $values["abilities"]) || in_array(1, $values["abilities"]))? "selected" : "")?>>Бессмертие</option>
                <option value="fireball" <?php print(!empty($values["abilities"]) && (in_array("fireball", $values["abilities"]) || in_array(2, $values["abilities"])) ? "selected" : "")?>>Огненный шар</option>
                <option value="levitation" <?php print(!empty($values["abilities"]) && (in_array("levitation", $values["abilities"]) || in_array(3, $values["abilities"]))? "selected" : "")?>>Левитация</option>
              </select><br>
            </div>
            
            <div class="col-md-8">
              <p>Расскажите о себе:</p>
              <textarea class="form-control <?php print($err['bio'] ? "is-invalid" : ($values['bio'] ? "is-valid" : ""))?>" name="bio" id="biography" style="min-height: 120px"><?php print($values['bio'])?></textarea>
            </div>
          </div>
          
          <div class="col">
            <div>
              <input class="form-check-input <?php print($err['contract'] ? "is-invalid" : ($values['contract'] ? "is-valid" : ""))?>" <?php print($values["contract"] == "on" ? "checked=\"checked\"" : "")?> type="checkbox" id="contract" name="contract">
              <label class="form-check-label" for="contract">С контрактом ознакомлен(-а)</label>
            </div>

            <input class="btn btn-primary mt-3" type="submit" value="Отправить">
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="card errors" style="display: <?php print(empty($msg) ? "none" : "block")?>" id="form">
    <!-- если есть сообщения об ошибках от сервера, выводим их в нижнюю панель -->
    <!-- если данные были успешно обработаны, выводим сообщение об этом так же в нижнюю панель -->
    <?php
      if (!empty($msg)) {
        print('<div id="messages">');
        foreach($msg as $m) {
          print($m);
        }
        print('</div>');
      }
    ?>
    

  </div>

</body>
</html>
