<?php
session_start();
include('assets/inc/config.php');
include('assets/inc/checklogin.php');
check_login();
$aid = $_SESSION['admin_id'];

if (isset($_POST['approve'])) {
    $id = $_GET['pwd_id'];
    $status = $_POST['status'];

    $newPwd = $_POST['newPassword']; // Используем новый введённый пароль из формы
    $hashedPwd = sha1(md5($newPwd)); // Хеширование нового пароля

    // Начало транзакции
    $mysqli->begin_transaction();

    try {
        // Обновляем статус в таблице airport_passwordresets
        $query = "UPDATE airport_passwordresets SET status = ? WHERE pwd_id=?";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param('si', $status, $id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            // Если запрос на сброс пароля успешно обновлён, обновляем пароль пользователя
            $email = $_POST['email']; // Эл. почта пользователя

            $updatePassQuery = "UPDATE airport_passenger SET pass_pwd=? WHERE pass_email=?";
            $updatePassStmt = $mysqli->prepare($updatePassQuery);
            $updatePassStmt->bind_param('ss', $hashedPwd, $email);
            $updatePassStmt->execute();

            if ($updatePassStmt->affected_rows > 0) {
                $mysqli->commit(); // Подтверждение транзакции
                $succ = "Запрос на сброс пароля подтверждён.\\nНовый пароль установлен";
            } else {
                throw new Exception("Ошибка при обновлении пароля пользователя");
            }
        } else {
            throw new Exception("Пожалуйста, повторите попытку позже");
        }
    } catch (Exception $e) {
        // Откат в случае ошибки
        $mysqli->rollback();
        $err = $e->getMessage();
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
            <h2 class="page-head-title">Подтверждение сброса пароля</h2>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb page-head-nav">
                    <li class="breadcrumb-item"><a href="admin-dashboard.php">Панель управления</a></li>
                    <li class="breadcrumb-item"><a href="admin-pending-pwdresets.php">Ожидание сброса пароля</a></li>
                    <li class="breadcrumb-item active">Подтверждение сброса пароля</li>
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
                        swal("Не удалось!", "<?php echo $err;?>", "error");
                    },
                    100);
            </script>
        <?php } ?>

        <div class="main-content container-fluid">
            <!-- Форма сброса пароля -->
            <?php
            $aid = $_GET['pwd_id'];
            $ret = "select * from airport_passwordresets where pwd_id=?";
            $stmt = $mysqli->prepare($ret);
            $stmt->bind_param('i', $aid);
            $stmt->execute();
            $res = $stmt->get_result();
            while ($row = $res->fetch_object()) {
                ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-border-color card-border-color-primary">
                            <div class="card-header card-header-divider">Подтвердите запрос на сброс пароля<span class="card-subtitle">Прежде, чем сделать это, СВЯЖИТЕСЬ С ПАССАЖИРОМ</span></div>
                            <div class="card-body">
                                <form method="POST">

                                    <div class="form-group row">
                                        <label class="col-12 col-sm-3 col-form-label text-sm-right" for="inputText3">Эл. почта пользователя</label>
                                        <div class="col-12 col-sm-8 col-lg-6">
                                            <input class="form-control" name="email" value="<?php echo $row->email; ?>" id="inputText3" type="text">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-12 col-sm-3 col-form-label text-sm-right" for="newPassword">Новый пароль для пользователя</label>
                                        <div class="col-12 col-sm-8 col-lg-6">
                                            <input class="form-control" name="newPassword" type="password" required>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-12 col-sm-3 col-form-label text-sm-right" for="inputText3">Установить новый статус?</label>
                                        <div class="col-12 col-sm-8 col-lg-6">
                                            <select class="form-control" name="status" required="required" id="select">
                                                <option value="Approved" selected="selected">Подтвердить запрос на сброс пароля</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <p class="text-right">
                                            <input class="btn btn-space btn-primary" value="Подтвердить" name="approve" type="submit">
                                            <a href="admin-pending-pwdresets.php" class="btn btn-space btn-secondary">Отмена</a>
                                        </p>
                                    </div>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Конец формы сброса пароля -->
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
<script type="text/javascript">
    $(document).ready(function () {
        // Инициализация JavaScript
        App.init();
        App.formElements();
    });
</script>

</body>
</html>
