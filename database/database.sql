CREATE DATABASE doc_share
  DEFAULT CHARACTER SET utf8
  DEFAULT COLLATE utf8_general_ci;

USE doc_share;
CREATE TABLE `users` (
 `id` tinyint(4) NOT NULL AUTO_INCREMENT,
 `active` TINYINT(1) DEFAULT 0,
 `username` varchar(16) NOT NULL,
 `email` varchar(100) NOT NULL,
 `password` varchar(100) NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
	
insert into users (username, password, email) values ('admin', MD5('admin'), 'mateuszsiek91@gmail.com');

