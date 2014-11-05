-- phpMyAdmin SQL Dump
-- version 3.5.8.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 03, 2014 at 10:51 AM
-- Server version: 5.5.38-35.2-log
-- PHP Version: 5.4.23

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `unearthe_dropoff`
--

-- --------------------------------------------------------

--
-- Table structure for table `dropoff_courses`
--

DROP TABLE IF EXISTS `dropoff_courses`;
CREATE TABLE IF NOT EXISTS `dropoff_courses` (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `course_title` varchar(128) NOT NULL,
  `session_id` int(11) DEFAULT NULL,
  `session_title` varchar(128) NOT NULL,
  `description` text NOT NULL,
  `syllabus_url` varchar(128) DEFAULT NULL,
  `prerequisites` varchar(128) DEFAULT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `status` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`cid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

-- --------------------------------------------------------

--
-- Table structure for table `dropoff_enrollment`
--

DROP TABLE IF EXISTS `dropoff_enrollment`;
CREATE TABLE IF NOT EXISTS `dropoff_enrollment` (
  `eid` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `session_id` int(11) NOT NULL,
  `enroll_date` datetime DEFAULT NULL,
  `status` varchar(128) DEFAULT 'active',
  PRIMARY KEY (`eid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

-- --------------------------------------------------------

--
-- Table structure for table `dropoff_projects`
--

DROP TABLE IF EXISTS `dropoff_projects`;
CREATE TABLE IF NOT EXISTS `dropoff_projects` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `project_title` varchar(128) NOT NULL,
  `description` text NOT NULL,
  `due_date` datetime NOT NULL,
  `submit_start` datetime NOT NULL,
  `submit_end` datetime NOT NULL,
  `points` int(11) DEFAULT NULL,
  `project_text_req` enum('true','false') DEFAULT 'false',
  `project_url_req` enum('true','false') DEFAULT 'false',
  `project_file_req` enum('true','false') DEFAULT 'false',
  `enroll_date` datetime DEFAULT NULL,
  `status` varchar(128) DEFAULT 'active',
  PRIMARY KEY (`pid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Table structure for table `dropoff_submissions`
--

DROP TABLE IF EXISTS `dropoff_submissions`;
CREATE TABLE IF NOT EXISTS `dropoff_submissions` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `project_text` text,
  `project_url` varchar(256) DEFAULT NULL,
  `project_file` varchar(256) DEFAULT NULL,
  `feedback` text,
  `letter_grade` varchar(2) DEFAULT NULL,
  `points_earned` varchar(128) DEFAULT NULL,
  `submit_date` datetime NOT NULL,
  `status` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `dropoff_tracking`
--

DROP TABLE IF EXISTS `dropoff_tracking`;
CREATE TABLE IF NOT EXISTS `dropoff_tracking` (
  `tid` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `user_host_ip` varchar(15) DEFAULT NULL,
  `track_event` varchar(32) NOT NULL,
  `track_date` datetime NOT NULL,
  `status` varchar(128) DEFAULT 'active',
  PRIMARY KEY (`tid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `dropoff_users`
--

DROP TABLE IF EXISTS `dropoff_users`;
CREATE TABLE IF NOT EXISTS `dropoff_users` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(128) NOT NULL,
  `password` varchar(128) NOT NULL,
  `first_name` varchar(128) NOT NULL,
  `last_name` varchar(128) NOT NULL,
  `email_address` varchar(128) NOT NULL,
  `address` varchar(128) DEFAULT NULL,
  `city` varchar(128) DEFAULT NULL,
  `state` varchar(128) DEFAULT NULL,
  `postal_code` varchar(128) DEFAULT NULL,
  `country` varchar(128) DEFAULT NULL,
  `notify` enum('Yes','No') NOT NULL,
  `dob` datetime DEFAULT NULL,
  `user_type` enum('Admin','Instructor','Student') NOT NULL DEFAULT 'Student',
  `status` varchar(64) NOT NULL DEFAULT 'active',
  PRIMARY KEY (`uid`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email_address` (`email_address`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

-- --------------------------------------------------------

--
-- Table structure for table `dropoff_validation`
--

DROP TABLE IF EXISTS `dropoff_validation`;
CREATE TABLE IF NOT EXISTS `dropoff_validation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `validation_code` varchar(32) NOT NULL,
  `status` varchar(32) DEFAULT 'pending',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
