<?php
session_start();
include('assets/inc/config.php');
include('assets/inc/checklogin.php');
check_login();
$aid = $_SESSION['pass_id'];
?>
<!DOCTYPE html>
<html lang="ru">

<!--Head-->
<?php include("assets/inc/head.php"); ?>
<!--Конец Head-->

<body>
<div class="be-wrapper be-fixed-sidebar">

    <!--Navbar-->
    <?php include("assets/inc/navbar.php"); ?>
    <!--Конец Nav Bar-->

    <!--Sidebar-->
    <?php include('assets/inc/sidebar.php'); ?>
    <!--Конец Sidebar-->

    <div class="be-content">
        <div class="main-content container-fluid">
            <!-- Виджеты отображения информации -->
            <div class="row">

                <!-- Виджет забронированных рейсов -->
                <div class="col-12 col-lg-6 col-xl-6">
                    <a href="pass-my-booked-flight.php">
                        <div class="widget widget-tile">
                            <div class="chart sparkline"><i class="material-icons">flight_takeoff</i></div>
                            <div class="data-info">
                                <div class="desc">Мои забронированные рейсы</div>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Виджет билетов -->
                <div class="col-12 col-lg-6 col-xl-6">
                    <a href="pass-ticket.php">
                        <div class="widget widget-tile">
                            <div class="chart sparkline"><i class="material-icons">airplane_ticket</i></div>
                            <div class="data-info">
                                <div class="desc">Билеты</div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <!-- Конец виджетов отображения информации -->

            <!-- Начало таблиц с данными -->

            <!-- Таблица со списком доступных рейсов -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="card card-table">
                        <div class="card-header">Список доступных рейсов
                            <div class="tools dropdown"><span class=""></span><a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown"><span class=""></span></a>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- Начало таблицы -->
                            <table class="table table-striped table-bordered table-hover table-fw-widget" id="table1">
                                <thead class="thead-dark">
                                <tr>
                                    <th>Номер рейса</th>
                                    <th>Авиакомпания</th>
                                    <th>Маршрут</th>
                                    <th>Отправление</th>
                                    <th>Прибытие</th>
                                    <th>Время отправления</th>
                                    <th>Время прибытия</th>
                                    <th>Кол-во пассажиров</th>
                                    <th>Стоимость</th>
                                </tr>
                                </thead>

                                <tbody>
                                <?php

                                // Получаем текущую дату и время в формате, соответствующем формату хранения в базе данных
                                $currentDateTime = date('Y-m-d H:i:s');
                                // SQL-запрос возвращает только рейсы, дата и время вылета которых больше текущего момента
                                $ret = "SELECT * FROM airport_flight WHERE dep_time > ?";
                                $stmt = $mysqli->prepare($ret);
                                // Привязываем текущую дату и время как параметр запроса
                                $stmt->bind_param('s', $currentDateTime);
                                $stmt->execute(); // Выполняем запрос
                                $res = $stmt->get_result();
                                $cnt = 1;

                                while ($row = $res->fetch_object()) {
                                    ?>
                                    <tr class="odd gradeX even gradeC odd gradeA ">
                                        <td><?php echo $row->flight_no; ?></td>
                                        <td><?php echo $row->airline_name; ?></td>
                                        <td><?php echo $row->route; ?></td>
                                        <td><?php echo $row->dep_airport; ?></td>
                                        <td><?php echo $row->arr_airport; ?></td>
                                        <td><?php echo $row->dep_time; ?></td>
                                        <td><?php echo $row->arr_time; ?></td>
                                        <td><?php echo $row->passengers; ?></td>
                                        <td><?php echo $row->fare; ?> руб.</td>
                                    </tr>
                                    <?php $cnt = $cnt + 1;
                                } ?>
                                </tbody>
                            </table>
                            <!--Конец Table-->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--Footer-->
        <?php include('assets/inc/footer.php'); ?>
        <!--Конец Footer-->
    </div>

</div>

<!-- Подключение JavaScript библиотек -->
<script src="assets/lib/jquery/jquery.min.js" type="text/javascript"></script>
<script src="assets/lib/perfect-scrollbar/js/perfect-scrollbar.min.js" type="text/javascript"></script>
<script src="assets/lib/bootstrap/dist/js/bootstrap.bundle.min.js" type="text/javascript"></script>
<script src="assets/js/app.js" type="text/javascript"></script>
<script src="assets/lib/jquery-flot/jquery.flot.js" type="text/javascript"></script>
<script src="assets/lib/jquery-flot/jquery.flot.pie.js" type="text/javascript"></script>
<script src="assets/lib/jquery-flot/jquery.flot.time.js" type="text/javascript"></script>
<script src="assets/lib/jquery-flot/jquery.flot.resize.js" type="text/javascript"></script>
<script src="assets/lib/jquery-flot/plugins/jquery.flot.orderBars.js" type="text/javascript"></script>
<script src="assets/lib/jquery-flot/plugins/curvedLines.js" type="text/javascript"></script>
<script src="assets/lib/jquery-flot/plugins/jquery.flot.tooltip.js" type="text/javascript"></script>
<script src="assets/lib/jquery.sparkline/jquery.sparkline.min.js" type="text/javascript"></script>
<script src="assets/lib/countup/countUp.min.js" type="text/javascript"></script>
<script src="assets/lib/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
<script src="assets/lib/jqvmap/jquery.vmap.min.js" type="text/javascript"></script>
<script src="assets/lib/jqvmap/maps/jquery.vmap.world.js" type="text/javascript"></script>
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
        App.dashboard();

    });
</script>
</body>

</html>