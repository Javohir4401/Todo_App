CREATE DATABASE todo_app;

USE todo_app;

create table todo(
id int primary key auto_increment,
title varchar(255),
status enum('pending', 'in_progress', 'completed'),
due_date datetime,
created_at datetime,
updated_ad datetime
);
