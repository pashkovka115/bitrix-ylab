<?php
/*
  * 2) Создать форму с полями: Имя, Фамилия и кнопка “Отправить”.
  * После нажатия на кнопку на странице должны отобразиться данные из формы. В виде строки “Привет, (Фамилия) (Имя)”.
  */
/*
 * 4) Доработать форму из пункта 2. При отправки формы, сохранять Имя и Фамилию в БД.
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
  if ($_POST['lastname'] or $_POST['name']){
      echo 'Привет, ' . ($_POST['lastname'] ?? '') . ' ' . ($_POST['name'] ?? '') . '.';
  }

    $user = 'root';
    $password = '';
    $dbname = 'ylab';
    $table_name = 'users';
    $dsn = "mysql:dbname=$dbname;host=127.0.0.1";

    try
    {
        $dbh = new PDO($dsn, $user, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
    }catch (PDOException $e){
      echo "<b>Ошибка соединения с базой данных($dbname): </b>" . $e->getMessage();
    }
    if (!isset($dbh)){
      return;
    }

    try
    {
        // Таблица в базе данных создаётся автоматически
        $flag = true;
        foreach ($dbh->query('SHOW TABLES', PDO::FETCH_NUM) as $table){
          foreach ($table as $tbname){
              if($tbname == $table_name){
                  $flag = false;
                  break;
              }
          }
        }

        if($flag){
            $dbh->exec("CREATE TABLE `$table_name` (
                                  `id` int(11) NOT NULL,
                                  `name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
                                  `lastname` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL
                                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");

            $dbh->exec("ALTER TABLE `$table_name` ADD PRIMARY KEY (`id`);");
            $dbh->exec("ALTER TABLE `$table_name` CHANGE `id` `id` INT(11) NOT NULL AUTO_INCREMENT;");
        }


    }catch (PDOException $e){
      echo '<b>Ошибка создания таблицы: </b>' . $e->getMessage();
    }


    try
    {
      if ($_POST['lastname'] or $_POST['name']){

        $sth = $dbh->prepare('INSERT INTO `users` (`name`, `lastname`) VALUES (:name, :lastname)');
        $sth->execute([':name' => clearData($_POST['name']), ':lastname' => clearData($_POST['lastname'])]);

        echo '<p>Данные сохранены.</p>';

      }else{
        echo '<p>Нет данных для записи в базу данных</p>';
      }
    }catch (PDOException $e){
        echo '<b>Ошибка записи в базу данных: </b>' . $e->getMessage();
    }

}

function clearData($data){
  // todo: Здесь можно очистить сырые данные. Например вырезать тэги или javascript. Зависит от того что надо получить.

    return htmlspecialchars(strip_tags($data), ENT_QUOTES);
}
