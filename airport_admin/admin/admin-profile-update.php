<?php
session_start();
include('assets/inc/config.php');
include('assets/inc/checklogin.php');
check_login();
$aid = $_SESSION['admin_id'];

// Обрабатываем отправку формы обновления профиля
if (isset($_POST['Update_Profile'])) {
    // Получаем значения из формы
    $admin_fname = $_POST['admin_fname'];
    $admin_lname = $_POST['admin_lname'];
    $admin_email = $_POST['admin_email'];
    $admin_uname = $_POST['admin_uname'];
    // Создаём запрос на обновление данных администратора
    $query = "update airport_admin set admin_fname = ?, admin_lname = ?,  admin_email = ?, admin_uname = ? where admin_id=?";
    $stmt = $mysqli->prepare($query);
    // Привязываем параметры к запросу
    $rc = $stmt->bind_param('ssssi', $admin_fname, $admin_lname, $admin_email, $admin_uname, $aid);
    $stmt->execute();
    // Проверяем успешность выполнения запроса
    if ($stmt) {
        $succ = "Ваш профиль был обновлён";
    } else {
        $err = "Пожалуйста, повторите попытку позже";
    }
}
?>

<!DOCTYPE html>
<html lang="ru">

<!-- Header -->
<?php include('assets/inc/head.php'); ?>
<!-- Конец Header -->

<body>
<div class="be-wrapper be-fixed-sidebar ">

    <!-- Navigation Bar -->
    <?php include('assets/inc/navbar.php'); ?>
    <!-- Конец Navigation Bar -->

    <!-- Sidebar -->
    <?php include('assets/inc/sidebar.php'); ?>
    <!-- Конец Sidebar -->

    <div class="be-content">
        <div class="page-head">
            <h2 class="page-head-title">Профиль </h2>
            <!-- Хлебные крошки для навигации -->
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb page-head-nav">
                    <li class="breadcrumb-item"><a href="admin-dashboard.php">Панель управления </a></li>
                    <li class="breadcrumb-item"><a href="admin-profile.php">Профиль </a></li>
                    <li class="breadcrumb-item active">Обновление профиля</li>
                </ol>
            </nav>
        </div>

        <!--Активация Sweet Alert -->
        <?php if (isset($succ)) { ?>
            <!-- Вставка уведомления об успехе -->
            <script>
                setTimeout(function () {
                        swal("Успешно!", "<?php echo $succ;?>", "success");
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
            $aid = $_SESSION['admin_id'];
            $ret = "select * from airport_admin where admin_id=?";
            $stmt = $mysqli->prepare($ret);
            $stmt->bind_param('i', $aid);
            $stmt->execute();
            $res = $stmt->get_result();
            while ($row = $res->fetch_object()) {
                ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-border-color card-border-color-success">
                            <div class="card-header card-header-divider">Обновите Ваш профиль<span class="card-subtitle">Заполните все поля</span>
                            </div>
                            <div class="card-body">
                                <form method="POST">
                                    <!-- Форма для обновления данных профиля -->
                                    <div class="form-group row">
                                        <label class="col-12 col-sm-3 col-form-label text-sm-right" for="inputText3">Имя</label>
                                        <div class="col-12 col-sm-8 col-lg-6">
                                            <input class="form-control" name="admin_fname" value="<?php echo $row->admin_fname; ?>" id="inputText3" type="text">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-12 col-sm-3 col-form-label text-sm-right" for="inputText3">Фамилия</label>
                                        <div class="col-12 col-sm-8 col-lg-6">
                                            <input class="form-control" name="admin_lname" value="<?php echo $row->admin_lname; ?>" id="inputText3" type="text">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-12 col-sm-3 col-form-label text-sm-right" for="inputText3">Эл. почта</label>
                                        <div class="col-12 col-sm-8 col-lg-6">
                                            <input class="form-control" name="admin_email" value="<?php echo $row->admin_email; ?>" id="inputText3" type="text">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-12 col-sm-3 col-form-label text-sm-right" for="inputText3">Имя пользователя</label>
                                        <div class="col-12 col-sm-8 col-lg-6">
                                            <input class="form-control" name="admin_uname" value="<?php echo $row->admin_uname; ?>" id="inputText3" type="text">
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <p class="text-right">
                                            <input class="btn btn-space btn-success" value="Обновить профиль" name="Update_Profile" type="submit">
                                            <button class="btn btn-space btn-danger">Отмена</button>
                                        </p>
                                    </div>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>

        <!-- Footer -->
        <?php include('assets/inc/footer.php'); ?>
        <!-- Конец Footer -->
    </div>

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
