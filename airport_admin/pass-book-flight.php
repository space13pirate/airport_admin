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

    <!--navbar-->
    <?php include('assets/inc/navbar.php'); ?>
    <!--Конец navbar-->

    <!--Sidebar-->
    <?php include('assets/inc/sidebar.php'); ?>
    <!--Конец Sidebar-->

    <div class="be-content">
        <div class="page-head">
            <h2 class="page-head-title">Просмотр рейсов</h2>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb page-head-nav">
                    <li class="breadcrumb-item"><a href="pass">Панель информации</a></li>
                    <li class="breadcrumb-item"><a href="pass-book-flight.php">Рейсы</a></li>
                    <li class="breadcrumb-item active">Просмотр рейсов</li>
                </ol>
            </nav>
        </div>

        <div class="main-content container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card card-table">
                        <div class="card-header">Вы можете забронировать рейс</div>
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
                                <!--Данные для таблицы "Рейсы"-->
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
                                    <tr class="odd gradeX even gradeC odd gradeA even gradeA ">
                                        <td><?php echo $row->flight_no; ?></td>
                                        <td><?php echo $row->airline_name; ?></td>
                                        <td><?php echo $row->route; ?></td>
                                        <td class="center"><?php echo $row->dep_airport; ?></td>
                                        <td class="center"><?php echo $row->arr_airport; ?></td>
                                        <td class="center"><?php echo $row->dep_time; ?></td>
                                        <td class="center"><?php echo $row->arr_time; ?></td>
                                        <td class="center"><?php echo $row->fare; ?> руб.</td>
                                        <td class="center">
                                            <a href="pass-book-specific-flight.php?id=<?php echo $row->id ?>">
                                                <button class="btn btn-success btn-sm">Забронировать</button>
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

            <!-- Footer -->
            <?php include('assets/inc/footer.php'); ?>
            <!-- Конец Footer -->

        </div>
    </div>
</div>

<!-- Подключение JavaScript библиотек -->
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