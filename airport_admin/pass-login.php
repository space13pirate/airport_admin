<!-- Серверный код для входа в систему -->
<?php
session_start(); // Начало новой сессии или восстановление существующей
include('assets/inc/config.php'); // Подключение файла конфигурации

// Проверка отправки формы входа
if (isset($_POST['pass_login'])) {
    // Получение данных формы
    $pass_email = $_POST['pass_email'];
    // Шифрование пароля с использованием sha1 и md5 для повышения безопасности
    $pass_pwd = sha1(md5($_POST['pass_pwd']));

    // Подготовка SQL-запроса для проверки данных пользователя
    $stmt = $mysqli->prepare("SELECT pass_email ,pass_pwd , pass_id FROM airport_passenger WHERE pass_email=? and pass_pwd=? ");
    // Привязка переменных к параметрам подготовленного запроса
    $stmt->bind_param('ss', $pass_email, $pass_pwd);
    $stmt->execute(); // Выполнение запроса
    $stmt->bind_result($pass_email, $pass_pwd, $pass_id); // Привязка результатов запроса к переменным
    $rs = $stmt->fetch(); // Получение результатов запроса
    $_SESSION['pass_id'] = $pass_id; // Сохранение ID пассажира в сессии

    // Перенаправление на панель бронирования рейсов в случае успешного входа
    if ($rs) {
        header("location:pass-dashboard.php");
    } else {
        // Вывод ошибки, если данные неверны
        $error = "Доступ запрещён.\\nПожалуйста, проверьте свои учётные данные...";
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
    <title>Вход в Аэропортал</title>
    <link rel="stylesheet" type="text/css" href="assets/lib/perfect-scrollbar/css/perfect-scrollbar.css"/>
    <link rel="stylesheet" type="text/css"
          href="assets/lib/material-design-icons/css/material-design-iconic-font.min.css"/>
    <link rel="stylesheet" href="assets/css/app.css" type="text/css"/>

    <!--Активация Sweet Alert -->
    <?php if (isset($error)) { ?>
        <!-- Код для уведомления -->
        <script>
            setTimeout(function () {
                    swal("Не удалось войти!", "<?php echo $error;?>!", "error");
                },
                100);
        </script>

    <?php } ?>
</head>
<body class="be-splash-screen">
<div class="be-wrapper be-login">
    <div class="be-content">
        <div class="main-content container-fluid">
            <div class="splash-container">
                <div class="card card-border-color card-border-color-success">
                    <!-- Логотип и описание -->
                    <div class="card-header">
                        <img class="logo-img" src="assets/img/logo-xx.png" alt="logo" width="{conf.logoWidth}"
                             height="27">
                        <span class="splash-description">Панель входа для пассажира</span>
                    </div>
                    <div class="card-body">

                        <!-- Форма входа -->
                        <form method="POST">
                            <div class="login-form ">

                                <!-- Поля для ввода email и пароля -->
                                <div class="form-group">
                                    <input class="form-control" name="pass_email" type="text" placeholder="Эл. почта">
                                </div>

                                <div class="form-group">
                                    <input class="form-control" name="pass_pwd" type="password" placeholder="Пароль">
                                </div>

                                <!-- Блок инструментов для входа -->
                                <div class="form-group row login-tools">
                                    <!-- Колонка с ссылкой для сброса забытого пароля -->
                                    <div class="col-8 login-forgot-password"><a href="pass-pwd-forgot.php">Забыли
                                            пароль?</a></div>
                                </div>
                                <!-- Конец блока инструментов для входа -->

                                <div class="form-group row login-submit">
                                    <div class="col-6"><a class="btn btn-danger btn-xl" href="pass-signup.php">Регистрация</a>
                                    </div>
                                    <div class="col-6"><input type="submit" name="pass_login" class="btn btn-success btn-xl" value="Войти"></div>
                                </div>
                            </div>
                        </form>
                        <!-- Конец формы входа -->

                        <!-- Ссылка на главную страницу -->
                        <div class="splash-footer">Вернуться на <a href="index.php">главную страницу</a></div>
                    </div>
                </div>
                <!-- Авторские права и разработчики -->
                <div class="splash-footer">
                    &copy; 2023 - <?php echo date('Y'); ?> АРМ администратора аэропорта |<br>
                    Разработчики: Арина Наймушина, Анастасия Черемисова
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