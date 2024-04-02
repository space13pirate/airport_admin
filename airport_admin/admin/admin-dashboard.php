<?php
session_start();
include('assets/inc/config.php');
include('assets/inc/checklogin.php');
check_login();
$aid = $_SESSION['admin_id'];
?>

<!DOCTYPE html>
<html lang="ru">

<!-- Header -->
<?php include("assets/inc/head.php"); ?>
<!-- Конец Header -->

<body>
<div class="be-wrapper be-fixed-sidebar">

    <!-- Navigation Bar -->
    <?php include("assets/inc/navbar.php"); ?>
    <!-- Конец Navigation Bar -->

    <!-- Sidebar -->
    <?php include('assets/inc/sidebar.php'); ?>
    <!-- Конец Sidebar -->

    <div class="be-content">
        <div class="main-content container-fluid">
            <!-- Виджеты отображения информации -->
            <div class="row">

                <!-- Виджет пассажиров -->
                <div class="col-12 col-lg-6 col-xl-3">
                    <div class="widget widget-tile">
                        <div class="chart sparkline"><i class="material-icons">airline_seat_recline_normal</i></div>
                        <div class="data-info">
                            <?php
                            // Запрос на подсчёт общего количества пассажиров
                            $result = "SELECT count(*) FROM airport_passenger";
                            $stmt = $mysqli->prepare($result);
                            $stmt->execute();
                            $stmt->bind_result($pass);
                            $stmt->fetch();
                            $stmt->close();
                            ?>
                            <div class="desc">Пассажиры</div>
                            <div class="value"><span class="indicator indicator-positive mdi mdi-chevron-right"></span>
                                <span class="number" data-toggle="counter" data-end="<?php echo $pass; ?>">0</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Виджет рейсов -->
                <div class="col-12 col-lg-6 col-xl-3">
                    <div class="widget widget-tile">
                        <div class="chart sparkline"><i class="material-icons">connecting_airports</i></div>
                        <div class="data-info">
                            <?php
                            // Запрос на подсчёт общего количества рейсов
                            $result = "SELECT count(*) FROM airport_flight";
                            $stmt = $mysqli->prepare($result);
                            $stmt->execute();
                            $stmt->bind_result($flight);
                            $stmt->fetch();
                            $stmt->close();
                            ?>
                            <div class="desc">Рейсы</div>
                            <div class="value"><span class="indicator indicator-positive mdi mdi-chevron-right"></span>
                                <span class="number" data-toggle="counter" data-end="<?php echo $flight; ?>">0</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Виджет бронирований -->
                <div class="col-12 col-lg-6 col-xl-3">
                    <div class="widget widget-tile">
                        <div class="chart sparkline"><i class="material-icons">airplane_ticket</i></div>
                        <div class="data-info">
                            <?php
                            // Запрос на подсчёт общего количества бронирований
                            $result = "SELECT count(*) FROM `airport_tickets` ";
                            $stmt = $mysqli->prepare($result);
                            $stmt->execute();
                            $stmt->bind_result($resevations);
                            $stmt->fetch();
                            $stmt->close();
                            ?>
                            <div class="desc">Бронирования</div>
                            <div class="value"><span class="indicator indicator-positive mdi mdi-chevron-right"></span>
                                <span class="number" data-toggle="counter"
                                      data-end="<?php echo $resevations; ?>">0</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Виджет сотрудников -->
                <div class="col-12 col-lg-6 col-xl-3">
                    <div class="widget widget-tile">
                        <div class="chart sparkline"><i class="material-icons">group</i></div>
                        <div class="data-info">
                            <?php
                            // Запрос на подсчёт общего количества сотрудников
                            $result = "SELECT count(*) FROM airport_employee";
                            $stmt = $mysqli->prepare($result);
                            $stmt->execute();
                            $stmt->bind_result($pass);
                            $stmt->fetch();
                            $stmt->close();
                            ?>
                            <div class="desc">Сотрудники</div>
                            <div class="value"><span class="indicator indicator-positive mdi mdi-chevron-right"></span>
                                <span class="number" data-toggle="counter" data-end="<?php echo $pass; ?>">0</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Виджет администраторов -->
                <div class="col-12 col-lg-6 col-xl-3">
                    <div class="widget widget-tile">
                        <div class="chart sparkline"><i class="material-icons">account_circle</i></div>
                        <div class="data-info">
                            <?php
                            // Запрос на подсчёт общего количества администраторов
                            $result = "SELECT count(*) FROM airport_admin ";
                            $stmt = $mysqli->prepare($result);
                            $stmt->execute();
                            $stmt->bind_result($admin);
                            $stmt->fetch();
                            $stmt->close();
                            ?>
                            <div class="desc">Администраторы</div>
                            <div class="value">
                                <span class="indicator indicator-positive mdi mdi-chevron-right"></span>
                                <span class="number" data-toggle="counter" data-end="<?php echo $admin; ?>">0</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Виджет паролей для сброса -->
                <div class="col-12 col-lg-6 col-xl-3">
                    <div class="widget widget-tile">
                        <div class="chart sparkline"><i class="material-icons">lock_reset</i></div>
                        <div class="data-info">
                            <?php
                            // Запрос на подсчёт общего количества паролей для сброса
                            $result = "SELECT count(*) FROM airport_passwordresets where status = 'Pending' ";
                            $stmt = $mysqli->prepare($result);
                            $stmt->execute();
                            $stmt->bind_result($pass);
                            $stmt->fetch();
                            $stmt->close();
                            ?>
                            <div class="desc">Пароли для сброса</div>
                            <div class="value"><span class="indicator indicator-positive mdi mdi-chevron-right"></span>
                                <span class="number" data-toggle="counter" data-end="<?php echo $pass; ?>">0</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Виджет подтверждённых билетов -->
                <div class="col-12 col-lg-6 col-xl-3">
                    <div class="widget widget-tile">
                        <div class="chart sparkline"><i class="material-icons">local_activity</i></div>
                        <div class="data-info">
                            <?php
                            // Запрос на подсчёт общего количества подтверждённых билетов
                            $result = "SELECT count(*) FROM airport_tickets where confirmation = 'Approved'";
                            $stmt = $mysqli->prepare($result);
                            $stmt->execute();
                            $stmt->bind_result($ticket);
                            $stmt->fetch();
                            $stmt->close();
                            ?>
                            <div class="desc">Подтвержд. билеты</div>
                            <div class="value">
                                <span class="indicator indicator-positive mdi mdi-chevron-right"></span>
                                <span class="number" data-toggle="counter" data-end="<?php echo $ticket; ?>">0</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Виджет неподтверждённых билетов -->
                <div class="col-12 col-lg-6 col-xl-3">
                    <div class="widget widget-tile">
                        <div class="chart sparkline"><i class="material-icons">confirmation_number</i></div>
                        <div class="data-info">
                            <?php
                            // Запрос на подсчёт общего количества неподтверждённых билетов
                            $result = "SELECT count(*) FROM airport_tickets where confirmation != 'Approved' ";
                            $stmt = $mysqli->prepare($result);
                            $stmt->execute();
                            $stmt->bind_result($ticket);
                            $stmt->fetch();
                            $stmt->close();
                            ?>
                            <div class="desc">Неподтвержд. билеты</div>
                            <div class="value">
                                <span class="indicator indicator-positive mdi mdi-chevron-right"></span>
                                <span class="number" data-toggle="counter" data-end="<?php echo $ticket; ?>">0</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Конец виджетов отображения информации -->

            <!-- Начало таблиц с данными -->

            <!-- Таблица со списком рейсов -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="card card-table">
                        <div class="card-header">Список рейсов
                            <div class="tools dropdown"><span class=""></span>
                                <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown"><span class=""></span></a>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- Начало таблицы -->
                            <table class="table table-striped table-bordered table-hover table-fw-widget" id="table1">
                                <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Номер рейса</th>
                                    <th>Авиакомпания</th>
                                    <th>Маршрут</th>
                                    <th>Время отправления</th>
                                    <th>Время прибытия</th>
                                    <th>Кол-во пассажиров</th>
                                    <th>Стоимость</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $ret = "SELECT * FROM airport_flight LIMIT 20";
                                $stmt = $mysqli->prepare($ret);
                                $stmt->execute();
                                $res = $stmt->get_result();
                                $cnt = 1;
                                while ($row = $res->fetch_object()) {
                                    ?>
                                    <tr class="odd gradeX even gradeC odd gradeA ">
                                        <td><?php echo $cnt; ?>
                                        <td><?php echo $row->flight_no; ?></td>
                                        <td><?php echo $row->airline_name; ?></td>
                                        <td><?php echo $row->route; ?></td>
                                        <td><?php echo $row->dep_time; ?></td>
                                        <td><?php echo $row->arr_time; ?></td>
                                        <td><?php echo $row->passengers; ?></td>
                                        <td><?php echo $row->fare; ?> руб.</td>
                                    </tr>
                                    <?php $cnt = $cnt + 1;
                                } ?>
                                </tbody>
                            </table>
                            <!-- Конец таблицы -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- Таблица со списком бронирований -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="card card-table">
                        <div class="card-header">Список бронирований пассажиров
                            <div class="tools dropdown"><span class=""></span>
                                <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown"><span class=""></span></a>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- Начало таблицы -->
                            <table class="table table-striped table-bordered table-hover table-fw-widget" id="table1">
                                <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Пассажир</th>
                                    <th>Номер рейса</th>
                                    <th>Авиакомпания</th>
                                    <th>Отправление</th>
                                    <th>Прибытие</th>
                                    <th>Стоимость</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $ret = "SELECT * FROM airport_tickets WHERE confirmation ='Approved' LIMIT 20";
                                $stmt = $mysqli->prepare($ret);
                                $stmt->execute();
                                $res = $stmt->get_result();
                                $cnt = 1;
                                while ($row = $res->fetch_object()) {
                                    ?>
                                    <tr class="odd gradeX even gradeC odd gradeA ">
                                        <td><?php echo $cnt; ?>
                                        <td><?php echo $row->pass_lname;?> <?php echo $row->pass_fname;?> <?php echo $row->pass_mname;?><br><?php echo $row->pass_email;?></td>
                                        <td><?php echo $row->flight_no;?></td>
                                        <td><?php echo $row->airline_name;?></td>
                                        <td><?php echo $row->dep_airport;?><br><?php echo $row->dep_time;?></td>
                                        <td><?php echo $row->arr_airport;?><br><?php echo $row->arr_time;?></td>
                                        <td><?php echo $row->fare;?> руб.</td>
                                    </tr>
                                    <?php $cnt = $cnt + 1;
                                } ?>
                                </tbody>
                            </table>
                            <!-- Конец таблицы -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- Таблица со списком сотрудников -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="card card-table">
                        <div class="card-header">Список сотрудников
                            <div class="tools dropdown"><span class=""></span>
                                <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown"><span class=""></span></a>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- Начало таблицы -->
                            <table class="table table-striped table-bordered table-hover table-fw-widget" id="table1">
                                <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Сотрудник</th>
                                    <th>Адрес</th>
                                    <th>Телефон</th>
                                    <th>Паспорт</th>
                                    <th>Эл. почта</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $ret = "SELECT * FROM airport_employee LIMIT 20 ";
                                $stmt = $mysqli->prepare($ret);
                                $stmt->execute();//ok
                                $res = $stmt->get_result();
                                $cnt = 1;
                                while ($row = $res->fetch_object()) {
                                    ?>
                                    <tr class="odd gradeX even gradeC odd gradeA ">
                                        <td><?php echo $cnt; ?>
                                        <td><?php echo $row->emp_lname;?> <?php echo $row->emp_fname;?> <?php echo $row->emp_mname;?></td>
                                        <td><?php echo $row->emp_addr; ?></td>
                                        <td><?php echo $row->emp_phone; ?></td>
                                        <td><?php echo $row->emp_passport; ?></td>
                                        <td><?php echo $row->emp_email; ?></td>
                                    </tr>
                                    <?php $cnt = $cnt + 1;
                                } ?>
                                </tbody>
                            </table>
                            <!-- Конец таблицы -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- Конец таблиц с данными -->
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
