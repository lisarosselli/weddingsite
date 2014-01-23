-- phpMyAdmin SQL Dump
-- version 4.0.6
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 21, 2014 at 04:23 PM
-- Server version: 5.5.33
-- PHP Version: 5.5.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `mcrosswedding`
--

-- --------------------------------------------------------

--
-- Table structure for table `lastnames`
--

CREATE TABLE `lastnames` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `lastname` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=73 ;

--
-- Dumping data for table `lastnames`
--

INSERT INTO `lastnames` (`id`, `lastname`) VALUES
(1, 'rosselli'),
(2, 'lawrence'),
(3, 'supernau'),
(4, 'mcdermott'),
(5, 'nutsch'),
(6, 'croasdale'),
(7, 'chen'),
(8, 'frame'),
(9, 'schellinger'),
(10, 'nack'),
(11, 'cinnamon'),
(12, 'mosher'),
(13, 'spero'),
(14, 'kappleman'),
(15, 'kappelman'),
(16, 'milstein-greengart'),
(17, 'milstein'),
(18, 'greengart'),
(19, 'gunaratne'),
(20, 'martinez'),
(21, 'martinez-ahmadi'),
(22, 'ahmadi'),
(23, 'tegeler'),
(24, 'borders'),
(25, 'jones'),
(26, 'le'),
(27, 'glahn'),
(28, 'vonglahn'),
(29, 'spitzer'),
(30, 'jallits'),
(31, 'florian'),
(32, 'borre'),
(33, 'ember'),
(34, 'tuider'),
(35, 'chambers'),
(36, 'kaczmarek'),
(37, 'kapinos'),
(38, 'sanders'),
(39, 'harrington'),
(40, 'merkel'),
(41, 'nacu'),
(42, 'czajkowski'),
(43, 'shelton'),
(44, 'piironen'),
(45, 'cole'),
(46, 'campbell'),
(47, 'ekiert'),
(48, 'rafter'),
(49, 'marszalik'),
(50, 'minster'),
(51, 'mauck'),
(52, 'dunne'),
(53, 'shed'),
(54, 'shedd'),
(55, 'cohen'),
(56, 'alfawares'),
(57, 'gain'),
(58, 'croasmun'),
(59, 'rust'),
(60, 'cross'),
(61, 'westenkirchner'),
(62, 'loose'),
(63, 'johnson'),
(64, 'fraser'),
(65, 'kearns'),
(66, 'rogers'),
(67, 'neal'),
(68, 'harding'),
(69, 'erdtman'),
(70, 'holley'),
(71, 'baker'),
(72, 'nutsch-westenkirchner');

-- --------------------------------------------------------

--
-- Table structure for table `regrets`
--

CREATE TABLE `regrets` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `regret_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`,`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `regrets`
--

INSERT INTO `regrets` (`id`, `name`, `email`, `regret_date`) VALUES
(8, 'lr rosselli', 'studio1809@gmail.com', '2014-01-17 17:38:49');

-- --------------------------------------------------------

--
-- Table structure for table `rsvp`
--

CREATE TABLE `rsvp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `protein` tinyint(4) NOT NULL,
  `date_rsvpd` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`,`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=57 ;

--
-- Dumping data for table `rsvp`
--

INSERT INTO `rsvp` (`id`, `name`, `email`, `protein`, `date_rsvpd`) VALUES
(56, 'Lisa Rosselli', 'studio1809@gmail.com', 1, '2014-01-21 14:58:51');
