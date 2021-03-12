<?php

include_once('config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_POST['project']) or $_POST['project'] == '') {
        $errors['project'] = 'Обязательное поле';
    } elseif (preg_match('/\<(.*?)\>/', $_POST['project'])) {
        $errors['project'] = 'Введите имя без тегов';
    } else {
        $stmt = mysqli_prepare($connection, "SELECT * FROM `projects` WHERE `project_name` = ? and `author_id` = ?");
        mysqli_stmt_bind_param($stmt, 'si', $_POST['project'], $_SESSION['id']);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt)) {
            $errors['project'] = 'Проект уже существует';
        }
        mysqli_stmt_free_result($stmt);
        mysqli_stmt_close($stmt);
    }
  
    if (empty($errors)) {
        $_POST['project'] = htmlspecialchars($_POST['project']);
        $_SESSION['id'] = htmlspecialchars($_SESSION['id']);
        $stmt = mysqli_prepare($connection, "INSERT INTO projects(author_id, project_name) VALUES (?,?)");
        mysqli_stmt_bind_param($stmt, 'is', $_SESSION['id'], $_POST['project']);
        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            mysqli_stmt_free_result($stmt);
            mysqli_stmt_close($stmt);
            header('Location: /');
        }
    }
}

if (!isset($_SESSION['id'])) {
    $pageContent = include_template('404.php');
    http_response_code(404);
} else {
    $pageContent = include_template('project.php', ['projects' => $projects, 'errors' => $errors]);
}


$layoutContent = include_template('layout.php', ['pageContent' => $pageContent, 'head_title' => $head_title]);
print($layoutContent);
