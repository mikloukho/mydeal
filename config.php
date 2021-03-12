<?php

include_once('function.php');

session_start();
$connection = mysqli_connect('127.0.0.1', 'root', 'root', 'mydeal_db');

if ($connection) {
    mysqli_set_charset($connection, "utf8");
} else {
    echo "Ошибка: Невозможно подключиться к MySQL " . mysqli_connect_error();
}

if (isset($_SESSION['id'])) {
    $user = mysqli_fetch_assoc(mysqli_query($connection, "SELECT * FROM `users` WHERE `id` = '$_SESSION[id]'"));
    $projects = mysqli_fetch_all(mysqli_query($connection, "SELECT project_name, projects.id, COUNT(tasks.id) AS task_count FROM projects LEFT JOIN tasks ON tasks.project_id = projects.id WHERE projects.author_id = '$_SESSION[id]' GROUP BY projects.id ORDER BY task_count DESC"), MYSQLI_ASSOC);
    $tasks = mysqli_fetch_all(mysqli_query($connection, "SELECT * FROM tasks WHERE author_id = '$_SESSION[id]' ORDER BY tasks.task_pubdate DESC"), MYSQLI_ASSOC);
    $realProjects = [];

    foreach ($projects as $project) {
        array_push($realProjects, $project['id']);
    }
}

$title = 'Дела в порядке';
$errors = [];
