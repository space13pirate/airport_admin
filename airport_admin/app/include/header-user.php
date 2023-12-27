<!-- Блок хедера - START -->
<header class="container-fluid">
    <div class="container">
        <div class="row">

            <div class="col-4">
                <h1>
                    <a href="#">Airport</a>
                </h1>
            </div>

            <nav class="col-8">
                <ul>
                    <li>
                        <a href="#">
                            <i class="fa-solid fa-plane"></i>
                            Рейсы
                        </a>
                    </li>

                    <li>
                        <a href="#">
                            <i class="fa-solid fa-passport"></i>
                            Самолёты
                        </a>
                    </li>

                    <li>
                        <a href="#">
                            <i class="fa-solid fa-ticket"></i>
                            Бронирования и билеты
                        </a>
                    </li>

                    <li>
                        <?php if (isset($_SESSION['id'])): ?>
                            <a href="#">
                                <i class="fa-solid fa-user"></i>
                                <?php echo $_SESSION['login']; ?>
                            </a>
                            <ul>
                                <?php if ($_SESSION['admin']): ?>
                                    <li><a href="#">Админ панель</a></li>
                                <?php endif; ?>
                                <li><a href="log.php">Выйти</a></li>
                            </ul>
                        <?php else: ?>
                            <a href="/log.php">
                                <i class="fa-solid fa-user"></i>
                                Войти
                            </a>
                            <ul>
                                <li><a href="reg.php">Зарегистрироваться </a></li>
                            </ul>
                        <?php endif; ?>

                    </li>
                </ul>
            </nav>

        </div>
    </div>
</header>
<!-- Блок хедера - END -->