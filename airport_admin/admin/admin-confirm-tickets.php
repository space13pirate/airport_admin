<?php
session_start();
include('assets/inc/config.php');
include('assets/inc/checklogin.php');
check_login();
$aid = $_SESSION['admin_id'];

if (isset($_POST['flight_fare_confirm_checkout'])) {
    $id = $_GET['ticket_id'];
    $confirmation = $_POST['confirmation'];
    $query = "update airport_tickets set confirmation = ? where ticket_id = ?";
    $stmt = $mysqli->prepare($query);
    $rc = $stmt->bind_param('si', $confirmation, $id);
    $stmt->execute();
    if ($stmt) {
        $succ = "Статус оплаты билета был обновлён";
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
            <h2 class="page-head-title">Подтверждение оплаты билета</h2>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb page-head-nav">
                    <li class="breadcrumb-item"><a href="admin-dashboard.php">Панель управления</a></li>
                    <li class="breadcrumb-item"><a href="admin-manage-tickets.php">Бронирования билетов</a></li>
                    <li class="breadcrumb-item">Подтверждение оплаты билета</a></li>
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
            $aid = $_GET['ticket_id'];
            $ret = "select * from airport_tickets where ticket_id=?";
            $stmt = $mysqli->prepare($ret);
            $stmt->bind_param('i', $aid);
            $stmt->execute();
            $res = $stmt->get_result();

            while ($row = $res->fetch_object())
            {
            ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-border-color card-border-color-success">
                        <div class="card-header card-header-divider"><span class="card-subtitle"></span></div>
                        <div class="card-body">
                            <form method="POST">
                                <div class="form-group row">
                                    <label class="col-12 col-sm-3 col-form-label text-sm-right" for="inputText3">ФИО пассажира</label>
                                    <div class="col-12 col-sm-8 col-lg-6">
                                        <input class="form-control" readonly name="pass_name" value="<?php echo $row->pass_lname; ?> <?php echo $row->pass_fname; ?> <?php echo $row->pass_mname; ?>" id="inputText3" type="text">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-12 col-sm-3 col-form-label text-sm-right"
                                           for="inputText3">Эл. почта пассажира</label>
                                    <div class="col-12 col-sm-8 col-lg-6">
                                        <input class="form-control" readonly name="pass_email" value="<?php echo $row->pass_email; ?>" id="inputText3" type="text">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-12 col-sm-3 col-form-label text-sm-right" for="inputText3">Номер рейса</label>
                                    <div class="col-12 col-sm-8 col-lg-6">
                                        <input class="form-control" readonly name="flight_no" value="<?php echo $row->flight_no ?>" id="inputText3" type="text">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-12 col-sm-3 col-form-label text-sm-right" for="inputText3">Название авиакомпании</label>
                                    <div class="col-12 col-sm-8 col-lg-6">
                                        <input class="form-control" readonly name="airline_name" value="<?php echo $row->airline_name; ?>" id="inputText3" type="text">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-12 col-sm-3 col-form-label text-sm-right" for="inputText3">Аэропорт отправления</label>
                                    <div class="col-12 col-sm-8 col-lg-6">
                                        <input class="form-control" readonly name="dep_airport" value="<?php echo $row->dep_airport; ?>" id="inputText3" type="text">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-12 col-sm-3 col-form-label text-sm-right" for="inputText3">Аэропорт прибытия</label>
                                    <div class="col-12 col-sm-8 col-lg-6">
                                        <input class="form-control" readonly name="arr_airport" value="<?php echo $row->arr_airport; ?>" id="inputText3" type="text">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-12 col-sm-3 col-form-label text-sm-right" for="inputText3">Время отправления</label>
                                    <div class="col-12 col-sm-8 col-lg-6">
                                        <input class="form-control" readonly name="dep_time" value="<?php echo $row->dep_time; ?>" id="inputText3" type="text">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-12 col-sm-3 col-form-label text-sm-right" for="inputText3">Время прибытия</label>
                                    <div class="col-12 col-sm-8 col-lg-6">
                                        <input class="form-control" readonly name="arr_time" value="<?php echo $row->arr_time; ?>" id="inputText3" type="text">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-12 col-sm-3 col-form-label text-sm-right" for="inputText3">Стоимость</label>
                                    <div class="col-12 col-sm-8 col-lg-6">
                                        <input class="form-control" readonly name="fare" value="<?php echo $row->fare; ?>" id="inputText3" type="text">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-12 col-sm-3 col-form-label text-sm-right" for="inputText3">Код оплаты</label>
                                    <div class="col-12 col-sm-8 col-lg-6">
                                        <input class="form-control" readonly name="fare_payment_code" value="<?php echo $row->fare_payment_code; ?>" name="pass_fare_payment_code" id="inputText3" type="text">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-12 col-sm-3 col-form-label text-sm-right" for="inputText3">Статус оплаты</label>
                                    <div class="col-12 col-sm-8 col-lg-6">
                                        <select class="form-control" name="confirmation" id="exampleFormControlSelect1 inputText3">
                                            <option value="Approved" selected>Подтверждён</option>
                                            <option value="Pending">Не подтверждён</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <p class="text-right">
                                        <input class="btn btn-space btn-success" value="Подтвердить оплату" name="flight_fare_confirm_checkout" type="submit">
                                        <button class="btn btn-space btn-danger">Отмена</button>
                                    </p>
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
