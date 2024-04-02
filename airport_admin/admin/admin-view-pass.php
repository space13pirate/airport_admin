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
        <div class="page-head">
            <h2 class="page-head-title">Информация о пассажире</h2>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb page-head-nav">
                    <li class="breadcrumb-item"><a href="admin-dashboard.php">Панель управления</a></li>
                    <li class="breadcrumb-item"><a href="admin-manage-passengers.php">Пассажиры</a></li>
                    <li class="breadcrumb-item active">Просмотр информации о пассажире</li>
                </ol>
            </nav>
        </div>

        <?php
        $aid = $_GET['pass_id'];
        $ret = "select * from airport_passenger where pass_id=?";
        $stmt = $mysqli->prepare($ret);
        $stmt->bind_param('i', $aid);
        $stmt->execute();
        $res = $stmt->get_result();

        while ($row = $res->fetch_object()) {
            ?>
            <div class="main-content container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <!-- Информация о рейсе -->
                        <div id='printReceipt' class="invoice">
                            <div class="row invoice-header">
                                <div class="col-sm-7">
                                    <div class="invoice-logo"></div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th>ФИО пассажира</th>
                                            <th>Дата рождения</th>
                                            <th>Паспорт</th>
                                            <th>Телефон</th>
                                            <th>Адрес</th>
                                            <th>Эл. почта</th>
                                            <th>Имя пользователя</th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        <tr>
                                            <td><?php echo $row->pass_lname; ?> <?php echo $row->pass_fname; ?> <?php echo $row->pass_mname; ?></td>
                                            <td><?php echo $row->pass_bday; ?></td>
                                            <td><?php echo $row->pass_passport; ?></td>
                                            <td><?php echo $row->pass_phone; ?></td>
                                            <td><?php echo $row->pass_addr; ?></td>
                                            <td><?php echo $row->pass_email; ?></td>
                                            <td><?php echo $row->pass_uname; ?></td>
                                        </tr>
                                        <hr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="row invoice-footer">
                            <div class="col-lg-12">
                                <button id="print" onclick="printContent('printReceipt');" class="btn btn-lg btn-space btn-secondary">Напечатать</button>
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

<!-- Печать билета js-->
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
