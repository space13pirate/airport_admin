<?php
session_start();
include('assets/inc/config.php');
include('assets/inc/checklogin.php');
check_login();
$aid = $_SESSION['pass_id'];

if (isset($_POST['Update_Password'])) {
    $aid = $_SESSION['pass_id'];
    $pass_pwd = sha1(md5($_POST['pass_pwd']));
    $query = "update  airport_passenger set pass_pwd = ? where pass_id=?";
    $stmt = $mysqli->prepare($query);
    $rc = $stmt->bind_param('si', $pass_pwd, $aid);
    $stmt->execute();
    if ($stmt) {
        $succ1 = "Ваш пароль был изменён";
    } else {
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
            <h2 class="page-head-title">Изменение пароля</h2>
            <!-- Хлебные крошки для навигации -->
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb page-head-nav">
                    <li class="breadcrumb-item"><a href="pass-dashboard.php">Панель информации</a></li>
                    <li class="breadcrumb-item"><a href="pass-profile.php">Профиль</a></li>
                    <li class="breadcrumb-item active">Изменение пароля</li>
                </ol>
            </nav>
        </div>

        <!--Активация Sweet Alert -->
        <?php if (isset($succ1)) { ?>
            <!-- Вставка уведомления об успехе -->
            <script>
                setTimeout(function () {
                        swal("Успешно!", "<?php echo $succ1;?>", "success");
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
            <div class="col-md-12">
                <div class="card card-border-color card-border-color-success">
                    <div class="card-header card-header-divider">Измените Ваш пароль<span class="card-subtitle">Заполните все поля</span>
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <!-- Форма для изменения пароля -->
                            <div class="form-group row">
                                <label class="col-12 col-sm-3 col-form-label text-sm-right" for="inputText3">Старый пароль</label>
                                <div class="col-12 col-sm-8 col-lg-6">
                                    <input class="form-control" name="" id="inputText3" type="password">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-12 col-sm-3 col-form-label text-sm-right" for="inputText3">Новый пароль</label>
                                <div class="col-12 col-sm-8 col-lg-6">
                                    <input class="form-control" name="pass_pwd" id="inputText3" type="password">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-12 col-sm-3 col-form-label text-sm-right" for="inputText3">Подтвердите новый пароль</label>
                                <div class="col-12 col-sm-8 col-lg-6">
                                    <input class="form-control" name="" id="inputText3" type="password">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <p class="text-right">
                                    <input class="btn btn-space btn-success" value="Изменить пароль"
                                           name="Update_Password" type="submit">
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

<!-- Footer-->
<?php include('assets/inc/footer.php'); ?>
<!-- Конец Footer-->

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