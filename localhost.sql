-- Adminer 4.2.5 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

CREATE DATABASE `quantoxtest` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_swedish_ci */;
USE `quantoxtest`;

DROP TABLE IF EXISTS `grades`;
CREATE TABLE `grades` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `math` int(11) NOT NULL,
  `history` int(11) NOT NULL,
  `physics` int(11) NOT NULL,
  `arts` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

INSERT INTO `grades` (`id`, `student_id`, `math`, `history`, `physics`, `arts`) VALUES
(1,	1,	8,	6,	7,	9),
(2,	3,	0,	7,	0,	0),
(3,	4,	0,	7,	8,	0),
(4,	5,	5,	6,	7,	5),
(5,	2,	7,	0,	0,	0),
(6,	6,	7,	8,	9,	5),
(7,	7,	5,	6,	7,	7),
(8,	8,	6,	7,	9,	8);

DROP TABLE IF EXISTS `students`;
CREATE TABLE `students` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) COLLATE utf8_swedish_ci NOT NULL,
  `board` enum('CSM','CSMB') COLLATE utf8_swedish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

INSERT INTO `students` (`id`, `name`, `board`) VALUES
(1,	'John Cusack',	'CSM'),
(2,	'Lucy Liu',	'CSMB'),
(3,	'Mark Harmon',	'CSM'),
(4,	'George Michael',	'CSM'),
(5,	'Elton John',	'CSM'),
(6,	'Sharon Stone',	'CSMB'),
(7,	'Jack Palance',	'CSMB'),
(8,	'Chuck Norris',	'CSMB');

-- 2020-11-11 12:15:48
