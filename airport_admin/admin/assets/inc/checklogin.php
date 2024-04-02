<?php
// Функция для проверки состояния входа администратора
function check_login()
{
	// Проверка, установлен ли ID администратора в сессии и не равен ли он нулю
	if(strlen($_SESSION['admin_id']) == 0)
	{
		// Получение имени хоста из текущего запроса
		$host = $_SERVER['HTTP_HOST'];
		// Получение пути к скрипту текущего запроса и очистка его от лишних символов
		$uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
		// Задание конечного URL для перенаправления
		$extra = "admin-login.php";
		// Очистка значения admin_id в сессии
		$_SESSION["admin_id"] = "";
		// Перенаправление пользователя на страницу входа администратора
		header("Location: http://$host$uri/$extra");
	}
}
?>