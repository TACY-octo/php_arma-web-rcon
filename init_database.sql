DROP DATABASE IF EXISTS admin; 
CREATE DATABASE admin;
CREATE USER IF NOT EXISTS 'admin-squad'@'localhost' IDENTIFIED BY 'motdepasse';
DROP TABLE users; 
CREATE TABLE users (
  userid integer NOT NULL AUTO_INCREMENT,
  username varchar(30) NOT NULL,
  password varchar(255) NOT NULL,
  PRIMARY KEY  (userid)
) ENGINE=InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci;

DROP TABLE IF EXISTS servers;
CREATE TABLE servers (
  serverid integer NOT NULL AUTO_INCREMENT,
  address varchar(32) NOT NULL, 
  ports integer NOT NULL, 
  passwords varchar(255) NOT NULL,
  PRIMARY KEY (serverid)
) ENGINE=InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci;

INSERT INTO servers(address, ports, passwords) VALUES('127.0.0.1', 2302, 'RConPassword');
INSERT INTO users(username, password) VALUES('admin','12345');

GRANT ALL PRIVILEGES ON admin.* TO 'admin-squad'@'localhost';
FLUSH PRIVILEGES;