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
