<?php
session_start();
include('assets/inc/config.php');

// Обрабатываем отправку формы добавления пассажира
if (isset($_POST['Create_Profile'])) {
    $pass_lname = $_POST['pass_lname'];
    $pass_fname = $_POST['pass_fname'];
    $pass_mname = $_POST['pass_mname'];
    $pass_bday = $_POST['pass_bday'];
    $pass_passport = $_POST['pass_passport'];
    $pass_phone = $_POST['pass_phone'];
    $pass_addr = $_POST['pass_addr'];
    $pass_email = $_POST['pass_email'];
    $pass_uname = $_POST['pass_uname'];
    $pass_pwd = sha1(md5($_POST['pass_pwd']));

    // SQL-запрос на добавление информации о пассажире
    $query = "insert into airport_passenger (pass_lname, pass_fname, pass_mname, pass_bday, pass_passport, pass_phone, pass_addr, pass_email, pass_uname, pass_pwd) values(?,?,?,?,?,?,?,?,?,?)";
    $stmt = $mysqli->prepare($query);

    // Привязываем параметры
    $rc = $stmt->bind_param('ssssssssss', $pass_lname, $pass_fname, $pass_mname, $pass_bday, $pass_passport, $pass_phone, $pass_addr, $pass_email, $pass_uname, $pass_pwd);
    $stmt->execute();
    if ($stmt) {
        $success = "Пассажир и его профиль были добавлены";
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
            <h2 class="page-head-title">Добавление пассажира</h2>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb page-head-nav">
                    <li class="breadcrumb-item"><a href="admin-dashboard.php">Панель управления</a></li>
                    <li class="breadcrumb-item"><a href="admin-manage-passengers.php">Пассажиры</a></li>
                    <li class="breadcrumb-item active">Добавление пассажира</li>
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
                        swal("Не удалось!!", "<?php echo $err;?>", "Failed");
                    },
                    100);
            </script>
        <?php } ?>

        <div class="main-content container-fluid">
            <!-- Форма деталей пассажира -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-border-color card-border-color-success">
                        <div class="card-header card-header-divider">Создание нового профиля пассажира<span class="card-subtitle">Заполните все поля</span></div>
                        <div class="card-body">
                            <form method="POST">
                                <div class="form-group row">
                                    <label class="col-12 col-sm-3 col-form-label text-sm-right" for="inputText3">Фамилия</label>
                                    <div class="col-12 col-sm-8 col-lg-6">
                                        <input class="form-control" name="pass_lname" id="inputText3" type="text" placeholder="Введите фамилию пассажира" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-12 col-sm-3 col-form-label text-sm-right" for="inputText3">Имя</label>
                                    <div class="col-12 col-sm-8 col-lg-6">
                                        <input class="form-control" name="pass_fname" id="inputText3" type="text" placeholder="Введите имя пассажира" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-12 col-sm-3 col-form-label text-sm-right" for="inputText3">Отчество</label>
                                    <div class="col-12 col-sm-8 col-lg-6">
                                        <input class="form-control" name="pass_mname" id="inputText3" type="text" placeholder="Введите отчество пассажира" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-12 col-sm-3 col-form-label text-sm-right" for="inputText3">Дата рождения</label>
                                    <div class="col-12 col-sm-8 col-lg-6">
                                        <input class="form-control" name="pass_bday" id="inputDate" type="date" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-12 col-sm-3 col-form-label text-sm-right" for="inputText3">Паспорт</label>
                                    <div class="col-12 col-sm-8 col-lg-6">
                                        <input class="form-control" name="pass_passport" id="inputText3" type="number" placeholder="Введите паспорт пассажира" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-12 col-sm-3 col-form-label text-sm-right" for="inputText3">Телефон</label>
                                    <div class="col-12 col-sm-8 col-lg-6">
                                        <input class="form-control" name="pass_phone" id="inputText3" type="number" placeholder="Введите телефон пассажира" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-12 col-sm-3 col-form-label text-sm-right" for="inputText3">Адрес</label>
                                    <div class="col-12 col-sm-8 col-lg-6">
                                        <input class="form-control" name="pass_addr" id="inputText3" type="text" placeholder="Введите адрес пассажира" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-12 col-sm-3 col-form-label text-sm-right" for="inputText3">Эл. почта</label>
                                    <div class="col-12 col-sm-8 col-lg-6">
                                        <input class="form-control" name="pass_email" id="inputText3" type="email" placeholder="Введите эл. почту пассажира" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-12 col-sm-3 col-form-label text-sm-right" for="inputText3">Имя пользователя</label>
                                    <div class="col-12 col-sm-8 col-lg-6">
                                        <input class="form-control" name="pass_uname" id="inputText3" type="text" placeholder="Введите имя пользователя" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-12 col-sm-3 col-form-label text-sm-right" for="inputText3">Пароль</label>
                                    <div class="col-12 col-sm-8 col-lg-6">
                                        <input class="form-control" name="pass_pwd" id="inputText3" type="password" placeholder="Введите пароль" required>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <p class="text-right">
                                        <input class="btn btn-space btn-success" value="Добавить пассажира" name="Create_Profile" type="submit">
                                        <button class="btn btn-space btn-danger">Отмена</button>
                                    </p>
                                </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
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
