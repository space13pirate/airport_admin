<?php
session_start();
include('assets/inc/config.php');
include('assets/inc/checklogin.php');
check_login();
$aid = $_SESSION['admin_id'];

if (isset($_POST['update_flight'])) {
    $id = $_GET['id'];
    $flight_no = $_POST['flight_no'];
    $airline_name = $_POST['airline_name'];
    $route = $_POST['route'];
    $dep_airport = $_POST['dep_airport'];
    $dep_time = $_POST['dep_time'];
    $arr_airport = $_POST['arr_airport'];
    $arr_time = $_POST['arr_time'];
    $passengers = $_POST['passengers'];
    $fare = $_POST['fare'];

    // SQL-запрос на обновление информации о рейсе
    $query = "update airport_flight set flight_no = ?, airline_name = ?, route = ?, dep_airport = ?, dep_time = ?, arr_airport = ?, arr_time = ?, passengers = ?, fare = ?  where id = ?";
    $stmt = $mysqli->prepare($query);

    // Привязываем параметры
    $rc = $stmt->bind_param('sssssssssi', $flight_no, $airline_name, $route, $dep_airport, $dep_time, $arr_airport, $arr_time, $passengers, $fare, $id);
    $stmt->execute();
    if ($stmt) {
        $succ = "Информация о рейсе обновлена";
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
            <h2 class="page-head-title">Обновление информации о рейсе</h2>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb page-head-nav">
                    <li class="breadcrumb-item"><a href="admin-dashboard.php">Панель управления</a></li>
                    <li class="breadcrumb-item"><a href="admin-manage-flight.php">Рейсы</a></li>
                    <li class="breadcrumb-item active">Обновление информации о рейсе</li>
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
            <!-- Форма деталей рейса -->
            <?php
            $aid = $_GET['id'];
            $ret = "select * from airport_flight where id=?";
            $stmt = $mysqli->prepare($ret);
            $stmt->bind_param('i', $aid);
            $stmt->execute();
            $res = $stmt->get_result();

            while ($row = $res->fetch_object()) {
                ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-border-color card-border-color-success">
                            <div class="card-header card-header-divider">Обновление информации о рейсе<span class="card-subtitle">Заполните все поля</span></div>
                            <div class="card-body">
                                <form method="POST">
                                    <div class="form-group row">
                                        <label class="col-12 col-sm-3 col-form-label text-sm-right" for="inputText3">Номер рейса</label>
                                        <div class="col-12 col-sm-8 col-lg-6">
                                            <input class="form-control" name="flight_no" value="<?php echo $row->flight_no; ?>" id="inputText3" type="text">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-12 col-sm-3 col-form-label text-sm-right" for="inputText3">Название авикомпании</label>
                                        <div class="col-12 col-sm-8 col-lg-6">
                                            <input class="form-control" name="airline_name" value="<?php echo $row->airline_name; ?>" id="inputText3" type="text">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-12 col-sm-3 col-form-label text-sm-right" for="inputText3">Маршрут рейса</label>
                                        <div class="col-12 col-sm-8 col-lg-6">
                                            <input class="form-control" name="route" value="<?php echo $row->route; ?>" id="inputText3" type="text">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-12 col-sm-3 col-form-label text-sm-right" for="inputText3">Аэропорт отправления</label>
                                        <div class="col-12 col-sm-8 col-lg-6">
                                            <input class="form-control" name="dep_airport" value="<?php echo $row->dep_airport; ?>" id="inputText3" type="text">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-12 col-sm-3 col-form-label text-sm-right" for="inputText3">Аэропорт прибытия</label>
                                        <div class="col-12 col-sm-8 col-lg-6">
                                            <input class="form-control" name="arr_airport" value="<?php echo $row->arr_airport; ?>" id="inputText3" type="text">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-12 col-sm-3 col-form-label text-sm-right" for="inputText3">Дата и время отправления</label>
                                        <div class="col-12 col-sm-8 col-lg-6">
                                            <input class="form-control" name="dep_time" value="<?php echo $row->dep_time; ?>" id="inputDateTime" type="datetime-local">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-12 col-sm-3 col-form-label text-sm-right" for="inputText3">Дата и время прибытия</label>
                                        <div class="col-12 col-sm-8 col-lg-6">
                                            <input class="form-control" name="arr_time" value="<?php echo $row->arr_time; ?>" id="inputDateTime" type="datetime-local">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-12 col-sm-3 col-form-label text-sm-right" for="inputText3">Количество пассажиров</label>
                                        <div class="col-12 col-sm-8 col-lg-6">
                                            <input class="form-control" name="passengers" value="<?php echo $row->passengers; ?>" id="inputText3" type="text">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-12 col-sm-3 col-form-label text-sm-right" for="inputText3">Стоимость</label>
                                        <div class="col-12 col-sm-8 col-lg-6">
                                            <input class="form-control" name="fare" value="<?php echo $row->fare; ?>" id="inputText3" type="text">
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <p class="text-right">
                                            <input class="btn btn-space btn-success" value="Обновить рейс" name="update_flight" type="submit">
                                            <button class="btn btn-space btn-danger">Отмена</button>
                                        </p>
                                    </div>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Конец формы деталей рейса -->
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
