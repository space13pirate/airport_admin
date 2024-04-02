<?php
session_start();
include('assets/inc/config.php');

if (isset($_POST['Create_Profile'])) {
    $pass_id = $_GET['pass_id'];
    $pass_lname = $_POST['pass_lname'];
    $pass_fname = $_POST['pass_fname'];
    $pass_mname = $_POST['pass_mname'];
    $pass_bday = $_POST['pass_bday'];
    $pass_passport = $_POST['pass_passport'];
    $pass_phone = $_POST['pass_phone'];
    $pass_addr = $_POST['pass_addr'];
    $pass_email = $_POST['pass_email'];
    $pass_uname = $_POST['pass_uname'];

    // SQL-запрос на обновление информации о пассажире
    $query = "update airport_passenger set pass_lname=?, pass_fname=?, pass_mname=?, pass_bday=?, pass_passport=?, pass_phone=?, pass_addr=?, pass_email=?, pass_uname=? where pass_id=?";
    $stmt = $mysqli->prepare($query);

    // Привязываем параметры
    $rc = $stmt->bind_param('sssssssssi', $pass_lname, $pass_fname,  $pass_mname, $pass_bday, $pass_passport, $pass_phone, $pass_addr, $pass_email, $pass_uname, $pass_id);
    $stmt->execute();
    if ($stmt) {
        $success = "Информация о пассажире была обновлена";
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
            <h2 class="page-head-title">Обновление информации о пассажире</h2>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb page-head-nav">
                    <li class="breadcrumb-item"><a href="admin-dashboard.php">Панель управления</a></li>
                    <li class="breadcrumb-item"><a href="admin-manage-passengers.php">Пассажиры</a></li>
                    <li class="breadcrumb-item active">Обновление информации о пассажире</li>
                </ol>
            </nav>
        </div>

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

        <div class="main-content container-fluid">
            <!-- Форма деталей пассажиров -->
            <?php
            $aid = $_GET['pass_id'];
            $ret = "select * from airport_passenger where pass_id=?";
            $stmt = $mysqli->prepare($ret);
            $stmt->bind_param('i', $aid);
            $stmt->execute();
            $res = $stmt->get_result();

            while ($row = $res->fetch_object()) {
                ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-border-color card-border-color-success">
                            <div class="card-header card-header-divider">Обновление информации о пассажире<span class="card-subtitle">Заполните все поля</span></div>
                            <div class="card-body">
                                <form method="POST">

                                    <div class="form-group row">
                                        <label class="col-12 col-sm-3 col-form-label text-sm-right" for="inputText3">Фамилия</label>
                                        <div class="col-12 col-sm-8 col-lg-6">
                                            <input class="form-control" name="pass_lname" value="<?php echo $row->pass_lname; ?>" id="inputText3" type="text">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-12 col-sm-3 col-form-label text-sm-right" for="inputText3">Имя</label>
                                        <div class="col-12 col-sm-8 col-lg-6">
                                            <input class="form-control" name="pass_fname" value="<?php echo $row->pass_fname; ?>" id="inputText3" type="text">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-12 col-sm-3 col-form-label text-sm-right" for="inputText3">Отчество</label>
                                        <div class="col-12 col-sm-8 col-lg-6">
                                            <input class="form-control" name="pass_mname" value="<?php echo $row->pass_mname; ?>" id="inputText3" type="text">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-12 col-sm-3 col-form-label text-sm-right" for="inputText3">Дата рождения</label>
                                        <div class="col-12 col-sm-8 col-lg-6">
                                            <input class="form-control" name="pass_bday" value="<?php echo $row->pass_bday; ?>" id="inputDate" type="date">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-12 col-sm-3 col-form-label text-sm-right" for="inputText3">Паспорт</label>
                                        <div class="col-12 col-sm-8 col-lg-6">
                                            <input class="form-control" name="pass_passport" value="<?php echo $row->pass_passport; ?>" id="inputText3" type="text">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-12 col-sm-3 col-form-label text-sm-right" for="inputText3">Телефон</label>
                                        <div class="col-12 col-sm-8 col-lg-6">
                                            <input class="form-control" name="pass_phone" value="<?php echo $row->pass_phone; ?>" id="inputText3" type="text">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-12 col-sm-3 col-form-label text-sm-right" for="inputText3">Адрес</label>
                                        <div class="col-12 col-sm-8 col-lg-6">
                                            <input class="form-control" name="pass_addr" value="<?php echo $row->pass_addr; ?>" id="inputText3" type="text">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-12 col-sm-3 col-form-label text-sm-right" for="inputText3">Эл. почта</label>
                                        <div class="col-12 col-sm-8 col-lg-6">
                                            <input class="form-control" name="pass_email" value="<?php echo $row->pass_email; ?>" id="inputText3" type="text">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-12 col-sm-3 col-form-label text-sm-right" for="inputText3">Имя пользователя</label>
                                        <div class="col-12 col-sm-8 col-lg-6">
                                            <input class="form-control" name="pass_uname" value="<?php echo $row->pass_uname; ?>" id="inputText3" type="text">
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <p class="text-right">
                                            <input class="btn btn-space btn-success" value="Обновить информацию о пассажире" name="Create_Profile" type="submit">
                                            <button class="btn btn-space btn-danger">Отмена</button>
                                        </p>
                                    </div>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Конец формы деталей пассажира -->
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
<script src="assets/js/swal.js" type="text/javascript"></script>

<script type="text/javascript">
    $(document).ready(function () {
        // Инициализация JavaScript
        App.init();
        App.formElements();
    });
</script>

</body>
</html>
