INSERT INTO users SET user_name = 'Михаил',
                     user_email = 'mikhail@gmail.com',
                     user_password = SHA1('hesoyam137');

INSERT INTO users SET user_name = 'Алексей',
                     user_email = 'alexey@gmail.com',
                     user_password = SHA1('aezakmi137');
INSERT INTO users SET user_name = 'Алёна',
                     user_email = 'alyona@gmail.com',
                     user_password = SHA1('qwerty137');
                     
INSERT INTO projects SET author_id = 1, 
                        project_name = "Входящие";
INSERT INTO projects SET author_id = 1, 
                        project_name = "Учеба";
INSERT INTO projects SET author_id = 1, 
                        project_name = "Работа";
INSERT INTO projects SET author_id = 2, 
                        project_name = "Домашние дела";
INSERT INTO projects SET author_id = 1, 
                        project_name = "Авто";
INSERT INTO projects SET author_id = 3, 
                        project_name = "Желания";

INSERT INTO tasks SET author_id = 1,
                     project_id = 3,
                     task_name = 'Собеседование в IT компании',
                     task_deadline = '2021.02.07',
                     task_done = 0;
INSERT INTO tasks SET author_id = 1,
                     project_id = 3,
                     task_name = 'Выполнить тестовое задание',
                     task_deadline = '2021.02.03',
                     task_done = 0;
INSERT INTO tasks SET author_id = 1,
                     project_id = 2,
                     task_name = 'Сделать задание первого раздела',
                     task_deadline = '2021.02.01',
                     task_done = 1;
INSERT INTO tasks SET author_id = 1,
                     project_id = 1,
                     task_name = 'Встреча с другом',
                     task_deadline = '2021.01.31',
                     task_done = 0;
INSERT INTO tasks SET author_id = 2,
                     project_id = 4,
                     task_name = 'Купить корм для кота',
                     task_done = 0;                                          
INSERT INTO tasks SET author_id = 2,
                     project_id = 4,
                     task_name = 'Заказать пиццу',
                     task_done = 0;
INSERT INTO tasks SET author_id = 3,
                     project_id = 6,
                     task_name = 'Полететь в космос',
                     task_done = 0;
INSERT INTO tasks SET author_id = 3,
                     project_id = 6,
                     task_name = 'Прыгнуть с парашутом',
                     task_done = 0;

-- Получаем список проектов одного из пользователей
SELECT `project_name` FROM `projects` WHERE `author_id` = 1;
-- Получаем список задач одного из проектов
SELECT `task_name` FROM `tasks` WHERE `project_id` = 3;
-- Помечаем одну из задач как выполненную
UPDATE `tasks` SET `task_done` = 1 WHERE `id` = 1;
-- Меняем имя задачи по ее id
UPDATE `tasks` SET `task_name` = 'Сдать 6 занятие на проверку' WHERE `id` = 2;