CREATE DATABASE `redirect`;

CREATE TABLE `redirect`.`404errors` (
  `id` int(11) NOT NULL,
  `url` varchar(255) NOT NULL,
  `added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `views` int(10) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
 );

CREATE TABLE `redirect`.`requests` (
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `request` varchar(255) NOT NULL,
  `ip` varchar(255) NOT NULL,
  `ok` tinyint(1) NOT NULL DEFAULT 0
);

CREATE TABLE `redirect`.`translation` (
  `short_url` varchar(25) NOT NULL,
  `long_url` varchar(255) NOT NULL,
  `added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `views` int(10) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`short_url`)
);

CREATE TABLE `redirect`.`users` (
	id int NOT NULL,
	name varchar(25) NOT NULL,
	password varchar(255) NOT NULL,
	registered timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	last_login datetime,
	last_ip varchar(255),
	PRIMARY KEY(id)
);

CREATE UNIQUE INDEX username_idx USING HASH ON `redirect`.`users`(name);

CREATE TABLE `redirect`.`tokens` (
	id int NOT NULL,
	value varchar(255) NOT NULL,
	owner int NOT NULL,
	added timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	expiry datetime,
	revoked tinyint(1) NOT NULL DEFAULT 0,
	PRIMARY KEY(id),
	FOREIGN KEY(owner) REFERENCES `redirect`.`users`(id)
);

CREATE UNIQUE INDEX token_idx USING HASH ON `redirect`.`tokens`(value);
