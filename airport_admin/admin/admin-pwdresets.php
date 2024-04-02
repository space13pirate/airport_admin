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
            <h2 class="page-head-title">Сбросы паролей</h2>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb page-head-nav">
                    <li class="breadcrumb-item"><a href="admin-dashboard.php">Панель управления</a></li>
                    <li class="breadcrumb-item">Сбросы паролей</a></li>
                    <li class="breadcrumb-item active">Просмотр всех запросов</li>
                </ol>
            </nav>
        </div>

        <div class="main-content container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card card-table">
                        <div class="card-header">Запросы на сброс пароля
                            <div class="tools dropdown">
                                <div class="dropdown-menu" role="menu">
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped table-bordered table-hover table-fw-widget" id="table1">
                                <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Эл. почта пользователя</th>
                                    <th>Статус запроса на сброс пароля</th>
                                </tr>
                                </thead>

                                <tbody>
                                <?php
                                $ret = "SELECT * FROM `airport_passwordresets`";
                                $stmt = $mysqli->prepare($ret);
                                $stmt->execute();
                                $res = $stmt->get_result();
                                $cnt = 1;
                                while ($row = $res->fetch_object()) {
                                    ?>
                                    <tr class="odd gradeX even gradeC odd gradeA even gradeA ">
                                        <td><?php echo $cnt; ?></td>
                                        <td><?php echo $row->email; ?></td>
                                        <td>
                                            <?php
                                            if ($row->status == 'Approved') {
                                                echo 'Подтверждён';
                                            } else if($row->status == 'Pending') {
                                                ?>
                                                <a class="badge badge-success" href="admin-confirm-pwdresets.php?pwd_id=<?php echo $row->pwd_id; ?>">Подтвердить запрос</a>
                                                <hr>
                                                <a class="badge badge-danger" href="admin-pending-pwdresets.php?del=<?php echo $row->pwd_id; ?>">Удалить запрос</a>
                                                <?php
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <?php
                                    $cnt++;
                                }
                                ?>
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
