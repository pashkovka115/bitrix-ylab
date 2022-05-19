<?php
/*
  * 2) Создать форму с полями: Имя, Фамилия и кнопка “Отправить”.
  * После нажатия на кнопку на странице должны отобразиться данные из формы. В виде строки “Привет, (Фамилия) (Имя)”.
  */
?>
<form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
  <label for="name">Имя</label><br>
  <input type="text" name="name" id="name"><br><br>

  <label for="lastname">Фамилия</label><br>
  <input type="text" name="lastname" id="lastname"><br><br>

  <input type="submit" value="Отправить">
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
  echo 'Привет, ' . ($_POST['lastname'] ?? '') . ' ' . ($_POST['name'] ?? '') . '.';
}
