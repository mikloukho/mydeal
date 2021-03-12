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
                    <h2 class="content__main-heading">Добавление задачи</h2>

                    <form class="form" action="task.php" method="POST" autocomplete="off" enctype="multipart/form-data">
                        <div class="form__row">
                            <label class="form__label" for="name">Название <sup>*</sup></label>

                            <input class="form__input <?= isset($errors['name']) ? 'form__input--error' : ''; ?>" type="text" name="name" id="name" value="<?= isset($_POST['name']) ? ($_POST['name']) : ''; ?>"
                                placeholder="Введите название">
                                <p class="form__message"><?= isset($errors['name']) ? $errors['name'] : ''; ?></p>
                        </div>

                        <div class="form__row">
                            <label class="form__label" for="project">Проект <sup>*</sup></label>

                            <select class="form__input form__input--select <?= isset($errors['project']) ? 'form__input--error' : ''; ?>" name="project" id="project">
                                
                                <?php foreach ($projects as $project): ?>

                                <option <?php if (isset($_POST['project']) and $_POST['project'] == $project['id']){echo 'selected';}?> value="<?= $project['id'] ?>"><?= $project['project_name'] ?>
                                </option>

                                <?php endforeach; ?>
                            </select>
                            <p class="form__message"><?= isset($errors['project']) ? $errors['project'] : ''; ?></p>
                        </div>

                        <div class="form__row">
                            <label class="form__label" for="date">Дата выполнения</label>

                            <input class="form__input form__input--date <?= isset($errors['date']) ? 'form__input--error' : ''; ?>" type="text" name="date" id="date" value="<?= isset($_POST['date']) ? ($_POST['date']) : ''; ?>"
                                placeholder="Введите дату в формате ГГГГ-ММ-ДД">
                            <p class="form__message"><?= isset($errors['date']) ? $errors['date'] : ''; ?></p>
                        </div>

                        <div class="form__row">
                            <label class="form__label" for="file">Файл</label>

                            <div class="form__input-file">
                                <input class="visually-hidden" type="file" name="file" id="file" value="">

                                <label class="button button--transparent" for="file">
                                    <span>Выберите файл</span>
                                </label>
                            </div>
                        </div>

                        <div class="form__row form__row--controls">
                            <input class="button" type="submit" name="" value="Добавить">
                        </div>
                    </form>
                </main>