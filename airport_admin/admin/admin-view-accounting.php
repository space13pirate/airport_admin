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
        <div class="main-content container-fluid">
            <!-- Виджеты отображения информации -->
            <div class="row">

                <!-- Виджет суммы оплаченных билетов -->
                <div class="col-12 col-lg-6 col-xl-6">
                    <div class="widget widget-tile">
                        <div class="chart sparkline"><i class="material-icons">currency_ruble</i></div>
                        <div class="data-info">
                            <?php
                            $result = "SELECT SUM(fare) FROM airport_tickets WHERE confirmation = 'Approved'";
                            $stmt = $mysqli->prepare($result);
                            $stmt->execute();
                            $stmt->bind_result($count_fare);
                            $stmt->fetch();
                            $stmt->close();
                            ?>
                            <div class="desc">Билетов оплачено на сумму</div>
                            <div class="value"><span class="number" data-toggle="counter"
                                                     data-end="<?php echo $count_fare; ?>">0</span> руб.
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Виджет бронирований -->
                <div class="col-12 col-lg-6 col-xl-6">
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
                            <div class="value"><span
                                        class="indicator indicator-positive mdi mdi-chevron-right"></span><span
                                        class="number" data-toggle="counter"
                                        data-end="<?php echo $resevations; ?>">0</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Виджет подтверждённых билетов -->
                <div class="col-12 col-lg-6 col-xl-6">
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
                            <div class="desc">Подтверждённые билеты</div>
                            <div class="value">
                                <span class="indicator indicator-positive mdi mdi-chevron-right"></span>
                                <span class="number" data-toggle="counter" data-end="<?php echo $ticket; ?>">0</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Виджет неподтверждённых билетов -->
                <div class="col-12 col-lg-6 col-xl-6">
                    <div class="widget widget-tile">
                        <div class="chart sparkline"><i class="material-icons">confirmation_number</i></div>
                        <div class="data-info">
                            <?php
                            // Запрос на подсчёт общего количества неподтверждённых билетов
                            $result = "SELECT count(*) FROM airport_tickets where confirmation != 'Approved' ";
                            $stmt = $mysqli->prepare($result);
                            $stmt->execute();
                            $stmt->bind_result($pass);
                            $stmt->fetch();
                            $stmt->close();
                            ?>
                            <div class="desc">Неподтверждённые билеты</div>
                            <div class="value">
                                <span class="indicator indicator-positive mdi mdi-chevron-right"></span>
                                <span class="number" data-toggle="counter" data-end="<?php echo $pass; ?>">0</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="card card-table">
                        <div class="card-header">
                            Статус оплаты билетов
                            <div class="tools dropdown">
                                <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                            </div>
                        </div>

                        <div class="card-body">
                            <!-- Диаграмма -->
                            <div id="PieChart" style="height: 300px; width: 100%;"></div>

                            <!-- Код для получения всей информации о билетах в системе -->
                            <script type="text/javascript">
                                window.onload = function () {

                                    var options = {
                                        exportEnabled: true,
                                        animationEnabled: true,
                                        title: {},
                                        legend: {
                                            cursor: "pointer",
                                            itemclick: explodePie
                                        },
                                        data: [{
                                            type: "pie",
                                            startAngle: 45,
                                            showInLegend: "true",
                                            legendText: "{label}",
                                            indexLabel: "{label} ({y})",
                                            yValueFormatString: "#,##0.#" % "",
                                            dataPoints: [
                                                <?php
                                                // Код для получения всех подтверждённых билетов
                                                $result = "SELECT count(*) FROM  airport_tickets where confirmation = 'Approved' ";
                                                $stmt = $mysqli->prepare($result);
                                                $stmt->execute();
                                                $stmt->bind_result($approved);
                                                $stmt->fetch();
                                                $stmt->close();

                                                // Код для получения всех неподтверждённых билетов
                                                $result = "SELECT count(*) FROM airport_tickets  where confirmation != 'Approved'";
                                                $stmt = $mysqli->prepare($result);
                                                $stmt->execute();
                                                $stmt->bind_result($not_approved);
                                                $stmt->fetch();
                                                $stmt->close();
                                                ?>

                                                {label: "Оплаченные билеты", y: <?php echo $approved;?> },
                                                {label: "Билеты, ожидающие платежа", y: <?php echo $not_approved;?> },
                                            ]
                                        }]
                                    };
                                    $("#PieChart").CanvasJSChart(options);
                                }

                                function explodePie(e) {
                                    if (typeof (e.dataSeries.dataPoints[e.dataPointIndex].exploded) === "undefined" || !e.dataSeries.dataPoints[e.dataPointIndex].exploded) {
                                        e.dataSeries.dataPoints[e.dataPointIndex].exploded = true;
                                    } else {
                                        e.dataSeries.dataPoints[e.dataPointIndex].exploded = false;
                                    }
                                    e.chart.render();
                                }
                            </script>
                            <!-- Конец диаграммы -->
                        </div>
                    </div>
                </div>
            </div>
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
<!--Chart js-->
<script src="https://canvasjs.com/assets/script/jquery.canvasjs.min.js"></script>
<!--End chart js-->
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
