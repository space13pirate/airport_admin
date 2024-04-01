<?php
session_start();
include('assets/inc/config.php');
include('assets/inc/checklogin.php');
check_login();
$aid = $_SESSION['pass_id'];
$flight_id = isset($_GET['id']) ? $_GET['id'] : null;

// Обрабатываем отправку формы бронирования рейса
if (isset($_POST['Book_Flight'])) {
    // Собираем данные из формы
    $pass_lname = $_POST['pass_lname'];
    $pass_fname = $_POST['pass_fname'];
    $pass_mname = $_POST['pass_mname'];
    $pass_bday = $_POST['pass_bday'];
    $pass_passport = $_POST['pass_passport'];
    $pass_phone = $_POST['pass_phone'];
    $pass_addr = $_POST['pass_addr'];
    $pass_email = $_POST['pass_email'];

    $pass_flight_no = $_POST['pass_flight_no'];
    $pass_airline_name = $_POST['pass_airline_name'];
    $pass_route = $_POST['pass_route'];
    $pass_dep_airport = $_POST['pass_dep_airport'];
    $pass_arr_airport = $_POST['pass_arr_airport'];
    $pass_dep_time = $_POST['pass_dep_time'];
    $pass_arr_time = $_POST['pass_arr_time'];
    $pass_flight_fare = $_POST['pass_flight_fare'];

    // SQL-запрос на добавление информации о бронировании рейса
    $query = "INSERT INTO airport_reservation (pass_id, pass_lname, pass_fname, pass_mname, pass_bday, pass_passport, pass_phone, pass_addr, pass_email, pass_flight_id, pass_flight_no, pass_airline_name, pass_route, pass_dep_airport, pass_arr_airport, pass_dep_time, pass_arr_time, pass_flight_fare) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $mysqli->prepare($query);

    // Привязываем параметры
    $rc = $stmt->bind_param('issssssssissssssss', $aid,  $pass_lname, $pass_fname, $pass_mname, $pass_bday, $pass_passport, $pass_phone, $pass_addr, $pass_email, $flight_id, $pass_flight_no, $pass_airline_name, $pass_route, $pass_dep_airport, $pass_arr_airport, $pass_dep_time, $pass_arr_time, $pass_flight_fare);

    $stmt->execute();
    if ($stmt) {
        $succ = "Рейс забронирован";
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
            <h2 class="page-head-title">Бронирование рейса</h2>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb page-head-nav">
                    <li class="breadcrumb-item"><a href="pass-dashboard.php">Панель информации</a></li>
                    <li class="breadcrumb-item"><a href="pass-book-flight.php">Рейсы</a></li>
                    <li class="breadcrumb-item active">Бронирование рейса</li>
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

            <!-- Форма деталей брони рейса -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-border-color card-border-color-success">
                        <div class="card-header card-header-divider">Подтвердите бронирование рейса<span
                                    class="card-subtitle"></span>
                        </div>
                        <div class="card-body">
                            <form method="POST">
                                <!-- Фамилия -->
                                <div class="form-group row">
                                    <label class="col-12 col-sm-3 col-form-label text-sm-right"
                                           for="inputText3">Фамилия</label>
                                    <div class="col-12 col-sm-8 col-lg-6">
                                        <input class="form-control" readonly name="pass_lname"
                                               value="<?php echo $row->pass_lname; ?>" id="inputText3" type="text">
                                    </div>
                                </div>

                                <!-- Имя -->
                                <div class="form-group row">
                                    <label class="col-12 col-sm-3 col-form-label text-sm-right"
                                           for="inputText3">Имя</label>
                                    <div class="col-12 col-sm-8 col-lg-6">
                                        <input class="form-control" readonly name="pass_fname"
                                               value="<?php echo $row->pass_fname; ?>" id="inputText3" type="text">
                                    </div>
                                </div>

                                <!-- Отчество -->
                                <div class="form-group row">
                                    <label class="col-12 col-sm-3 col-form-label text-sm-right" for="inputText3">Отчество</label>
                                    <div class="col-12 col-sm-8 col-lg-6">
                                        <input class="form-control" readonly name="pass_mname"
                                               value="<?php echo $row->pass_mname; ?>" id="inputText3" type="text">
                                    </div>
                                </div>

                                <!-- Дата рождения -->
                                <div class="form-group row">
                                    <label class="col-12 col-sm-3 col-form-label text-sm-right" for="inputText3">Дата
                                        рождения</label>
                                    <div class="col-12 col-sm-8 col-lg-6">
                                        <input class="form-control" readonly name="pass_bday"
                                               value="<?php echo $row->pass_bday; ?>" id="inputText3" type="date">
                                    </div>
                                </div>

                                <!-- Паспорт -->
                                <div class="form-group row">
                                    <label class="col-12 col-sm-3 col-form-label text-sm-right"
                                           for="inputText3">Паспорт</label>
                                    <div class="col-12 col-sm-8 col-lg-6">
                                        <input class="form-control" readonly name="pass_passport"
                                               value="<?php echo $row->pass_passport; ?>" id="inputText3" type="text">
                                    </div>
                                </div>

                                <!-- Телефон -->
                                <div class="form-group row">
                                    <label class="col-12 col-sm-3 col-form-label text-sm-right"
                                           for="inputText3">Телефон</label>
                                    <div class="col-12 col-sm-8 col-lg-6">
                                        <input class="form-control" readonly name="pass_phone"
                                               value="<?php echo $row->pass_phone; ?>" id="inputText3" type="text">
                                    </div>
                                </div>

                                <!-- Адрес -->
                                <div class="form-group row">
                                    <label class="col-12 col-sm-3 col-form-label text-sm-right"
                                           for="inputText3">Адрес</label>
                                    <div class="col-12 col-sm-8 col-lg-6">
                                        <input class="form-control" readonly name="pass_addr"
                                               value="<?php echo $row->pass_addr; ?>" id="inputText3" type="text">
                                    </div>
                                </div>

                                <!-- Эл. почта -->
                                <div class="form-group row">
                                    <label class="col-12 col-sm-3 col-form-label text-sm-right"
                                           for="inputText3">Эл. почта</label>
                                    <div class="col-12 col-sm-8 col-lg-6">
                                        <input class="form-control" readonly name="pass_email"
                                               value="<?php echo $row->pass_email; ?>" id="inputText3" type="text">
                                    </div>
                                </div>


                                <?php
                                $id = $_GET['id'];
                                $ret = "select * from airport_flight where id=?";
                                $stmt = $mysqli->prepare($ret);
                                $stmt->bind_param('i', $id);
                                $stmt->execute();
                                $res = $stmt->get_result();
                                while ($row = $res->fetch_object()) {
                                    ?>

                                    <!-- Номер рейса -->
                                    <div class="form-group row">
                                        <label class="col-12 col-sm-3 col-form-label text-sm-right" for="inputText3">Номер
                                            рейса</label>
                                        <div class="col-12 col-sm-8 col-lg-6">
                                            <input class="form-control" readonly name="pass_flight_no"
                                                   value="<?php echo $row->flight_no; ?>" id="inputText3" type="text">
                                        </div>
                                    </div>

                                    <!-- Авиакомпания -->
                                    <div class="form-group row">
                                        <label class="col-12 col-sm-3 col-form-label text-sm-right" for="inputText3">Авиакомпания</label>
                                        <div class="col-12 col-sm-8 col-lg-6">
                                            <input class="form-control" readonly name="pass_airline_name"
                                                   value="<?php echo $row->airline_name; ?>" id="inputText3"
                                                   type="text">
                                        </div>
                                    </div>

                                    <!-- Маршрут -->
                                    <div class="form-group row">
                                        <label class="col-12 col-sm-3 col-form-label text-sm-right" for="inputText3">Маршрут</label>
                                        <div class="col-12 col-sm-8 col-lg-6">
                                            <input class="form-control" readonly name="pass_route"
                                                   value="<?php echo $row->route; ?>" id="inputText3" type="text">
                                        </div>
                                    </div>

                                    <!-- Аэропорт отправления -->
                                    <div class="form-group row">
                                        <label class="col-12 col-sm-3 col-form-label text-sm-right" for="inputText3">Аэропорт отправления</label>
                                        <div class="col-12 col-sm-8 col-lg-6">
                                            <input class="form-control" readonly name="pass_dep_airport"
                                                   value="<?php echo $row->dep_airport; ?>" id="inputText3" type="text">
                                        </div>
                                    </div>

                                    <!-- Аэропорт прибытия -->
                                    <div class="form-group row">
                                        <label class="col-12 col-sm-3 col-form-label text-sm-right" for="inputText3">Аэропорт прибытия</label>
                                        <div class="col-12 col-sm-8 col-lg-6">
                                            <input class="form-control" readonly name="pass_arr_airport"
                                                   value="<?php echo $row->arr_airport; ?>" id="inputText3" type="text">
                                        </div>
                                    </div>

                                    <!-- Время отправления -->
                                    <div class="form-group row">
                                        <label class="col-12 col-sm-3 col-form-label text-sm-right" for="inputText3">Время
                                            отправления</label>
                                        <div class="col-12 col-sm-8 col-lg-6">
                                            <input class="form-control" readonly name="pass_dep_time"
                                                   value="<?php echo $row->dep_time; ?>" id="inputText3" type="datetime-local">
                                        </div>
                                    </div>

                                    <!-- Время прибытия -->
                                    <div class="form-group row">
                                        <label class="col-12 col-sm-3 col-form-label text-sm-right" for="inputText3">Время
                                            прибытия</label>
                                        <div class="col-12 col-sm-8 col-lg-6">
                                            <input class="form-control" readonly name="pass_arr_time"
                                                   value="<?php echo $row->arr_time; ?>" id="inputText3" type="datetime-local">
                                        </div>
                                    </div>

                                    <!-- Стоимость -->
                                    <div class="form-group row">
                                        <label class="col-12 col-sm-3 col-form-label text-sm-right" for="inputText3">Стоимость</label>
                                        <div class="col-12 col-sm-8 col-lg-6">
                                            <input class="form-control" readonly name="pass_flight_fare"
                                                   value="<?php echo $row->fare; ?>" id="inputText3" type="text">
                                        </div>
                                    </div>
                                <?php } ?>

                                <div class="col-sm-6">
                                    <p class="text-right">
                                        <input class="btn btn-space btn-outline-success" value="Забронировать"
                                               name="Book_Flight" type="submit">
                                        <a href="pass-book-flight.php"
                                           class="btn btn-space btn-outline-danger">Отмена</a>
                                    </p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>


            <!--footer-->
            <?php include('assets/inc/footer.php'); ?>
            <!--КонецFooter-->
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