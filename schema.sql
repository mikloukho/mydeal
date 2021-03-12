CREATE DATABASE mydeal_db
    DEFAULT CHARACTER SET utf8
    DEFAULT COLLATE utf8_general_ci;

USE mydeal_db;

CREATE TABLE users (
    id int AUTO_INCREMENT PRIMARY KEY,
    user_name VARCHAR(128) NOT NULL,
    user_email VARCHAR(256) NOT NULL UNIQUE,
    user_password CHAR(128) NOT NULL,
    registration_date DATETIME default CURRENT_TIMESTAMP()
);

CREATE TABLE projects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    project_name VARCHAR(128) NOT NULL,
    author_id int NOT NULL,
    FOREIGN KEY(author_id) REFERENCES users(id)
);

CREATE TABLE tasks (
    id int AUTO_INCREMENT PRIMARY KEY,
    task_done tinyint(1) default 0,
    task_name VARCHAR(128) NOT NULL,
    task_deadline DATETIME default NULL,
    task_pubdate DATETIME default CURRENT_TIMESTAMP(),
    task_file VARCHAR(2048) default NULL,
    project_id int default NULL,
    author_id int NOT NULL,
    FOREIGN KEY(author_id) REFERENCES users(id),
    FOREIGN KEY(project_id) REFERENCES projects(id)
);

CREATE INDEX user_name ON users(user_name);
CREATE INDEX project_name ON projects(project_name);
CREATE FULLTEXT INDEX task_search ON tasks(task_name);




