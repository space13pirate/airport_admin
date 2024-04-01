<!-- Серверный код для регистрации пассажиров -->
<?php
session_start();                    // Начало новой сессии или восстановление существующей
include('assets/inc/config.php');   // Подключение файла конфигурации

// Проверка, была ли отправлена форма сброса пароля
if (isset($_POST['Pwd_reset'])) {
    // Получение электронной почты из формы
    $email = $_POST['email'];
    // Установка статуса запроса на сброс пароля как 'Pending'
    $status = 'Pending';

    // SQL-запрос на вставку данных о запросе сброса пароля
    $query = "insert into airport_passwordresets (email, status) values(?,?)";
    // Подготовка SQL-запроса к выполнению
    $stmt = $mysqli->prepare($query);
    // Привязка параметров к местам плейсхолдерам в SQL-запросе
    $rc = $stmt->bind_param('ss', $email, $status);
    // Выполнение подготовленного запроса
    $stmt->execute();

    // Проверка успешности выполнения запроса
    if ($stmt) {
        // Установка сообщения об успехе
        $success = "Администратор получил заявку на сброс пароля.\\nСкоро он с Вами свяжется";
    } else {
        // Установка сообщения об ошибке
        $err = "Пожалуйста, попробуйте ещё раз или попробуйте позже.";
    }
}
?>
<!-- Конец серверного кода -->

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="author" content="Арина Наймушина, Анастасия Черемисова">
    <link rel="shortcut icon" href="assets/img/favicon.ico">
    <title>Аэропортал</title>
    <link rel="stylesheet" type="text/css" href="assets/lib/perfect-scrollbar/css/perfect-scrollbar.css"/>
    <link rel="stylesheet" type="text/css"
          href="assets/lib/material-design-icons/css/material-design-iconic-font.min.css"/>
    <link rel="stylesheet" href="assets/css/app.css" type="text/css"/>
</head>

<body class="be-splash-screen">
<div class="be-wrapper be-login">
    <div class="be-content">
        <div class="main-content container-fluid">
            <div class="splash-container forgot-password">
                <div class="card card-border-color card-border-color-success">
                    <div class="card-header">
                        <img class="logo-img" src="assets/img/logo-xx.png" alt="logo" width="102" height="#{conf.logoHeight}">
                        <span class="splash-description">Забыли пароль?</span>
                    </div>
                    <div class="card-body">
                        <!--Активация Sweet Alert -->
                        <?php if (isset($success)) { ?>
                            <!-- Вставка уведомления об успехе -->
                            <script>
                                setTimeout(function () {
                                        swal("Успешно!", "<?php echo $success;?>", "success");
                                    },
                                    100);
                            </script>
                        <?php } ?>

                        <?php if (isset($err)) { ?>
                            <!-- Вставка уведомления об ошибке -->
                            <script>
                                setTimeout(function () {
                                        swal("Не удалось!", "<?php echo $err;?>", "Failed");
                                    },
                                    100);
                            </script>
                        <?php } ?>

                        <!-- Форма сброса пароля -->
                        <form method="POST">
                            <p>Не беспокойтесь, сообщите Администратору свою<br>эл. почту, и он с Вами свяжется.</p>
                            <div class="form-group pt-4">
                                <input class="form-control" type="email" name="email" required="" placeholder="Ваша эл. почта" autocomplete="off">
                            </div>
                            <p class="pt-1 pb-4">Не помните свою электронную почту? <br><a href="https://t.me/space13pirate">Свяжитесь со службой поддержки</a></p>
                            <div class="form-group pt-1"><input type="submit" name="Pwd_reset" class="btn btn-block btn-primary btn-xl" value="Сбросить пароль"></div>
                        </form>
                        <!-- Конец формы сброса пароля -->
                    </div>
                </div>

                <!-- Ссылка на главную страницу -->
                <div class="splash-footer"><a href="index.php">Главная страница</a></div>
                <!-- Авторские права и разработчики -->
                <div class="splash-footer">
                    &copy; 2023 - <?php echo date('Y'); ?> АРМ администратора аэропорта |<br>
                    Разработчики: Арина Наймушина, Анастасия Черемисова
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