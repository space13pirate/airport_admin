<?php
session_start();
include('assets/inc/config.php');
include('assets/inc/checklogin.php');
check_login();
$aid = $_SESSION['pass_id'];

// Проверка, была ли отправлена форма обновления фотографии профиля
if (isset($_POST['Update_profile_pic'])) {
    // Получение имени файла фотографии профиля
    $pass_avatar = $_FILES["pass_avatar"]["name"];
    // Перемещение загруженного файла в папку с изображениями профиля
    move_uploaded_file($_FILES["pass_avatar"]["tmp_name"], "assets/img/profile/" . $_FILES["pass_avatar"]["name"]);
    // Подготовка запроса на обновление фотографии профиля в базе данных
    $query = "update  airport_passenger set pass_avatar = ? where pass_id=?";
    $stmt = $mysqli->prepare($query);
    // Привязываем параметры к запросу
    $rc = $stmt->bind_param('si', $pass_avatar, $aid);
    $stmt->execute();
    // Проверка успешности выполнения запроса
    if ($stmt) {
        // Сообщение об успешном обновлении
        $succ = "Фото профиля успешно обновлено";
    } else {
        // Сообщение об ошибке
        $err = "Пожалуйста, повторите попытку позже";
    }
}
?>


<!DOCTYPE html>
<html lang="ru">

<!--Head-->
<?php include('assets/inc/head.php'); ?>
<!--Конец Head-->

<body>
<div class="be-wrapper be-fixed-sidebar ">
    <!--Navigation Bar-->
    <?php include('assets/inc/navbar.php'); ?>
    <!--Конец Navigation Bar-->

    <!--Sidebar-->
    <?php include('assets/inc/sidebar.php'); ?>
    <!--Конец Sidebar-->

    <div class="be-content">
        <div class="page-head">
            <h2 class="page-head-title">Профиль пассажира</h2>
            <!-- Хлебные крошки для навигации -->
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb page-head-nav">
                    <li class="breadcrumb-item"><a href="pass-dashboard.php">Панель информации</a></li>
                    <li class="breadcrumb-item"><a href="pass-profile.php">Профиль</a></li>
                    <li class="breadcrumb-item active">Обновление фото профиля</li>
                </ol>
            </nav>
        </div>

        <!--Активация Sweet Alert -->
        <?php if (isset($succ)) { ?>
            <!-- Вставка уведомления об успехе -->
            <script>
                setTimeout(function () {
                        swal("Успешно!", "<?php echo $succ;?>!", "success");
                    },
                    100);
            </script>
        <?php } ?>

        <?php if (isset($succ1)) { ?>
            <!-- Вставка уведомления об успехе -->
            <script>
                setTimeout(function () {
                        swal("Успешно!", "<?php echo $succ1;?>!", "success");
                    },
                    100);
            </script>
        <?php } ?>

        <?php if (isset($err)) { ?>
            <!-- Вставка уведомления об ошибке -->
            <script>
                setTimeout(function () {
                        swal("Не удалось!", "<?php echo $err;?>!", "Failed");
                    },
                    100);
            </script>
        <?php } ?>

        <!-- Основной контент страницы -->
        <div class="main-content container-fluid">
            <?php
            $aid = $_SESSION['pass_id'];
            $ret = "select * from airport_passenger where pass_id=?";
            $stmt = $mysqli->prepare($ret);
            $stmt->bind_param('i', $aid);
            $stmt->execute();
            $res = $stmt->get_result();
            while ($row = $res->fetch_object())
            {
            ?>
            <div class="row">
                <div class="col-md-12">
                    <!-- Форма для обновления фото профиля -->
                    <div class="card card-border-color card-border-color-success">
                        <div class="card-header card-header-divider">Обновить фото Вашего профиля</div>
                        <div class="card-body">
                            <form method="POST" enctype="multipart/form-data">
                                <div class="form-group row">
                                    <label class="col-12 col-sm-3 col-form-label text-sm-right" for="inputText3">Выберите новое фото профиля</label>
                                    <div class="col-12 col-sm-8 col-lg-6">
                                        <input class="btn" name="pass_avatar" id="inputText3" type="file">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <p class="text-right">
                                        <input class="btn btn-space btn-success" value="Обновить профиль"
                                               name="Update_profile_pic" type="submit">
                                        <button class="btn btn-space btn-danger">Отмена</button>
                                    </p>
                                </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>

    </div>
    <!--footer-->
    <?php include('assets/inc/footer.php'); ?>
    <!--КонецFooter-->
</div>

<!-- Подключение JavaScript библиотек -->
<script src="assets/lib/jquery/jquery.min.js" type="text/javascript"></script>
<script src="assets/lib/perfect-scrollbar/js/perfect-scrollbar.min.js" type="text/javascript"></script>
<script src="assets/lib/bootstrap/dist/js/bootstrap.bundle.min.js" type="text/javascript"></script>
<script src="assets/js/app.js" type="text/javascript"></script>
<script src="assets/lib/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
<script src="assets/lib/jquery.nestable/jquery.nestable.js" type="text/javascript"></script>
<script src="assets/lib/moment.js/min/moment.min.js" type="text/javascript"></script>
<script src="assets/lib/datetimepicker/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
<script src="assets/lib/select2/js/select2.min.js" type="text/javascript"></script>
<script src="assets/lib/select2/js/select2.full.min.js" type="text/javascript"></script>
<script src="assets/lib/bootstrap-slider/bootstrap-slider.min.js" type="text/javascript"></script>
<script src="assets/lib/bs-custom-file-input/bs-custom-file-input.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function () {
        // Инициализация JavaScript
        App.init();
        App.formElements();
    });
</script>
</body>

</html>