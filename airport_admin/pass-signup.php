<?php
session_start(); // Начало новой сессии или восстановление существующей
include('assets/inc/config.php'); // Подключение файла конфигурации
// Проверка отправки формы входа
if (isset($_POST['pass_register'])) {
    // Получение данных формы
    $pass_lname = $_POST['pass_lname'];
    $pass_fname = $_POST['pass_fname'];
    $pass_mname = $_POST['pass_mname'];
    $pass_bday = $_POST['pass_bday'];
    $pass_passport = $_POST['pass_passport'];
    $pass_phone = $_POST['pass_phone'];
    $pass_addr = $_POST['pass_addr'];
    $pass_uname = $_POST['pass_uname'];
    $pass_email = $_POST['pass_email'];
    $pass_pwd = sha1(md5($_POST['pass_pwd']));


    $query = "insert into airport_passenger (pass_lname, pass_fname, pass_mname, pass_bday, pass_passport, pass_phone, pass_addr, pass_uname, pass_email, pass_pwd) values(?,?,?,?,?,?,?,?,?,?)";
    $stmt = $mysqli->prepare($query); // Выполнение запроса
    // Привязка переменных к параметрам подготовленного запроса
    $rc = $stmt->bind_param('ssssssssss', $pass_lname, $pass_fname, $pass_mname, $pass_bday, $pass_passport, $pass_phone, $pass_addr, $pass_uname, $pass_email, $pass_pwd);
    $stmt->execute();// Выполнение запроса

    // Сообщение об успешной регистрации
    if ($stmt) {
        $success = "Учётная запись пассажира создана";
    } else {
        // Вывод ошибки, если что-то пошло не так
        $err = "Пожалуйста, повторите попытку позже";
    }
}
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="author" content="Арина Наймушина, Анастасия Черемисова">
    <link rel="shortcut icon" href="assets/img/favicon.ico">
    <title>Регистрация пассажира</title>
    <link rel="stylesheet" type="text/css" href="assets/lib/perfect-scrollbar/css/perfect-scrollbar.css"/>
    <link rel="stylesheet" type="text/css"
          href="assets/lib/material-design-icons/css/material-design-iconic-font.min.css"/>
    <link rel="stylesheet" href="assets/css/app.css" type="text/css"/>
</head>
<body class="be-splash-screen">
<div class="be-wrapper be-login">
    <div class="be-content">
        <div class="main-content container-fluid">
            <div class="splash-container">
                <div class="card card-border-color card-border-color-success">
                    <div class="card-header"><img class="logo-img" src="assets/img/logo-xx.png" alt="logo"
                                                  width="{conf.logoWidth}" height="27"><span class="splash-description">Форма для регистрации пассажира</span>
                    </div>
                    <div class="card-body">

                        <!--Активация Sweet Alert -->
                        <?php if (isset($success)) { ?>
                        <script>
                            setTimeout(function () {
                                swal("Успешно!", "<?php echo $success;?>", "success").then((value) => {
                                    window.location.href = 'pass-login.php';
                                });
                            }, 100);
                        </script>
                        <?php } ?>
                        <?php if (isset($err)) { ?>
                            <!-- Код в случае ошибочной регистрации -->
                            <script>
                                setTimeout(function () {
                                        swal("Не удалось зарегистрироваться!", "<?php echo $err;?>!", "Failed");
                                    },
                                    100);
                            </script>

                        <?php } ?>

                        <!--Форма регистрации-->
                        <form method="POST">
                            <div class="login-form">

                                <!--Фамилия-->
                                <div class="form-group">
                                    <input class="form-control" name="pass_lname" type="text" placeholder="Фамилия" autocomplete="off" required>
                                </div>

                                <!--Имя-->
                                <div class="form-group">
                                    <input class="form-control" name="pass_fname" type="text" placeholder="Имя" autocomplete="off" required>
                                </div>

                                <!--Отчество-->
                                <div class="form-group">
                                    <input class="form-control" name="pass_mname" type="text" placeholder="Отчество" autocomplete="off" required>
                                </div>

                                <!--Дата рождения-->
                                <div class="form-group">
                                    <input class="form-control" name="pass_bday" type="date" placeholder="Дата рождения" autocomplete="off" required>
                                </div>

                                <!--Пасспорт-->
                                <div class="form-group">
                                    <input class="form-control" name="pass_passport" type="text" placeholder="Паспорт" autocomplete="off" required>
                                </div>

                                <!--Телефон-->
                                <div class="form-group">
                                    <input class="form-control" name="pass_phone" type="text" placeholder="Телефон" autocomplete="off" required>
                                </div>

                                <!--Адрес-->
                                <div class="form-group">
                                    <input class="form-control" name="pass_addr" type="text" placeholder="Адрес" autocomplete="off" required>
                                </div>

                                <!--Эл. почта-->
                                <div class="form-group">
                                    <input class="form-control" name="pass_email" type="email" placeholder="Эл. почта" autocomplete="off" required>
                                </div>

                                <!--Имя пользователя-->
                                <div class="form-group">
                                    <input class="form-control" name="pass_uname" type="text" placeholder="Имя пользователя" autocomplete="off">
                                </div>

                                <!--Пароль-->
                                <div class="form-group">
                                    <input class="form-control" name="pass_pwd" type="password" placeholder="Пароль" required>
                                </div>

                                <div class="form-group row login-submit">
                                    <div class="col-6">
                                        <a class="btn btn-outline-success btn-xl" href="pass-login.php">Войти</a>
                                    </div>
                                    <div class="col-6">
                                        <input type="submit" name="pass_register" class="btn btn-outline-danger btn-xl" value="Зарегистрироваться">
                                    </div>
                                </div>

                            </div>
                        </form>
                        <!--Конец формы входа-->

                        <!-- Ссылка на главную страницу -->
                        <div class="splash-footer">Вернуться на <a href="index.php">главную страницу</a></div>
                    </div>
                </div>
                <!-- Авторские права и разработчики -->
                <div class="splash-footer">&copy; 2023 - <?php echo date('Y'); ?> АРМ администратора аэропорта |
                    Разработчики: Арина Наймушина, Анастасия Черемисова
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>

<!-- Подключение JavaScript библиотек -->
<script src="assets/lib/jquery/jquery.min.js" type="text/javascript"></script>
<script src="assets/lib/perfect-scrollbar/js/perfect-scrollbar.min.js" type="text/javascript"></script>
<script src="assets/lib/bootstrap/dist/js/bootstrap.bundle.min.js" type="text/javascript"></script>
<script src="assets/js/app.js" type="text/javascript"></script>
<script src="assets/js/swal.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        // Инициализация JavaScript
        App.init();
    });
</script>
</body>
</html>