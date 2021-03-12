<section class="content__side">
    <h2 class="content__side-heading">Проекты</h2>

    <nav class="main-navigation">
        <ul class="main-navigation__list">

            <?php foreach ($projects as $project): ?>

            <li class="main-navigation__list-item <?= ($project['id'] == $_GET['id']) ? 'main-navigation__list-item--active':''?>">
                <a class="main-navigation__list-item-link" href="<?= get_query('id', $project['id']) ?>"><?= $project['project_name'] ?></a>
                <span class="main-navigation__list-item-count"><?= $project['task_count'] ?></span>
            </li>
            
            <?php endforeach; ?>

        </ul>
    </nav>

    <a class="button button--transparent button--plus content__side-button"
        href="project.php">Добавить проект</a>
</section>

<main class="content__main">
    <h2 class="content__main-heading">Список задач</h2>

    <form class="search-form" action="/" method="GET" autocomplete="off">
        <input class="search-form__input" type="text" name="search_query" value="<?= isset($_GET['search_query']) ? $_GET['search_query'] : '' ?>" placeholder="Поиск по задачам">

        <input class="search-form__submit" type="submit">
    </form>

    <div class="tasks-controls">
        <nav class="tasks-switch">
            <a href="<?= get_query('tab', 'all') ?>" class="tasks-switch__item <?= ($_GET['tab'] == 'all') ? "tasks-switch__item--active" : ""?>">Все задачи</a>
            <a href="<?= get_query('tab', 'today') ?>" class="tasks-switch__item <?= ($_GET['tab'] == 'today') ? "tasks-switch__item--active" : ""?>">Повестка дня</a>
            <a href="<?= get_query('tab', 'tomorrow') ?>" class="tasks-switch__item <?= ($_GET['tab'] == 'tomorrow') ? "tasks-switch__item--active" : ""?>">Завтра</a>
            <a href="<?= get_query('tab', 'overdude') ?>" class="tasks-switch__item <?= ($_GET['tab'] == 'overdude') ? "tasks-switch__item--active" : ""?>">Просроченные</a>
        </nav>
        <form action="/<?= count($_GET) ? '?' . http_build_query($_GET) : '' ?>" method="POST" autocomplete="off">        
            <label class="checkbox">
                <input onchange = "form.submit()" class="checkbox__input visually-hidden show_completed" type="checkbox" name = "show_completed" value = "0">
                <input <?= ($_SESSION['show_completed']) ? "checked" : "" ?> onchange = "form.submit()" class="checkbox__input visually-hidden show_completed" type="checkbox" name = "show_completed" value = "1">
                <span class="checkbox__text">Показывать выполненные</span>
            </label>
        </form>
    </div>

    <table class="tasks">
        <?php if(empty($tasks) and isset($_GET['search_query'])):?>
        <p> По вашему запросу ничего не найдено! </p>
        <?php endif;?>
        <?php foreach ($tasks as $task):
        if ($task['task_done'] and $_SESSION['show_completed'] == false) {continue;}
        if (isset($_GET['id'])){
            if ($task['project_id'] != $_GET['id']) {continue;}
        }
        ?>
        <tr class="tasks__item task <?= important($task) ?> <?= ($task['task_done']) ? 'task--completed' : ''; ?>">
            <td class="task__select">
               <form action="/<?= count($_GET) ? '?' . http_build_query($_GET) : '' ?>" method="POST" autocomplete="off">
                    <label class="checkbox task__checkbox">
                        <input onchange = "form.submit()" class="checkbox__input visually-hidden task__checkbox" type="checkbox" name = "task_done" value = "<?= $task['id'] ?>">
                        <input <?= ($task['task_done']) ? "checked" : "" ?>  onchange = "form.submit()" class="checkbox__input visually-hidden task__checkbox" type="checkbox" name = "task_done" value = "<?= $task['id'] ?>">
                        <span class="checkbox__text"><?= $task['task_name'] ?></span>
                    </label>
               </form>
            </td>
            <td class="task__file">
                <?php if (isset($task['task_file']) and $task['task_file'] != null):?>
                <a download class="download-link" href='./uploads/user_<?= $_SESSION['id'] . '/' .$task['task_file']  ?>'> <?= substr($task['task_file'], 19) ?> </a>
                <?php endif;?>    
            </td>
            <td class="task__date"><?= ($task['task_deadline']) ? date("d.m.Y", strtotime($task['task_deadline'])) : ''; ?></td>
        </tr>
        
        <?php endforeach; ?>
    </table>
</main>
                    