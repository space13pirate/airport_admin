<?php
session_start();
include('assets/inc/config.php');
include('assets/inc/checklogin.php');
check_login();
$aid = $_SESSION['pass_id'];

// Проверка, был ли запрос на удаление
if (isset($_GET['del'])) {
    $id = intval($_GET['del']); // Получение идентификатора бронирования для удаления
    // Подготовка SQL-запроса на удаление
    $adn = "DELETE FROM airport_reservation WHERE book_id = ?";
    $stmt = $mysqli->prepare($adn);
    // Привязка параметров и выполнение запроса
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->close();

    if ($stmt) {
        $succ = "Бронирование рейса было отменено";
    } else {
        $err = "Пожалуйста, повторите попытку позже";
    }
}
?>

<!DOCTYPE html>
<html lang="ru">

<!--Head-->
<?php include("assets/inc/head.php"); ?>
<!--Конец Head-->

<body>
<div class="be-wrapper be-fixed-sidebar">

    <!-- Navigation Bar -->
    <?php include('assets/inc/navbar.php'); ?>
    <!-- Конец Navigation Bar -->

    <!-- Sidebar -->
    <?php include('assets/inc/sidebar.php'); ?>
    <!-- Конец Sidebar -->

    <div class="be-content">
        <div class="page-head">
            <h2 class="page-head-title">Мои забронированные рейсы</h2>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb page-head-nav">
                    <li class="breadcrumb-item"><a href="pass">Панель информации</a></li>
                    <li class="breadcrumb-item"><a href="pass-book-flight.php">Рейсы</a></li>
                    <li class="breadcrumb-item active">Мои забронированные рейсы</li>
                </ol>
            </nav>
        </div>

        <div class="main-content container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card card-table">
                        <div class="card-header">Мои забронированные рейсы</div>
                        <div class="card-body">
                            <table class="table table-striped table-bordered table-hover table-fw-widget" id="table1">
                                <thead class="thead-dark">
                                <tr>
                                    <th>Номер рейса</th>
                                    <th>Авиакомпания</th>
                                    <th>Маршрут</th>
                                    <th>Аэропорт отправления</th>
                                    <th>Аэропорт прибытия</th>
                                    <th>Время отправления</th>
                                    <th>Время прибытия</th>
                                    <th>Стоимость</th>
                                    <th>Действие</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php

                                $aid = $_SESSION['pass_id'];
                                $ret = "SELECT * FROM airport_reservation WHERE pass_id=? AND pass_fare_payment_code =''";
                                $stmt = $mysqli->prepare($ret);
                                $stmt->bind_param('i', $aid);
                                $stmt->execute();
                                $res = $stmt->get_result();
                                while ($row = $res->fetch_object()) {
                                    ?>
                                    <tr class="odd gradeX even gradeC odd gradeA even gradeA ">
                                        <td><?php echo $row->pass_flight_no; ?></td>
                                        <td><?php echo $row->pass_airline_name; ?></td>
                                        <td><?php echo $row->pass_route; ?></td>
                                        <td class="center"><?php echo $row->pass_dep_airport; ?></td>
                                        <td class="center"><?php echo $row->pass_arr_airport; ?></td>
                                        <td class="center"><?php echo $row->pass_dep_time; ?></td>
                                        <td class="center"><?php echo $row->pass_arr_time; ?></td>
                                        <td class="center"><?php echo $row->pass_flight_fare; ?> руб.</td>
                                        <td class="center">
                                            <a href="pass-my-booked-flight.php?del=<?php echo $row->book_id; ?>">
                                                <button class="btn btn-danger btn-sm">Отменить</button>
                                            </a>
                                            <hr>
                                            <a href="pass-checkout-ticket.php?book_id=<?php echo $row->book_id; ?>">
                                                <button class="btn btn-success btn-sm">Оплатить</button>
                                            </a>
                                        </td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!--footer-->
            <?php include('assets/inc/footer.php'); ?>
            <!--Конец Footer-->
        </div>
    </div>

</div>
<script src="assets/lib/jquery/jquery.min.js" type="text/javascript"></script>
<script src="assets/lib/perfect-scrollbar/js/perfect-scrollbar.min.js" type="text/javascript"></script>
<script src="assets/lib/bootstrap/dist/js/bootstrap.bundle.min.js" type="text/javascript"></script>
<script src="assets/js/app.js" type="text/javascript"></script>
<script src="assets/lib/datatables/datatables.net/js/jquery.dataTables.js" type="text/javascript"></script>
<script src="assets/lib/datatables/datatables.net-bs4/js/dataTables.bootstrap4.js" type="text/javascript"></script>
<script src="assets/lib/datatables/datatables.net-buttons/js/dataTables.buttons.min.js" type="text/javascript"></script>
<script src="assets/lib/datatables/datatables.net-buttons/js/buttons.flash.min.js" type="text/javascript"></script>
<script src="assets/lib/datatables/jszip/jszip.min.js" type="text/javascript"></script>
<script src="assets/lib/datatables/pdfmake/pdfmake.min.js" type="text/javascript"></script>
<script src="assets/lib/datatables/pdfmake/vfs_fonts.js" type="text/javascript"></script>
<script src="assets/lib/datatables/datatables.net-buttons/js/buttons.colVis.min.js" type="text/javascript"></script>
<script src="assets/lib/datatables/datatables.net-buttons/js/buttons.print.min.js" type="text/javascript"></script>
<script src="assets/lib/datatables/datatables.net-buttons/js/buttons.html5.min.js" type="text/javascript"></script>
<script src="assets/lib/datatables/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"
        type="text/javascript"></script>
<script src="assets/lib/datatables/datatables.net-responsive/js/dataTables.responsive.min.js"
        type="text/javascript"></script>
<script src="assets/lib/datatables/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"
        type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function () {
        // Инициализация JavaScript
        App.init();
        App.dataTables();
    });
</script>
</body>

</html>