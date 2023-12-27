<?php
include "app/database/db.php";

$errMsg = '';

function userAuth($user){
    $_SESSION['id'] = $user['id'];
    $_SESSION['login'] = $user['username'];
    $_SESSION['admin'] = $user['admin'];

    if($_SESSION['admin']){
        header('location: index.php');
    } else{
        header('location: index.php');
    }
}

// Код для регистрации
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['button-reg'])){
    $admin = 0;
    $login = trim($_POST['login']);
    $mail = trim($_POST['mail']);
    $passF = trim($_POST['pass-first']);
    $passS = trim($_POST['pass-second']);

    if($login === '' || $mail === '' || $passF === '' || $passS === ''){
        $errMsg = "Не все поля заполнены!";
    } elseif (mb_strlen($login, 'UTF8') < 2){
        $errMsg = "Логин должен быть не менее двух символов!";
    } elseif ($passF !== $passS){
        $errMsg = "Пароли не совпадают!";
    } else{
        $existence = selectOne('users', ['email' => $mail]);

        if(is_array($existence) && $existence['email'] === $mail){
           $errMsg = "Пользователь с такой почтой уже зарегистрирован!";
        } else{
            $pass = password_hash($passF, PASSWORD_DEFAULT);
            $post = [
                'admin' => $admin,
                'username' => $login,
                'email' => $mail,
                'password' => $pass
            ];
            $id = insert('users', $post);
            $user = selectOne('users', ['id' => $id]);
            userAuth($user);
        }
    }
} else{
    $login = '';
    $mail = '';
}

// Код для авторизации
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['button-log'])){
    $mail = trim($_POST['mail']);
    $pass = trim($_POST['password']);

    if($mail === '' || $pass === '') {
        $errMsg = "Не все поля заполнены!";
    }else{
        $existence = selectOne('users', ['email' => $mail]);
        if($existence && password_verify($pass, $existence['password'])){
            userAuth($existence);
        }else{
            $errMsg = "Почта либо пароль введены неверно!";
        }
    }
}else{
    $mail = '';
}
