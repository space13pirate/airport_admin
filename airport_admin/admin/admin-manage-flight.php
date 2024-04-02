<?php
session_start();
include('assets/inc/config.php');
include('assets/inc/checklogin.php');
check_login();
$aid = $_SESSION['admin_id'];

// Проверка, был ли запрос на удаление
if (isset($_GET['del'])) {
    $id = intval($_GET['del']); // Получение идентификатора рейса для удаления
    // Подготовка SQL-запроса на удаление
    $adn = "delete from airport_flight where id=?";
    $stmt = $mysqli->prepare($adn);
    // Привязка параметров и выполнение запроса
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->close(); // Закрытие запроса

    // Проверка статуса выполнения запроса
    if ($stmt) {
        $succ = "Информация о рейсе была удалена";
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
<div class="be-wrapper be-fixed-sidebar">

    <!-- Navigation Bar -->
    <?php include('assets/inc/navbar.php'); ?>
    <!-- Конец Navigation Bar -->

    <!-- Sidebar -->
    <?php include('assets/inc/sidebar.php'); ?>
    <!-- Конец Sidebar -->

    <div class="be-content">
        <div class="page-head">
            <h2 class="page-head-title">Управление рейсами</h2>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb page-head-nav">
                    <li class="breadcrumb-item"><a href="admin-dashboard.php">Панель управления</a></li>
                    <li class="breadcrumb-item"><a href="admin-manage-flight.php">Рейсы</a></li>
                    <li class="breadcrumb-item active">Управление рейсами</li>
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
            <div class="row">
                <div class="col-sm-12">
                    <div class="card card-table">
                        <div class="card-header">Список рейсов</div>

                        <div class="card-body">
                            <table class="table table-striped table-bordered table-hover table-fw-widget" id="table1">
                                <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Номер рейса</th>
                                    <th>Авиакомпания</th>
                                    <th>Маршрут</th>
                                    <th>Аэропорт отправления</th>
                                    <th>Аэропорт прибытия</th>
                                    <th>Время отправления</th>
                                    <th>Время прибытия</th>
                                    <th>Кол-во пассажиров</th>
                                    <th>Стоимость</th>
                                    <th>Действия</th>
                                </tr>
                                </thead>

                                <tbody>
                                <?php
                                $ret = "SELECT * FROM airport_flight";
                                $stmt = $mysqli->prepare($ret);
                                $stmt->execute();
                                $res = $stmt->get_result();
                                $cnt = 1;
                                while ($row = $res->fetch_object()) {
                                    ?>
                                    <tr class="odd gradeX even gradeC odd gradeA ">
                                        <td class="center"><?php echo $cnt; ?>
                                        <td class="center"><?php echo $row->flight_no; ?></td>
                                        <td class="center"><?php echo $row->airline_name; ?></td>
                                        <td class="center"><?php echo $row->route; ?></td>
                                        <td class="center"><?php echo $row->dep_airport; ?></td>
                                        <td class="center"><?php echo $row->arr_airport; ?></td>
                                        <td class="center"><?php echo $row->dep_time; ?></td>
                                        <td class="center"><?php echo $row->arr_time; ?></td>
                                        <td class="center"><?php echo $row->passengers; ?></td>
                                        <td class="center"><?php echo $row->fare; ?> руб.</td>
                                        <td class="center">
                                            <a class="badge badge-success"
                                               href="admin-update-flight.php?id=<?php echo $row->id; ?>">Обновить</a>
                                            <hr>
                                            <a class="badge badge-danger"
                                               href="admin-manage-flight.php?del=<?php echo $row->id; ?>">Удалить</a>
                                            <hr>
                                            <a class="badge badge-primary"
                                               href="admin-view-flight.php?id=<?php echo $row->id; ?>">Посмотреть</a>
                                        </td>
                                    </tr>
                                    <?php $cnt = $cnt + 1;
                                } ?>
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