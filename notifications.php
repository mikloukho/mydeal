<?php

include_once('config.php');
include_once('./vendor/autoload.php');

$transport = (new Swift_SmtpTransport('smtp.gmail.com', 587, 'tls'))
  ->setUsername('EMAIL')
  ->setPassword('PASSWORD');

$mailer = new Swift_Mailer($transport);
$result = mysqli_query($connection, 'SELECT id, user_email, user_name FROM `users`');
$users = mysqli_fetch_all($result, MYSQLI_ASSOC);

foreach ($users as $user) {
    $result = mysqli_query($connection, "SELECT * FROM `tasks` WHERE `task_done` = 0 AND `task_deadline` = CURDATE() AND tasks.author_id = $user[id]");
    $tasks = mysqli_fetch_all($result, MYSQLI_ASSOC);
    if (!empty($tasks)) {
        $message = new Swift_Message("Ваши задачи на сегодня");
        $message->setTo([$user['user_email'] => 'Дела в порядке']);
        $pageMessage = include_template('message.php', ['tasks' => $tasks, 'userName' => $user['user_name']]);
        $message->setBody($pageMessage, 'text/html');
        $message->setFrom('mikloukho137@gmail.com', 'mydeal');
        $result = $mailer->send($message);
        if ($result) {
            echo "Send for '$user[user_email]' <br>";
        }
    }
}
