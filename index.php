<?php
include_once('config.php');

if (isset($_SESSION['id'])) {
    if (count($_GET) or count($_POST)) {
        if (isset($_GET['search_query'])) {
            $tasks = search_task($connection, $_GET['search_query'], $_SESSION['id']);
        }
        
        if (isset($_GET['tab'])) {
            switch ($_GET['tab']) {
                case 'today':
                    $tasks = mysqli_fetch_all(mysqli_query($connection, "SELECT * FROM tasks WHERE author_id = '$_SESSION[id]' AND `task_deadline` = CURRENT_DATE() ORDER BY tasks.task_pubdate DESC"), MYSQLI_ASSOC);
                    break;
                case 'tomorrow':
                    $tasks = mysqli_fetch_all(mysqli_query($connection, "SELECT * FROM tasks WHERE author_id = '$_SESSION[id]' AND `task_deadline` = CURRENT_DATE() + INTERVAL 1 DAY ORDER BY tasks.task_pubdate DESC"), MYSQLI_ASSOC);
                    break;
                case 'overdude':
                    $tasks = mysqli_fetch_all(mysqli_query($connection, "SELECT * FROM tasks WHERE author_id = '$_SESSION[id]' AND `task_deadline` < CURRENT_DATE() ORDER BY tasks.task_pubdate DESC"), MYSQLI_ASSOC);
                    break;
                default:
                    $tasks = mysqli_fetch_all(mysqli_query($connection, "SELECT * FROM tasks WHERE author_id = '$_SESSION[id]' ORDER BY tasks.task_pubdate DESC"), MYSQLI_ASSOC);
                    break;
            }
        }

        if (isset($_POST['task_done'])) {
            task_done($connection, $_POST['task_done']);
            header('Refresh:0');
        }

        if (isset($_POST['show_completed'])) {
            show_completed();
            header('Refresh:0');
        }
        
        foreach ($_GET as $key => $value) {
            $validGet = ['id', 'tab', 'search_query'];

            if (!in_array($key, $validGet)) {
                $pageContent = include_template('404.php');
                http_response_code(404);
                break;
            } else {
                $pageContent = include_template('main.php', ['projects' => $projects, 'tasks' => $tasks]);
            }
        }

        if (isset($_GET['id']) and !in_array($_GET['id'], $realProjects)) {
            $pageContent = include_template('404.php');
            http_response_code(404);
        }
    } else {
        $pageContent = include_template('main.php', ['projects' => $projects, 'tasks' => $tasks]);
    }
} else {
    $pageContent = include_template('guest.php');
}

$layouContent = include_template('layout.php', ['pageContent' => $pageContent, 'head_title' => $head_title]);
print($layouContent);
