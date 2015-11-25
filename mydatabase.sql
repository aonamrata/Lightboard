

CREATE DATABASE `mydatabase`;
USE `mydatabase`;

-- Database: `mydatabase`

-- Table structure for table `lightboard`


CREATE USER 'root1'@'localhost' IDENTIFIED BY 'root';

GRANT ALL PRIVILEGES ON `mydatabase`.* TO 'root1'@'%'WITH GRANT OPTION;

CREATE TABLE IF NOT EXISTS `lightboard` (
  `id` int(11) NOT NULL,
  `board_data` text NOT NULL,
  `last_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM ;

-- Table structure for table `locking`

CREATE TABLE IF NOT EXISTS `locking` (
  `lock_name` varchar(20) NOT NULL,
  `locked_by` varchar(50) NOT NULL,
  `last_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY `lock_name` (`lock_name`),
  UNIQUE KEY `lock_name_2` (`lock_name`)
) ENGINE=MyISAM ;
