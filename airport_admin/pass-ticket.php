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
        <div class="page-head">
            <h2 class="page-head-title">Мои билеты</h2>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb page-head-nav">
                    <li class="breadcrumb-item"><a href="pass-dashboard.php">Панель информации</a></li>
                    <li class="breadcrumb-item"><a href=pass-ticket.php>Билеты</a></li>
                    <li class="breadcrumb-item active">Просмотр моих билетов</li>
                </ol>
            </nav>
        </div>

        <div class="main-content container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card card-table">

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
                        <div class="card-header"><?php echo $row->pass_fname; ?> <?php echo $row->pass_lname; ?>, некоторые билеты ждут подтверждения оплаты
                            <?php } ?>
                        </div>

                        <div class="card-body">
                            <table class="table table-striped table-bordered table-hover table-fw-widget" id="table1">
                                <thead class="thead-dark">
                                <tr>
                                    <th>Номер рейса</th>
                                    <th>Авиакомпания</th>
                                    <th>Отправление</th>
                                    <th>Прибытие</th>
                                    <th>Стоимость</th>
                                    <th>Код оплаты</th>
                                    <th>Подтверждение</th>
                                    <th>Действие</th>
                                </tr>
                                </thead>

                                <tbody>
                                <?php
                                $ret = "SELECT * from airport_tickets WHERE pass_id=? && fare_payment_code != ''";
                                $stmt = $mysqli->prepare($ret);
                                $stmt->bind_param('i', $aid);
                                $stmt->execute();
                                $res = $stmt->get_result();
                                while ($row = $res->fetch_object()) {
                                    ?>
                                    <tr class="odd gradeX even gradeC odd gradeA even gradeA ">
                                        <td><?php echo $row->flight_no; ?></td>
                                        <td><?php echo $row->airline_name; ?></td>
                                        <td class="center"><?php echo $row->dep_airport; ?><hr><?php echo $row->dep_time; ?></td>
                                        <td class="center"><?php echo $row->arr_airport; ?><hr><?php echo $row->arr_time; ?></td>
                                        <td class="center"><?php echo $row->fare; ?> руб.</td>
                                        <td class="center"><?php echo $row->fare_payment_code; ?> </td>
                                        <td class="center"><?php echo $row->fare_payment_code; ?> </td>

                                        <td>
                                            <?php
                                            if ($row->confirmation == 'Approved') {
                                                echo 'Подтверждена';
                                                ?>
                                                <hr>
                                                <a href="pass-print-ticket.php?ticket_id=<?php echo $row->ticket_id; ?>"><button class="btn btn-sm btn-success">Печать</button></a>
                                                <?php
                                            } else if($row->confirmation != 'Approved') {
                                                echo 'НЕ подтверждена';
                                                ?>
                                                <?php
                                            }
                                            ?>
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