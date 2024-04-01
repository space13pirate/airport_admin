<?php
session_start();
include('assets/inc/config.php');
include('assets/inc/checklogin.php');
check_login();

// Получаем ticket_id из URL
if(isset($_GET['ticket_id'])) {
    $ticket_id = intval($_GET['ticket_id']);
} else {
    echo "Ticket ID is required";
    exit; // Останавливаем выполнение скрипта, если ticket_id не передан
}
?>

<!DOCTYPE html>
<html lang="ru">

<!--Head-->
<?php include('assets/inc/head.php'); ?>
<!--Конец Head-->

<body>
<div class="be-wrapper be-fixed-sidebar">

    <!--Nav Bar-->
    <?php include('assets/inc/navbar.php'); ?>
    <!--Конец Navbar-->

    <!--Sidebar-->
    <?php include('assets/inc/sidebar.php'); ?>
    <!--Конец Sidebar-->

    <div class="be-content">
        <div class="page-head">
            <h2 class="page-head-title">Печать билета</h2>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb page-head-nav">
                    <li class="breadcrumb-item"><a href="#">Панель информации</a></li>
                    <li class="breadcrumb-item"><a href="#">Билеты</a></li>
                    <li class="breadcrumb-item active">Печать билета</li>
                </ol>
            </nav>
        </div>

        <?php
        // Запрос в базу данных для получения деталей билета по ticket_id
        $ret = "SELECT * FROM airport_tickets WHERE ticket_id=?";
        $stmt = $mysqli->prepare($ret);
        $stmt->bind_param('i', $ticket_id);
        $stmt->execute();
        $res = $stmt->get_result();

        while ($row = $res->fetch_object()) {
            ?>
            <div class="main-content container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <!--Детали билета-->
                        <div id='printReceipt' class="invoice">
                            <div class="row invoice-header">
                                <div class="col-sm-7">
                                    <div class="invoice-logo"></div>
                                </div>
                                <div class="col-sm-5 invoice-order"><span class="invoice-id">Билет на рейс</span>
                                    <span class="incoice-date"><?php echo $row->pass_lname; ?> <?php echo $row->pass_fname; ?> <?php echo $row->pass_mname; ?></span>
                                </div>
                            </div>

                            <div class="row invoice-data">
                                <div class="col-sm-5 invoice-person">
                                    <span class="name"><?php echo $row->pass_lname; ?> <?php echo $row->pass_fname; ?> <?php echo $row->pass_mname; ?>
                                    </span><span><?php echo $row->pass_email; ?></span>
                                </div>
                                <div class="col-sm-2 invoice-payment-direction"></div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Рейс</th>
                                            <th>Отправление</th>
                                            <th>Прибытие</th>
                                            <th>Стоимость</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $ret = "select * from airport_tickets WHERE ticket_id=?";
                                        $stmt = $mysqli->prepare($ret);
                                        $stmt->bind_param('i', $ticket_id);
                                        $stmt->execute();
                                        $res = $stmt->get_result();
                                        while ($row = $res->fetch_object()) {
                                            ?>
                                            <tr>
                                                <td><?php echo $row->flight_no; ?><hr><?php echo $row->airline_name; ?></td>
                                                <td><?php echo $row->dep_airport; ?><hr><?php echo $row->dep_time; ?></td>
                                                <td><?php echo $row->arr_airport; ?><hr><?php echo $row->arr_time; ?></td>
                                                <td><?php echo $row->fare; ?> руб.</td>
                                            </tr>
                                            <hr>
                                        <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <hr>

                        <div class="row invoice-footer">
                            <div class="col-lg-12">
                                <button id="print" onclick="printContent('printReceipt');" class="btn btn-lg btn-space btn-primary">Печать</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        <?php } ?>

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
<script type="text/javascript">
    $(document).ready(function () {
        // Инициализация JavaScript
        App.init();
    });

</script>
<!--Печать билета js-->
<script>
    function printContent(el) {
        var restorepage = $('body').html();
        var printcontent = $('#' + el).clone();
        $('body').empty().html(printcontent);
        window.print();
        $('body').html(restorepage);
    }
</script>
</body>

</html>