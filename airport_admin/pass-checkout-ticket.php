<?php
session_start();
include('assets/inc/config.php');
include('assets/inc/checklogin.php');
check_login();
$aid = $_SESSION['pass_id'];

// Получение book_id из URL
if (isset($_GET['book_id'])) {
    $book_id = intval($_GET['book_id']);
} else {
    echo "Необходимый параметр не передан";
    exit;
}

// Попытка получить flight_id для данного book_id
$flight_id_query = "SELECT pass_flight_id FROM airport_reservation WHERE book_id = ?";
$stmt = $mysqli->prepare($flight_id_query);
$stmt->bind_param('i', $book_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $flight_id = $row['pass_flight_id']; // Значение flight_id получено
} else {
    echo "Запись с указанным book_id не найдена";
    exit;
}

if (isset($_POST['flight_fare_checkout'])) {
    $pass_lname = $_POST['pass_lname'];
    $pass_fname = $_POST['pass_fname'];
    $pass_mname = $_POST['pass_mname'];
    $pass_email = $_POST['pass_email'];

    $flight_no = $_POST['flight_no'];
    $airline_name = $_POST['airline_name'];
    $dep_airport = $_POST['dep_airport'];
    $arr_airport = $_POST['arr_airport'];
    $dep_time = $_POST['dep_time'];
    $arr_time = $_POST['arr_time'];
    $fare = $_POST['fare'];
    $fare_payment_code = $_POST['fare_payment_code'];

    // Обновление кода оплаты в бронировании
    $query = "UPDATE airport_reservation SET pass_fare_payment_code = ? WHERE book_id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('si', $fare_payment_code, $book_id);
    $stmt->execute();

    // Вставка информации о билете
    $query = "INSERT INTO airport_tickets (pass_id, pass_lname, pass_fname, pass_mname, pass_email, flight_id, flight_no, airline_name, dep_airport, arr_airport, dep_time, arr_time, fare, fare_payment_code) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('issssissssssss', $aid, $pass_lname, $pass_fname, $pass_mname, $pass_email, $flight_id, $flight_no, $airline_name, $dep_airport, $arr_airport, $dep_time, $arr_time, $fare, $fare_payment_code);
    $stmt->execute();

    if ($stmt) {
        // Предполагается, что это сообщение о успехе отражает результаты последнего выполненного запроса
        // Возможно, вам захочется проверить оба запроса отдельно
        $succ = "Дождитесь подтверждения оплаты от Администратора";
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
    <!--End Navigation Bar-->

    <!--Sidebar-->
    <?php include('assets/inc/sidebar.php'); ?>
    <!--End Sidebar-->

    <div class="be-content">
        <div class="page-head">
            <h2 class="page-head-title">Оплата забронированного рейса</h2>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb page-head-nav">
                    <li class="breadcrumb-item"><a href="pass-dashboard.php">Панель инфоомации</a></li>
                    <li class="breadcrumb-item"><a href="pass-my-booked-flight.php">Мои бронирования</a></li>
                    <li class="breadcrumb-item">Оплата забронированного рейса</a></li>
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
            $ret = "SELECT * FROM airport_reservation WHERE book_id=?";
            $stmt = $mysqli->prepare($ret);
            $stmt->bind_param('i', $book_id);
            $stmt->execute();
            $res = $stmt->get_result();

            while ($row = $res->fetch_object())
            {
            ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-border-color card-border-color-success">
                        <div class="card-header card-header-divider">Оплатите забронированный рейс<span class="card-subtitle"></span></div>

                        <div class="card-body">
                            <form method="POST">
                                <!-- Фамилия -->
                                <div class="form-group row">
                                    <label class="col-12 col-sm-3 col-form-label text-sm-right" for="inputText3">Фамилия</label>
                                    <div class="col-12 col-sm-8 col-lg-6">
                                        <input class="form-control" readonly name="pass_lname" value="<?php echo $row->pass_lname; ?>" id="inputText3" type="text">
                                    </div>
                                </div>

                                <!-- Имя -->
                                <div class="form-group row">
                                    <label class="col-12 col-sm-3 col-form-label text-sm-right" for="inputText3">Имя</label>
                                    <div class="col-12 col-sm-8 col-lg-6">
                                        <input class="form-control" readonly name="pass_fname" value="<?php echo $row->pass_fname; ?>" id="inputText3" type="text">
                                    </div>
                                </div>

                                <!-- Отчество -->
                                <div class="form-group row">
                                    <label class="col-12 col-sm-3 col-form-label text-sm-right" for="inputText3">Отчество</label>
                                    <div class="col-12 col-sm-8 col-lg-6">
                                        <input class="form-control" readonly name="pass_mname" value="<?php echo $row->pass_mname; ?>" id="inputText3" type="text">
                                    </div>
                                </div>

                                <!-- Дата рождения -->
                                <div class="form-group row">
                                    <label class="col-12 col-sm-3 col-form-label text-sm-right" for="inputText3">Дата рождения</label>
                                    <div class="col-12 col-sm-8 col-lg-6">
                                        <input class="form-control" readonly name="pass_bday" value="<?php echo $row->pass_bday; ?>" id="inputText3" type="date">
                                    </div>
                                </div>

                                <!-- Паспорт -->
                                <div class="form-group row">
                                    <label class="col-12 col-sm-3 col-form-label text-sm-right" for="inputText3">Паспорт</label>
                                    <div class="col-12 col-sm-8 col-lg-6">
                                        <input class="form-control" readonly name="pass_passport" value="<?php echo $row->pass_passport; ?>" id="inputText3" type="text">
                                    </div>
                                </div>

                                <!-- Телефон -->
                                <div class="form-group row">
                                    <label class="col-12 col-sm-3 col-form-label text-sm-right" for="inputText3">Телефон</label>
                                    <div class="col-12 col-sm-8 col-lg-6">
                                        <input class="form-control" readonly name="pass_phone" value="<?php echo $row->pass_phone; ?>"
                                               id="inputText3" type="text">
                                    </div>
                                </div>

                                <!-- Адрес -->
                                <div class="form-group row">
                                    <label class="col-12 col-sm-3 col-form-label text-sm-right" for="inputText3">Адрес</label>
                                    <div class="col-12 col-sm-8 col-lg-6">
                                        <input class="form-control" readonly name="pass_addr" value="<?php echo $row->pass_addr; ?>" id="inputText3" type="text">
                                    </div>
                                </div>

                                <!-- Эл. почта -->
                                <div class="form-group row">
                                    <label class="col-12 col-sm-3 col-form-label text-sm-right" for="inputText3">Эл. почта</label>
                                    <div class="col-12 col-sm-8 col-lg-6">
                                        <input class="form-control" readonly name="pass_email" value="<?php echo $row->pass_email; ?>" id="inputText3" type="text">
                                    </div>
                                </div>

                                <!--Забронированный рейс -->
                                <div class="form-group row">
                                    <label class="col-12 col-sm-3 col-form-label text-sm-right" for="inputText3">Забронированный рейс</label>
                                    <div class="col-12 col-sm-8 col-lg-6">
                                        <input class="form-control" readonly name="flight_no" value="<?php echo $row->pass_flight_no; ?>" id="inputText3" type="text">
                                    </div>
                                </div>

                                <!-- Авиакомпания -->
                                <div class="form-group row">
                                    <label class="col-12 col-sm-3 col-form-label text-sm-right" for="inputText3">Авиакомпания</label>
                                    <div class="col-12 col-sm-8 col-lg-6">
                                        <input class="form-control" readonly name="airline_name" value="<?php echo $row->pass_airline_name; ?>" id="inputText3" type="text">
                                    </div>
                                </div>

                                <!-- Маршрут -->
                                <div class="form-group row">
                                    <label class="col-12 col-sm-3 col-form-label text-sm-right" for="inputText3">Маршрут</label>
                                    <div class="col-12 col-sm-8 col-lg-6">
                                        <input class="form-control" readonly name="route" value="<?php echo $row->pass_route; ?>" id="inputText3" type="text">
                                    </div>
                                </div>

                                <!-- Аэропорт отправления -->
                                <div class="form-group row">
                                    <label class="col-12 col-sm-3 col-form-label text-sm-right" for="inputText3">Аэропорт отправления</label>
                                    <div class="col-12 col-sm-8 col-lg-6">
                                        <input class="form-control" readonly name="dep_airport" value="<?php echo $row->pass_dep_airport; ?>" id="inputText3" type="text">
                                    </div>
                                </div>

                                <!-- Аэропорт прибытия -->
                                <div class="form-group row">
                                    <label class="col-12 col-sm-3 col-form-label text-sm-right" for="inputText3">Аэропорт прибытия</label>
                                    <div class="col-12 col-sm-8 col-lg-6">
                                        <input class="form-control" readonly name="arr_airport" value="<?php echo $row->pass_arr_airport; ?>" id="inputText3" type="text">
                                    </div>
                                </div>

                                <!-- Время отправления -->
                                <div class="form-group row">
                                    <label class="col-12 col-sm-3 col-form-label text-sm-right" for="inputText3">Время отправления</label>
                                    <div class="col-12 col-sm-8 col-lg-6">
                                        <input class="form-control" readonly name="dep_time" value="<?php echo $row->pass_dep_time; ?>" id="inputText3" type="datetime-local">
                                    </div>
                                </div>

                                <!-- Время прибытия -->
                                <div class="form-group row">
                                    <label class="col-12 col-sm-3 col-form-label text-sm-right" for="inputText3">Время прибытия</label>
                                    <div class="col-12 col-sm-8 col-lg-6">
                                        <input class="form-control" readonly name="arr_time" value="<?php echo $row->pass_arr_time; ?>" id="inputText3" type="datetime-local">
                                    </div>
                                </div>

                                <!-- Стоимость -->
                                <div class="form-group row">
                                    <label class="col-12 col-sm-3 col-form-label text-sm-right" for="inputText3">Стоимость</label>
                                    <div class="col-12 col-sm-8 col-lg-6">
                                        <input class="form-control" readonly name="fare" value="<?php echo $row->pass_flight_fare; ?>" id="inputText3" type="text">
                                    </div>
                                </div>

                                <!-- Платёжный код -->
                                <div class="form-group row">
                                    <label class="col-12 col-sm-3 col-form-label text-sm-right" for="inputText3">Код оплаты</label>
                                    <div class="col-12 col-sm-8 col-lg-6">
                                        <input class="form-control" name="fare_payment_code" value="<?php echo $row->pass_fare_payment_code; ?>" name="pass_fare_payment_code" id="inputText3" type="text">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <p class="text-right">
                                        <input class="btn btn-space btn-success" value="Послать код оплаты на проверку" name="flight_fare_checkout" type="submit">
                                        <button class="btn btn-space btn-danger">Отмена</button>
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
            <!--EndFooter-->

        </div>
    </div>

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
