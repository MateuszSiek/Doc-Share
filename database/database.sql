CREATE DATABASE doc_share
  DEFAULT CHARACTER SET utf8
  DEFAULT COLLATE utf8_general_ci;

USE doc_share;
CREATE TABLE `users` (
 `id` tinyint(4) NOT NULL AUTO_INCREMENT,
 `active` TINYINT(1) DEFAULT 1,
 `username` varchar(16) NOT NULL,
 `rights` varchar(16) DEFAULT 'user',
 `email` varchar(100) NOT NULL,
 `password` varchar(100) NOT NULL,
 `group_id`  tinyint(4) NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
	
CREATE TABLE `groups` (
 `id` tinyint(4) NOT NULL AUTO_INCREMENT,
 `admin_id` tinyint(4) NOT NULL,
 `active` TINYINT(1) DEFAULT 1,
 `name` varchar(100) NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

insert into groups (admin_id, name) values (1, 'main_group');
insert into users (username, password, email,rights, group_id) values ('admin', MD5('admin'), 'mateuszsiek91@gmail.com','admin',1);
insert into users (username, password, email, group_id) values ('user1', MD5('qwerty'), 'user1@gmail.com',1);
insert into users (username, password, email, group_id) values ('user2', MD5('qwerty'), 'user2@gmail.com',1);
insert into users (username, password, email, group_id) values ('user3', MD5('qwerty'), 'user3@gmail.com',1);


CREATE TABLE `files` (
    `id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `deleted` TINYINT(1) DEFAULT 0,
    `filename` varchar(255) NOT NULL,
    `title` varchar(100) NOT NULL,
    `file_type` varchar(100) NOT NULL,
    `group_id` tinyint(4) NOT NULL,
    `user_id` tinyint(4) NOT NULL,
    `file_size` FLOAT,
    INDEX group_id (group_id),
    FOREIGN KEY files_key(group_id) REFERENCES groups(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;