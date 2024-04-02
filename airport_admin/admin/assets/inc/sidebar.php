<div class="be-left-sidebar">
    <!-- Обёртка для левой боковой панели -->
    <div class="left-sidebar-wrapper">
        <!-- Заголовок боковой панели, часто используется как кнопка для сворачивания/разворачивания меню -->
        <a class="left-sidebar-toggle" href="#">Панель управления</a>

        <!-- Блок для добавления прокрутки в боковую панель, если элементов много -->
        <div class="left-sidebar-spacer">
            <div class="left-sidebar-scroll">
                <!-- Содержимое боковой панели -->
                <div class="left-sidebar-content">
                    <!-- Список элементов меню боковой панели -->
                    <ul class="sidebar-elements">
                        <!-- Разделительная надпись в меню -->
                        <li class="divider">Меню</li>
                        <!-- Элемент меню "Панель управления" -->
                        <li class=""><a href="admin-dashboard.php"><i class="icon mdi mdi-view-dashboard"></i><span>Панель управления</span></a></li>

                        <!-- PHP-код для вывода информации о профиле администратора -->
                        <?php
                        $aid = $_SESSION['admin_id'];                           // Получение ID администратора из сессии
                        $ret = "select * from airport_admin where admin_id=?";  // SQL-запрос для получения данных администратора
                        $stmt = $mysqli->prepare($ret);
                        $stmt->bind_param('i', $aid);
                        $stmt->execute();
                        $res = $stmt->get_result();

                        while ($row = $res->fetch_object()) {
                            ?>
                            <!-- Элемент меню с подменю для профиля администратора -->
                            <li class="parent">
                                <a href="#"><i class="icon mdi mdi-face"></i><span><?php echo $row->admin_uname; ?></span></a>
                                <ul class="sub-menu">
                                    <li><a href="admin-profile.php">Просмотр профиля</a></li>
                                    <li><a href="admin-profile-avatar.php">Аватар профиля</a></li>
                                    <li><a href="admin-profile-update.php">Обновить профиль</a></li>
                                    <li><a href="admin-profile-password.php">Изменить пароль</a></li>
                                </ul>
                            </li>
                        <?php } ?>

                        <li class="parent"><a href="#"><i class="icon mdi mdi-airplane"></i><span>Рейсы</span></a>
                            <ul class="sub-menu">
                                <li><a href="admin-add-flight.php">Добавить рейс</a>
                                <li><a href="admin-manage-flight.php">Управлять рейсами</a>
                                </li>
                            </ul>
                        </li>

                        <li class="parent"><a href="#"><i class="icon mdi  mdi-account-switch"></i><span>Пассажиры</span></a>
                            <ul class="sub-menu">
                                <li><a href="admin-add-passenger.php">Добавить пассажира</a></li>
                                <li><a href="admin-manage-passengers.php">Управлять пассажирами</a>
                                </li>
                            </ul>
                        </li>

                        <li class="parent"><a href="#"><i class="icon mdi  mdi-account-check"></i><span>Сотрудники</span></a>
                            <ul class="sub-menu">
                                <li><a href="admin-add-employee.php">Добавить сотрудника</a></li>
                                <li><a href="admin-manage-employee.php">Управлять сотрудниками</a>
                                </li>
                            </ul>
                        </li>

                        <li class="parent"><a href="#"><i class="icon mdi mdi-ticket-confirmation"></i><span>Билеты</span></a>
                            <ul class="sub-menu">
                                <li><a href="admin-approved-tickets.php"><span class="badge badge-success float-right">Подтверждённые</span>Просмотр</a>
                                <li><a href="admin-pending-tickets.php"><span class="badge badge-info float-right">Ожидающие</span>Просмотр</a>
                                <li><a href="admin-manage-tickets.php">Управлять билетами</a>
                                </li>
                            </ul>
                        </li>

                        <li class="parent"><a href="#"><i class="icon mdi  mdi-key-variant"></i><span>Сбросы паролей</span></a>
                            <ul class="sub-menu">
                                <li><a href="admin-pwdresets.php">Все запросы</a>
                                <li><a href="admin-pending-pwdresets.php"><span class="badge badge-info float-right">Ожидание</span>Сброс пароля</a></li>
                            </ul>
                        </li>

                        <li class="parent"><a href="#"><i class="icon mdi  mdi-square-inc-cash"></i><span>Финансы</span></a>
                            <ul class="sub-menu">
                                <li><a href="admin-view-accounting.php"><span class="badge badge-success float-right">Оплаты билетов</span>Просмотр</a></li>
                            </ul>
                        </li>

                        <!-- Элемент для выхода из учетной записи -->
                        <li><a href="admin-logout.php "><i class="icon mdi mdi-exit-run"></i><span>Выйти</span></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
