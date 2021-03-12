<section class="content__side">
<h2 class="content__side-heading">Проекты</h2>

<nav class="main-navigation">
    <ul class="main-navigation__list">

        <?php foreach ($projects as $project): ?>

        <li class="main-navigation__list-item <?= ($project['id'] == $_GET['id']) ? 'main-navigation__list-item--active':''?>">
            <a class="main-navigation__list-item-link" href="/?id=<?= $project['id'] ?>"><?= $project['project_name'] ?></a>
            <span class="main-navigation__list-item-count"><?= $project['task_count'] ?></span>
        </li>

        <?php endforeach; ?>

    </ul>
</nav>

<a class="button button--transparent button--plus content__side-button"
    href="project.php">Добавить проект</a>
</section>

<main class="content__main">
<h2 class="content__main-heading">Добавление проекта</h2>

<form class="form" action="project.php" method="POST" autocomplete="off">
    <div class="form__row">
        <label class="form__label" for="project_name">Название <sup>*</sup></label>

        <input class="form__input <?= isset($errors['project']) ? 'form__input--error' : ''; ?>" type="text" name="project" id="project_name" value="<?= isset($_POST['project']) ? ($_POST['project']) : ''; ?>"
            placeholder="Введите название проекта">
        <p class="form__message"><?= isset($errors['project']) ? $errors['project'] : ''; ?></p>
    </div>

    <div class="form__row form__row--controls">
        <input class="button" type="submit" name="" value="Добавить">
    </div>
</form>
</main>