<?php
include_once('config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['date'])) {
        if (strtotime($_POST['date']) + 86400 < strtotime('now') and !is_date_valid($_POST['date'])) {
            $errors['date'] = 'Неверная дата';
        }
    } else {
        $errors['date'] = 'Укажите дату';
    }
    
    if (!isset($_POST['project']) or !in_array($_POST['project'], $realProjects)) {
        $errors['project'] = 'Выберите из существующих проектов';
    }

    if (!isset($_POST['name']) or $_POST['name'] == '') {
        $errors['name'] = 'Обязательное поле';
    }

    if (empty($errors)) {
        if (isset($_FILES['file']) and  $_FILES['file']['tmp_name']) {
            $taskFile =  $_FILES['file']['name'];
            $uniqTask = uniqid('task_');
            $filePath = $uniqTask . '/' . $taskFile;
            mkdir('./uploads/user_' . $_SESSION['id'] . '/' .  $uniqTask, 0777);
            move_uploaded_file($_FILES['file']['tmp_name'], 'uploads/user_' . $_SESSION['id'] . '/' . $filePath);
        } else {
            $filePath = null;
        }
        
        $_POST['name'] = htmlspecialchars($_POST['name']);
        $_POST['project'] = htmlspecialchars($_POST['project']);
        $_POST['date'] = htmlspecialchars($_POST['date']);
        $filePath = htmlspecialchars($filePath);
        $user['id'] = htmlspecialchars($user['id']);
        $stmt = mysqli_prepare($connection, "INSERT INTO tasks(author_id, project_id, task_name, task_deadline, task_file) VALUES (?,?,?,?,?)");
        mysqli_stmt_bind_param($stmt, 'iisss', $_SESSION['id'], $_POST['project'], $_POST['name'], $_POST['date'], $filePath);
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
    $pageContent = include_template('task.php', ['projects' => $projects, 'errors' => $errors]);
}

$layoutContent = include_template('layout.php', ['pageContent' => $pageContent, 'head_title' => $head_title]);
print($layoutContent);
