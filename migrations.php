<?php

/** @var \PDO $pdo */
require_once './pdo_ini.php';

// users
$sql = <<<'SQL'
CREATE TABLE `users` (
	`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(25) NOT NULL COLLATE 'utf8_general_ci',
	`password` VARCHAR(25) COLLATE 'utf8_general_ci',
	PRIMARY KEY (`id`)
);
SQL;
$pdo->exec($sql);

// lists
$sql = <<<'SQL'
CREATE TABLE `lists` (
	`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`title` VARCHAR(100) NOT NULL COLLATE 'utf8_general_ci',
	`created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`user_id` INT(10) UNSIGNED,
	PRIMARY KEY (`id`),
	FOREIGN KEY (`user_id`) REFERENCES `users` (id)
);
SQL;
$pdo->exec($sql);

// tasks
$sql = <<<'SQL'
CREATE TABLE `tasks` (
	`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`list_id` INT(10) UNSIGNED NOT NULL,
	`is_done` TINYINT(1) NOT NULL DEFAULT 0,
	`title` VARCHAR(100) NOT NULL COLLATE 'utf8_general_ci',
	`created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`),
	FOREIGN KEY (`list_id`) REFERENCES `lists` (id)
);
SQL;
$pdo->exec($sql);