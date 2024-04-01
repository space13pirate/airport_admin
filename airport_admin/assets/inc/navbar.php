<?php
/* Серверный код для получения деталей одного пассажира по id */
// Получение ID пассажира из сессии
$aid = $_SESSION['pass_id'];
// SQL-запрос для получения данных пассажира
$ret = "select * from airport_passenger where pass_id=?";
// Подготовка SQL-запроса к выполнению
$stmt = $mysqli->prepare($ret);
// Привязка параметров к местам-заполнителям в запросе
$stmt->bind_param('i', $aid);
// Выполнение запроса
$stmt->execute();
// Получение результатов запроса
$res = $stmt->get_result();

// Перебор результатов запроса
while ($row = $res->fetch_object()) {
    ?>
    <nav class="navbar navbar-expand fixed-top be-top-header">
        <div class="container-fluid">
            <!-- Ссылка на главную страницу панели управления -->
            <div class="be-navbar-header"><a class="navbar-brand" href="pass-dashboard.php"></a>
            </div>
            <div class="page-title"><span>
          <?php
          // Определение приветствия в зависимости от времени суток
          $welcome_string = "Добро пожаловать";
          date_default_timezone_set('Europe/Moscow');
          $numeric_date = date("G");
          if ($numeric_date >= 5 && $numeric_date <= 11)
              $welcome_string = "Доброе утро, ";
          else if ($numeric_date >= 12 && $numeric_date <= 17)
              $welcome_string = "Добрый день, ";
          else if ($numeric_date >= 18 && $numeric_date <= 23)
              $welcome_string = "Добрый вечер, ";
          else if ($numeric_date >= 0 && $numeric_date <= 4)
              $welcome_string = "Доброй ночи, ";
          echo "$welcome_string"; // Вывод приветствия
          ?>

          <?php echo $row->pass_uname; // Вывод имени пользователя ?></span></div>

            <div class="be-right-navbar">
                <ul class="nav navbar-nav float-right be-user-nav">
                    <!-- Меню пользователя -->
                    <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" role="button" aria-expanded="false">
                            <img src="assets/img/profile/<?php echo $row->pass_avatar; ?>" alt="Avatar"> <!-- Изображение профиля пользователя -->
                            <span class="user-name"></span></a>
                        <div class="dropdown-menu" role="menu">
                            <a class="dropdown-item" href="pass-profile.php"><span class="icon mdi mdi-face"></span>Профиль</a <!-- Ссылка на профиль -->
                            <a class="dropdown-item" href="pass-logout.php"><span class="icon mdi mdi-power"></span>Выйти</a> <!-- Ссылка для выхода -->
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
<?php } ?>