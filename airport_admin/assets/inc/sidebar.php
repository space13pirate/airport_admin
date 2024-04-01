<div class="be-left-sidebar">
    <!-- Обёртка для левой боковой панели -->
    <div class="left-sidebar-wrapper">
        <!-- Заголовок боковой панели, часто используется как кнопка для сворачивания/разворачивания меню -->
        <a class="left-sidebar-toggle" href="#">Панель информации</a>

        <!-- Блок для добавления прокрутки в боковую панель, если элементов много -->
        <div class="left-sidebar-spacer">
            <div class="left-sidebar-scroll">
                <!-- Содержимое боковой панели -->
                <div class="left-sidebar-content">
                    <!-- Список элементов меню боковой панели -->
                    <ul class="sidebar-elements">
                        <!-- Разделительная надпись в меню -->
                        <li class="divider">Меню</li>
                        <!-- Элемент меню "Панель информации" -->
                        <li class=""><a href="pass-dashboard.php"><i class="icon mdi mdi-view-dashboard"></i><span>Панель информации</span></a>
                        </li>

                        <!-- PHP-код для вывода информации о профиле пассажира -->
                        <?php
                        $aid = $_SESSION['pass_id']; // Получение ID пассажира из сессии
                        $ret = "select * from airport_passenger where pass_id=?"; // SQL-запрос для получения данных пассажира
                        $stmt = $mysqli->prepare($ret);
                        $stmt->bind_param('i', $aid);
                        $stmt->execute();//ok
                        $res = $stmt->get_result();

                        while ($row = $res->fetch_object()) {
                            ?>
                            <!-- Элемент меню с подменю для профиля пассажира -->
                            <li class="parent"><a href="#"><i
                                            class="icon mdi mdi-face"></i><span>Пассажир <?php echo $row->pass_uname; ?></span></a>
                                <ul class="sub-menu">
                                    <li><a href="pass-profile.php">Просмотр профиля</a></li>
                                    <li><a href="pass-profile-avatar.php">Аватар профиля</a></li>
                                    <li><a href="pass-profile-update.php">Обновить профиль</a></li>
                                    <li><a href="pass-profile-password.php">Изменить пароль</a></li>
                                </ul>
                            </li>
                        <?php } ?>

                        <li class="parent"><a href="#"><i class="icon mdi mdi-airplane"></i><span>Рейсы</span></a>
                            <ul class="sub-menu">
                                <li><a href="pass-book-flight.php">Просмотр рейсов</a></li>
                                <li><a href="pass-my-booked-flight.php">Мои бронирования</a></li>
                            </ul>

                        <li class="parent"><a href="#"><i
                                        class="icon mdi mdi-ticket-confirmation"></i><span>Билеты</span></a>
                            <ul class="sub-menu">
                                <li><a href="pass-ticket.php">Мои билеты</a></li>
                            </ul>
                        </li>

                        <!-- Элемент для выхода из учетной записи -->
                        <li><a href="pass-logout.php "><i class="icon mdi mdi-exit-run"></i><span>Выйти</span></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>