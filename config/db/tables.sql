-- Probably not required.

CREATE TABLE IF NOT EXISTS `###raf_settings`
(
	`id` INT(10) NOT NULL AUTO_INCREMENT,
	`templatePage` INT(10) NOT NULL,
	`products` LONGTEXT NOT NULL,
	PRIMARY KEY (`id`)
) ~~~COLLATE;

-- Table structure for RAF Members table.

CREATE TABLE IF NOT EXISTS `###raf_members`
(
	`id` INT(10) NOT NULL AUTO_INCREMENT,
	`memberID` INT(10) NOT NULL UNIQUE,
	`memberEmail` VARCHAR(191) NOT NULL UNIQUE,
	`memberAffID` VARCHAR(191) NOT NULL UNIQUE,
	`referedUsers` LONGTEXT NULL,
	`totalRefered` LONGTEXT NULL,
	`discounts` LONGTEXT NULL,
	`createdAt` DATETIME DEFAULT CURRENT_TIMESTAMP,
	`modifiedAt` DATETIME ON UPDATE CURRENT_TIMESTAMP, 
	PRIMARY KEY (`id`)
) ~~~COLLATE;

-- Table structure for RAF Email Templates table.

CREATE TABLE IF NOT EXISTS `###raf_email_templates`
(
	`id` INT(10) NOT NULL AUTO_INCREMENT,
	`subject` LONGTEXT NULL,
	`content` LONGTEXT NULL,
	`createdAt` DATETIME DEFAULT CURRENT_TIMESTAMP,
	`modifiedAt` DATETIME ON UPDATE CURRENT_TIMESTAMP, 
	PRIMARY KEY (`id`)
) ~~~COLLATE;