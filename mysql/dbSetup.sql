create database application;

use application;

CREATE TABLE tbl_users (
	-> id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	-> username VARCHAR(32),
	-> password VARCHAR(32),
	-> welcome VARCHAR(32)
	-> );

create user 'user'@'localhost' identified by 'password';

grant all privileges on application . * TO 'user'@'localhost';

flush privileges;

insert into tbl_users (id,username,password,welcome) values (NULL,'user@email.com','password','hi');

select * from tbl_users;
