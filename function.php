<?php


/**
 * Получает массив GET и добавляет к нему переданную пару ключ/значение
 * @param string $key Ключ
 * @param string $value Значение
 * @return string Готовый URL адресс
 */
function get_query($key, $value)
{
    $params = $_GET;
    unset($params[$key]);
    $params[$key] = $value;
    $query =  '/?' . http_build_query($params);
    return $query;
}

/**
 * Инвентирует статус показа выполненных задач
 * @return bool Новый статус показа выполненных задач
 */
function show_completed()
{
    if (isset($_SESSION['show_completed'])) {
        if ($_SESSION['show_completed'] == 1) {
            $_SESSION['show_completed'] = 0;
        } else {
            $_SESSION['show_completed'] = 1;
        }
    } else {
        $_SESSION['show_completed'] = 0;
    }
    return $_SESSION['show_completed'];
}

/**
 * Инвентирует статус выполнения полученной задачи
 * @param int $taskID идентификатор задачи
 * @param bool $connection Сущность соеденения с базой данных
 */
function task_done($connection, $taskId)
{
    $stmt = mysqli_prepare($connection, "SELECT task_done FROM tasks WHERE tasks.id = ?");
    mysqli_stmt_bind_param($stmt, 'i', $taskId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $status =  mysqli_fetch_assoc($result);
    if ($status['task_done'] == 1) {
        $stmt = mysqli_prepare($connection, "UPDATE `tasks` SET `task_done` = 0 WHERE `id` = ?");
        mysqli_stmt_bind_param($stmt, 'i', $taskId);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_free_result($stmt);
        mysqli_stmt_close($stmt);
    } else {
        $stmt = mysqli_prepare($connection, "UPDATE `tasks` SET `task_done` = 1 WHERE `id` = ?");
        mysqli_stmt_bind_param($stmt, 'i', $taskId);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_free_result($stmt);
        mysqli_stmt_close($stmt);
    }
}

/**
 * Выполняет поиск по базе данных
 * @param bool $connection Сущность соеденения с базой данных
 * @param int $userId Идентификатор текущего пользователя
 * @param string $searchQuery Поисковой запрос
 * @return array Результат поиска по базе данных
 */
function search_task($connection, $searchQuery, $userId)
{
    $tasks = [];
    $searchQuery = trim($searchQuery);
    $stmt = mysqli_prepare($connection, "SELECT * FROM tasks WHERE MATCH(task_name) AGAINST(?) AND author_id = ? ORDER BY tasks.task_pubdate DESC");
    mysqli_stmt_bind_param($stmt, 'si', $searchQuery, $userId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $tasks =  mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_stmt_free_result($stmt);
    mysqli_stmt_close($stmt);
    return $tasks;
};

/**
 * Определяет важность задания по мере приблежения дедлайна
 * @param string $task Проверяемая задача
 * @return string Статус задачи
 */
function important($task)
{
    if (!empty($task['task_deadline']) and $task['task_done'] == false) {
        $hoursToDeadline = (strtotime($task['task_deadline']) - strtotime('now')) / 3600;
        if ($hoursToDeadline + 24 <= 24) {
            $important = 'task--important';
        }
    } else {
        $important = '';
    }
    return $important;
}

/**
 * Проверяет переданную дату на соответствие формату 'ГГГГ-ММ-ДД'
 *
 * Примеры использования:
 * is_date_valid('2019-01-01'); // true
 * is_date_valid('2016-02-29'); // true
 * is_date_valid('2019-04-31'); // false
 * is_date_valid('10.10.2010'); // false
 * is_date_valid('10/10/2010'); // false
 *
 * @param string $date Дата в виде строки
 *
 * @return bool true при совпадении с форматом 'ГГГГ-ММ-ДД', иначе false
 */
function is_date_valid(string $date) : bool
{
    $format_to_check = 'Y-m-d';
    $dateTimeObj = date_create_from_format($format_to_check, $date);

    return $dateTimeObj !== false && array_sum(date_get_last_errors()) === 0;
}
/**
 * Подключает шаблон, передает туда данные и возвращает итоговый HTML контент
 * @param string $name Путь к файлу шаблона относительно папки templates
 * @param array $data Ассоциативный массив с данными для шаблона
 * @return string Итоговый HTML
 */
function include_template($name, array $data = [])
{ // Объявляем функцию и атрибуты
    $name = 'templates/' . $name; // Делаем корректный путь до переданного файла
    $result = ''; // Объявляем переменную

    if (!is_readable($name)) { // Условие читаемый ли это файл и есть ли он вообще
        return $result; // Если не читаемый возвращаем пустую переменную
    }

    ob_start(); // Начало буферизации
    extract($data); // Импортируем переменные
    require $name; // Подключаем файл

    $result = ob_get_clean(); // Присваеваем переменной буффер и удаляем его

    return $result; // Возвращаем полученную переменную
}
