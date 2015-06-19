CREATE DATABASE  IF NOT EXISTS `openDataSubmission` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `openDataSubmission`;


DROP TABLE IF EXISTS `metadata`;

CREATE TABLE `metadata` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(500) NOT NULL,
  `description` text NOT NULL,
  `author` varchar(500) NOT NULL,
  `email` varchar(500) NOT NULL,
  `time` varchar(500) DEFAULT NULL,
  `geo` varchar(500) DEFAULT NULL,
  `source` varchar(500) DEFAULT NULL,
  `submissionDate` DATETIME NULL DEFAULT NOW(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;


CREATE TABLE `openDataSubmission`.`admin_emails` (
  `email` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`email`));