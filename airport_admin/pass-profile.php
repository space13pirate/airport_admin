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
<?php include('assets/inc/head.php'); ?>
<!--Конец Head-->

<body>
<div class="be-wrapper be-fixed-sidebar">
    <!--Navigation Bar-->
    <?php include("assets/inc/navbar.php"); ?>
    <!--Конец Naigation Bar-->

    <!--Sidebar-->
    <?php include('assets/inc/sidebar.php'); ?>
    <!--Конец Sidebar-->

    <!-- Серверный скрипт для получения данных о залогиненном пассажире -->
    <?php
    $aid = $_SESSION['pass_id']; // Присвоение переменной $aid значения идентификатора пассажира из сессии
    $ret = "select * from airport_passenger where pass_id=?"; // SQL-запрос к базе данных для получения информации о пользователе
    $stmt = $mysqli->prepare($ret);
    $stmt->bind_param('i', $aid);
    $stmt->execute();
    $res = $stmt->get_result();

    // Цикл для вывода информации о пользователе
    while ($row = $res->fetch_object())
    {
    ?>
    <<!-- Конец серверного скрипта -->


    <div class="be-content">
        <div class="main-content container-fluid">
            <div class="user-profile">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="user-display">
                            <!-- Вывод фонового изображения профиля -->
                            <div class="user-display-bg"><img src="assets/img/profile/<?php echo $row->pass_bg; ?>" alt="Фон профиля"></div>
                            <div class="user-display-bottom">
                                <!-- Вывод аватара пользователя -->
                                <div class="user-display-avatar"><img src="assets/img/profile/<?php echo $row->pass_avatar; ?>" alt="Аватар"></div>
                                <div class="user-display-info">
                                    <!-- Вывод полного имени пассажира -->
                                    <div class="name"> <?php echo $row->pass_lname; ?> <?php echo $row->pass_fname; ?> <?php echo $row->pass_mname; ?></div>
                                    <!-- Вывод никнейма администратора -->
                                    <div class="nick"><span class="mdi mdi-account"></span><?php echo $row->pass_uname; ?></div>
                                </div>
                            </div>
                        </div>

                        <!-- Информация о пассажире -->
                        <div class="user-info-list card">
                            <div class="card-header card-header-divider">Обо мне<span class="card-subtitle"><?php echo $row->pass_bio; ?></span></div>
                            <div class="card-body">
                                <table class="no-border no-strip skills">
                                    <tbody class="no-border-x no-border-y">
                                    <!-- Дата рождения пассажира -->
                                    <tr>
                                        <td class="icon"><span class="mdi mdi-cake"></span></td>
                                        <td class="item">Дата рождения<span class="icon s7-gift"></span></td>
                                        <td><?php echo $row->pass_bday; ?></td>
                                    </tr>

                                    <!-- Телефон -->
                                    <tr>
                                        <td class="icon"><span class="mdi mdi-cellphone-android"></span></td>
                                        <td class="item">Телефон<span class="icon s7-phone"></span></td>
                                        <td><?php echo $row->pass_phone; ?></td>
                                    </tr>

                                    <!-- Электронная почта -->
                                    <tr>
                                        <td class="icon"><span class="mdi mdi-contact-mail"></span></td>
                                        <td class="item">Эл. почта<span class="icon s7-map-marker"></span></td>
                                        <td><?php echo $row->pass_email; ?></td>
                                    </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <?php include('assets/inc/footer.php'); ?>
                <!--Конец Footer-->

            </div>
        </div>
        <?php } ?>
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
    <script src="assets/lib/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            // Инициализация JavaScript
            App.init();
            App.pageProfile();
        });
    </script>

</body>
</html>