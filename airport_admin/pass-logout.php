<?php
session_start();                // Начало новой сессии или восстановление существующей
unset($_SESSION['pass_id']);    // Удаляем переменную 'pass_id' из сессии
session_destroy();              // Уничтожаем сессию, чтобы удалить все данные сессии на сервере

header("Location: pass-login.php");  // Перенаправляем пользователя на страницу входа
exit;   // Завершаем выполнение скрипта, чтобы после перенаправления никакой дополнительный код не выполнялся
?>
