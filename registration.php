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

        if (mysqli_stmt_num_rows($stmt)) {
            $errors['email'] = 'E-mail уже зарегистрирован';
        }
        mysqli_stmt_free_result($stmt);
        mysqli_stmt_close($stmt);
    }

    if (!isset($_POST['password']) or $_POST['password'] == '') {
        $errors['password'] = 'Обязательное поле';
    }

    if (!isset($_POST['name']) or $_POST['name'] == '') {
        $errors['name'] = 'Обязательное поле';
    } elseif (preg_match('/\<(.*?)\>/', $_POST['name'])) {
        $errors['name'] = 'Введите имя без тегов';
    }

    if (empty($errors)) {
        $_POST['name'] = htmlspecialchars($_POST['name']);
        $_POST['email'] = htmlspecialchars($_POST['email']);
        $_POST['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $stmt = mysqli_prepare($connection, "INSERT INTO users(user_name, user_email, user_password) VALUES (?,?,?)");
        mysqli_stmt_bind_param($stmt, 'sss', $_POST['name'], $_POST['email'], $_POST['password']);
        $result = mysqli_stmt_execute($stmt);
        
        if ($result) {
            $new = mysqli_insert_id($connection);
            mkdir('./uploads/user_' . $new, 0777);
            header('Location: /auth.php');
        }
    }
}

$pageContent = include_template('registration.php', ['errors' => $errors]);
$layoutContent = include_template('layout.php', ['pageContent' => $pageContent, 'head_title' => $head_title]);
print($layoutContent);
