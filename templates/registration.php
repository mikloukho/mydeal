<section class="content__side">
    <p class="content__side-info">Если у вас уже есть аккаунт, авторизуйтесь на сайте</p>

    <a class="button button--transparent content__side-button" href="form-authorization.html">Войти</a>
</section>

<main class="content__main">
    <h2 class="content__main-heading">Регистрация аккаунта</h2>

    <form class="form" action="registration.php" method="POST" autocomplete="off">
        <div class="form__row">
            <label class="form__label" for="email">E-mail <sup>*</sup></label>

            <input class="form__input <?= isset($errors['email']) ? 'form__input--error' : ''; ?>" type="text" name="email" id="email" value="<?= isset($_POST['email']) ? ($_POST['email']) : ''; ?>"
                placeholder="Введите e-mail">

            <p class="form__message"><?= isset($errors['email']) ? $errors['email'] : ''; ?></p>
        </div>

        <div class="form__row">
            <label class="form__label" for="password">Пароль <sup>*</sup></label>

            <input class="form__input <?= isset($errors['password']) ? 'form__input--error' : ''; ?>" type="password" name="password" id="password" value="<?= isset($_POST['password']) ? ($_POST['password']) : ''; ?>"
                placeholder="Введите пароль">
                <p class="form__message"><?= isset($errors['password']) ? $errors['password'] : ''; ?></p>
        </div>

        <div class="form__row">
            <label class="form__label" for="name">Имя <sup>*</sup></label>

            <input class="form__input" type="text" name="name" id="name" value="<?= isset($_POST['name']) ? ($_POST['name']) : ''; ?>"
                placeholder="Введите имя">
            <p class="form__message"><?= isset($errors['name']) ? $errors['name'] : ''; ?></p>
        </div>

        <div class="form__row form__row--controls">
            <p class="error-message"><?= count($errors) ? 'Пожалуйста, исправьте ошибки в форме' : ''; ?></p>

            <input class="button" type="submit" name="" value="Зарегистрироваться">
        </div>
    </form>
</main>