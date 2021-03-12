  
<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<body>
<h1>Уведомление от сервиса «Дела в порядке»</h1>

<p>Уважаемый, <?= $userName ?> </p>
<p>У вас запланирована задача: </p>
<ul>
    <?php foreach ($tasks as $task) : ?>
        <li><?= $task['task_name']; ?> на <?= ($task['task_deadline']) ? date("d.m.Y", strtotime($task['task_deadline'])) : ''; ?></li>
    <?php endforeach; ?>

</ul>

</body>
</html>