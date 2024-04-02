<?php
session_start();
include('assets/inc/config.php');

if (isset($_POST['Create_Profile'])) {
    $emp_id = $_GET['emp_id'];
    $emp_lname = $_POST['emp_lname'];
    $emp_fname = $_POST['emp_fname'];
    $emp_mname = $_POST['emp_mname'];
    $emp_bday = $_POST['emp_bday'];
    $emp_passport = $_POST['emp_passport'];
    $emp_phone = $_POST['emp_phone'];
    $emp_addr = $_POST['emp_addr'];
    $emp_email = $_POST['emp_email'];
    $emp_dept = $_POST['emp_dept'];
    $emp_position = $_POST['emp_position'];

// SQL-запрос на обновление информации о пассажире
    $query = "update airport_employee set emp_lname=?, emp_fname=?, emp_mname=?, emp_bday=?, emp_passport=?, emp_phone=?, emp_addr=?, emp_email=?, emp_dept=?, emp_position=? where emp_id=?";
    $stmt = $mysqli->prepare($query);

// Привязываем параметры
    $rc = $stmt->bind_param('ssssssssssi', $emp_lname, $emp_fname,  $emp_mname, $emp_bday, $emp_passport, $emp_phone, $emp_addr, $emp_email, $emp_dept, $emp_position, $emp_id);
    $stmt->execute();


    if ($stmt) {
        $success = "Информация о сотруднике была обновлена";
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
<div class="be-wrapper be-fixed-sidebar ">

    <!-- Navigation Bar -->
    <?php include('assets/inc/navbar.php'); ?>
    <!-- Конец Navigation Bar -->

    <!-- Sidebar -->
    <?php include('assets/inc/sidebar.php'); ?>
    <!-- Конец Sidebar -->

    <div class="be-content">
        <div class="page-head">
            <h2 class="page-head-title">Обновление информации о сотруднике</h2>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb page-head-nav">
                    <li class="breadcrumb-item"><a href="admin-dashboard.php">Панель управления</a></li>
                    <li class="breadcrumb-item"><a href="admin-manage-employee.php">Сотрудники</a></li>
                    <li class="breadcrumb-item active">Обновление информации о сотруднике</li>
                </ol>
            </nav>
        </div>

        <!--Активация Sweet Alert -->
        <?php if (isset($success)) { ?>
            <!-- Вставка уведомления об успехе -->
            <script>
                setTimeout(function () {
                        swal("Успешно!", "<?php echo $success;?>", "success");
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
            <!-- Форма деталей пассажиров -->
            <?php
            $aid = $_GET['emp_id'];
            $ret = "select * from airport_employee where emp_id=?";
            $stmt = $mysqli->prepare($ret);
            $stmt->bind_param('i', $aid);
            $stmt->execute();
            $res = $stmt->get_result();

            while ($row = $res->fetch_object()) {
                ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-border-color card-border-color-success">
                            <div class="card-header card-header-divider">Обновление информации о сотруднике<span class="card-subtitle">Заполните все поля</span></div>
                            <div class="card-body">
                                <form method="POST">

                                    <div class="form-group row">
                                        <label class="col-12 col-sm-3 col-form-label text-sm-right" for="inputText3">Фамилия</label>
                                        <div class="col-12 col-sm-8 col-lg-6">
                                            <input class="form-control" name="emp_lname" value="<?php echo $row->emp_lname; ?>" id="inputText3" type="text">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-12 col-sm-3 col-form-label text-sm-right" for="inputText3">Имя</label>
                                        <div class="col-12 col-sm-8 col-lg-6">
                                            <input class="form-control" name="emp_fname" value="<?php echo $row->emp_fname; ?>" id="inputText3" type="text">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-12 col-sm-3 col-form-label text-sm-right" for="inputText3">Отчество</label>
                                        <div class="col-12 col-sm-8 col-lg-6">
                                            <input class="form-control" name="emp_mname" value="<?php echo $row->emp_mname; ?>" id="inputText3" type="text">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-12 col-sm-3 col-form-label text-sm-right" for="inputText3">Дата рождения</label>
                                        <div class="col-12 col-sm-8 col-lg-6">
                                            <input class="form-control" name="emp_bday" value="<?php echo $row->emp_bday; ?>" id="inputDate" type="date">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-12 col-sm-3 col-form-label text-sm-right" for="inputText3">Паспорт</label>
                                        <div class="col-12 col-sm-8 col-lg-6">
                                            <input class="form-control" name="emp_passport" value="<?php echo $row->emp_passport; ?>" id="inputText3" type="text">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-12 col-sm-3 col-form-label text-sm-right" for="inputText3">Телефон</label>
                                        <div class="col-12 col-sm-8 col-lg-6">
                                            <input class="form-control" name="emp_phone" value="<?php echo $row->emp_phone; ?>" id="inputText3" type="text">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-12 col-sm-3 col-form-label text-sm-right" for="inputText3">Адрес</label>
                                        <div class="col-12 col-sm-8 col-lg-6">
                                            <input class="form-control" name="emp_addr" value="<?php echo $row->emp_addr; ?>" id="inputText3" type="text">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-12 col-sm-3 col-form-label text-sm-right" for="inputText3">Эл. почта</label>
                                        <div class="col-12 col-sm-8 col-lg-6">
                                            <input class="form-control" name="emp_email" value="<?php echo $row->emp_email; ?>" id="inputText3" type="text">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-12 col-sm-3 col-form-label text-sm-right" for="inputText3">Отдел</label>
                                        <div class="col-12 col-sm-8 col-lg-6">
                                            <select class="form-control" name="emp_dept" required="required" id="select">
                                                <option value="<?php echo $row->emp_dept; ?>"><?php echo $row->emp_dept; ?></option>
                                                <option value="Диспетчерская служба">Диспетчерская служба</option>
                                                <option value="Отдел обслуживания пассажиров">Отдел обслуживания пассажиров</option>
                                                <option value="Технический отдел">Технический отдел</option>
                                                <option value="Отдел логистики">Отдел логистики</option>
                                                <option value="Отдел безопасности" >Отдел безопасности</option>
                                                <option value="Служба медицинской помощи">Служба медицинской помощи</option>
                                                <option value="Отдел коммерческих услуг">Отдел коммерческих услуг</option>
                                                <option value="Финансовый отдел">Финансовый отдел</option>
                                                <option value="Маркетинг и PR" >Маркетинг и PR</option>
                                                <option value="Отдел информационных технологий">Отдел информационных технологий</option>
                                                <option value="Служба уборки аэропорта">Служба уборки аэропорта</option>
                                                <option value="Отдел кадров">Отдел кадров</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-12 col-sm-3 col-form-label text-sm-right" for="inputText3">Должность</label>
                                        <div class="col-12 col-sm-8 col-lg-6">
                                            <input class="form-control" name="emp_position" value="<?php echo $row->emp_position; ?>" id="inputText3" type="text">
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <p class="text-right">
                                            <input class="btn btn-space btn-success" value="Обновить информацию о сотруднике" name="Create_Profile" type="submit">
                                            <button class="btn btn-space btn-danger">Отмена</button>
                                        </p>
                                    </div>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Конец формы деталей пассажира -->
            <?php } ?>
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
<script src="assets/lib/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
<script src="assets/lib/jquery.nestable/jquery.nestable.js" type="text/javascript"></script>
<script src="assets/lib/moment.js/min/moment.min.js" type="text/javascript"></script>
<script src="assets/lib/datetimepicker/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
<script src="assets/lib/select2/js/select2.min.js" type="text/javascript"></script>
<script src="assets/lib/select2/js/select2.full.min.js" type="text/javascript"></script>
<script src="assets/lib/bootstrap-slider/bootstrap-slider.min.js" type="text/javascript"></script>
<script src="assets/lib/bs-custom-file-input/bs-custom-file-input.js" type="text/javascript"></script>
<script src="assets/js/swal.js" type="text/javascript"></script>

<script type="text/javascript">
    $(document).ready(function () {
        // Инициализация JavaScript
        App.init();
        App.formElements();
    });
</script>

</body>
</html>
