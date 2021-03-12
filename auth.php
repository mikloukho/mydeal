<?php

include_once('config.php');

if (isset($_SESSION['id'])) {
    header('Location:/');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_POST['email']) or $_POST['email'] == '') {
        $errors['email'] = 'Обязательное поле';
    } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'E-mail введён некорректно';
    } else {
        $stmt = mysqli_prepare($connection, "SELECT * FROM `users` WHERE `user_email` = ?");
        mysqli_stmt_bind_param($stmt, 's', $_POST['email']);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (!mysqli_stmt_num_rows($stmt)) {
            $errors['email'] = 'E-mail не зарегистрирован';
        }
        mysqli_stmt_free_result($stmt);
        mysqli_stmt_close($stmt);
    }
   
    if (!isset($_POST['password']) or $_POST['password'] == '') {
        $errors['password'] = 'Обязательное поле';
    } else {
        $stmt = mysqli_prepare($connection, "SELECT `user_password` FROM `users` WHERE `user_email` = ?");
        mysqli_stmt_bind_param($stmt, 's', $_POST['email']);
        mysqli_stmt_execute($stmt);
        $stmt = mysqli_stmt_get_result($stmt);
        $pass = mysqli_fetch_assoc($stmt);

        if (!password_verify($_POST['password'], $pass['user_password'])) {
            $errors['password'] = 'Не верный пароль';
        }
    }

    if (empty($errors)) {
        $stmt = mysqli_prepare($connection, "SELECT * FROM `users` WHERE `user_email` = ?");
        mysqli_stmt_bind_param($stmt, 's', $_POST['email']);
        mysqli_stmt_execute($stmt);
        $stmt = mysqli_stmt_get_result($stmt);
        $user = mysqli_fetch_assoc($stmt);
        $_SESSION['id'] = $user['id'];
        $_SESSION['user'] = $user['user_name'];
        $_SESSION['show_completed'] = 0;
        header('Location: /');
    }
}


$pageContent = include_template('auth.php', ['errors' => $errors]);
$layoutContent = include_template('layout.php', ['pageContent' => $pageContent, 'head_title' => $head_title]);
print($layoutContent);
