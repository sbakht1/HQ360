-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 26, 2022 at 12:08 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `twe_app`
--

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `designation` varchar(100) NOT NULL,
  `status` varchar(100) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `home_number` varchar(100) NOT NULL,
  `cellular_number` varchar(100) NOT NULL,
  `work_number` varchar(100) NOT NULL,
  `start_date` varchar(100) NOT NULL,
  `terminate_date` varchar(100) NOT NULL,
  `supervisor` varchar(100) NOT NULL,
  `created` varchar(100) NOT NULL,
  `updated` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `firstname`, `lastname`, `email`, `password`, `designation`, `status`, `fullname`, `home_number`, `cellular_number`, `work_number`, `start_date`, `terminate_date`, `supervisor`, `created`, `updated`) VALUES
(1, 'Waqar', 'Ahmed', 'waqar.tek@gmail.com', '82d220df17cebf5ce4897d780c354dd5e925c209', 'admin', 'active', 'Waqar Ahmed', '{\"home\":\"+923462471971\",\"work\":\"+956565885\",\"cellular\":\"+22337789812\"}', '', '', '2022-07-21 21:56:10', '', '0', '2022-07-21 21:57:40', '2022-07-21 21:57:40'),
(2, 'Kristoffer', 'Branco', 'kbranco@tweatt.com', '', 'Admin', 'Active', 'Kristoffer Branco', '', '', '', '2009-03-12', '', '3', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(3, 'Brian', 'Wainwright', 'bwainwright@tweatt.com', '', 'Admin', 'Active', 'Brian Wainwright', '', '', '', '2009-03-12', '', '', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(4, 'Julie', 'Johnson', 'jjohnson@tweatt.com', '', 'Admin', 'Active', 'Julie Johnson', '', '', '', '2007-04-19', '', '735', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(5, 'Joseph', 'James', 'jjames@tweatt.com', '', 'Human Resources', 'Active', 'Joseph James', '', '', '', '1999-04-04', '', '1236', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(6, 'Christopher', 'Bulmer', 'cbulmer@tweatt.com', '', 'Admin', 'Active', 'Christopher Bulmer', '', '', '', '2009-03-12', '', '3', '2022-07-21 14:09:39', '2022-07-22 14:33:27'),
(7, 'Test', 'Sales', 'test.sales@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Test Sales', '', '', '', '2009-03-23', '', '43', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(8, 'Lynn', 'Jones', 'ljones@tweatt.com', '', 'Sales Representative', 'Active', 'Lynn Jones', '', '', '', '2009-05-19', '', '797', '2022-07-21 14:09:39', '2022-07-22 12:31:34'),
(9, 'Patricia', 'Pogue', 'ppogue@tweatt.com', '', 'Admin', 'Active', 'Patricia Pogue', '', '', '', '2009-06-22', '', '3', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(10, 'Anthony', 'Petrulsky', 'apetrulsky@tweatt.com', '', 'District Team Leader', 'Active', 'Anthony Petrulsky', '', '', '', '2010-03-17', '', '2134', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(11, 'Jesse', 'White', 'jwhite@tweatt.com', '', 'Admin', 'Active', 'Jesse White', '', '', '', '2017-11-13', '', '2', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(12, 'Kimberly', 'Sakevich', 'ksakevich@tweatt.com', '', 'Admin', 'Active', 'Kimberly Sakevich', '', '', '', '2017-11-01', '', '917', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(13, 'Shyloe', 'Schuler', 'shyloe.schuler@thewirelessexperience.com', '', 'Store Team Leader', 'Active', 'Shyloe Schuler', '', '', '', '2010-10-15', '', '2523', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(14, 'DJ', 'Jirinec', 'user415@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'DJ Jirinec', '', '', '', '2012-03-12', '', '43', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(15, 'Joseph', 'Lepordo', 'jlepordo@tweatt.com', '', 'Human Resources', 'Active', 'Joseph Lepordo', '', '', '', '2012-12-03', '', '3', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(16, 'Jonathan', 'Shanahan', 'JShanahan@tweatt.com', '', 'Admin', 'Active', 'Jonathan Shanahan', '', '', '', '2013-01-24', '', '528', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(17, 'Danielle', 'Beaulieu', 'dbeaulieu@tweatt.com', '', 'Human Resources', 'Active', 'Danielle Beaulieu', '', '', '', '2013-05-01', '', '1236', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(18, 'Matthew', 'Langford', 'mlangford@tweatt.com', '', 'Admin', 'Active', 'Matthew Langford', '', '', '', '2013-05-16', '', '3', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(19, 'Michael', 'Martinez', 'mmartinez@tweatt.com', '', 'Human Resources', 'Active', 'Michael Martinez', '', '', '', '2018-12-11', '', '552', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(20, 'Jared', 'Ferdoucha', 'jared.ferdoucha@thewirelessexperience.com', '', 'Store Team Leader', 'Active', 'Jared Ferdoucha', '', '', '', '2014-02-28', '', '224', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(21, 'Lisa', 'Jankowski', 'ljankowski@tweatt.com', '', 'Admin', 'Active', 'Lisa Jankowski', '', '', '', '2014-03-04', '', '43', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(22, 'Kevin', 'Hunter', 'kevin.hunter@thewirelessexperience.com', '', 'Store Team Leader', 'Active', 'Kevin Hunter', '', '', '', '2014-06-24', '', '2675', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(23, 'Robert', 'Shaver', 'rshaver@tweatt.com', '', 'Admin', 'Active', 'Robert Shaver', '', '', '', '2015-06-01', '', '3', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(24, 'Glenn', 'Schuler', 'glenn.schuler@thewirelessexperience.com', '', 'Store Team Leader', 'Active', 'Glenn Schuler', '', '', '', '2014-09-18', '', '2675', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(25, 'Cole', 'DeCesare', 'cole.decesare@thewirelessexperience.com', '', 'Store Team Leader', 'Active', 'Cole DeCesare', '', '', '', '2014-09-22', '', '2127', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(26, 'RJ', 'Ponzio', 'rponzio@tweatt.com', '', 'Admin', 'Active', 'RJ Ponzio', '', '', '', '2015-02-09', '', '2', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(27, 'Gerald', 'Cross', 'gerald.cross@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Gerald Cross', '', '', '', '2015-09-16', '', '3382', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(28, 'Lauren', 'Schuetz', 'lschuetz@tweatt.com', '', 'Human Resources', 'Active', 'Lauren Schuetz', '', '', '', '2015-10-21', '', '552', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(29, 'James', 'Mcdermott', 'James.Mcdermott@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'James Mcdermott', '', '', '', '2015-11-12', '', '1652', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(30, 'Brittany', 'Porter', 'Brittany.Porter@thewirelessexperience.com', '', 'Store Team Leader', 'Active', 'Brittany Porter', '', '', '', '2016-03-30', '', '2559', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(31, 'Scott', 'Whittet', 'swhittet@tweatt.com', '', 'Sales Representative', 'Active', 'Scott Whittet', '', '', '', '2016-06-06', '', '735', '2022-07-21 14:09:39', '2022-07-22 12:32:19'),
(32, 'Tony', 'Franco', 'Tony.Franco@thewirelessexperience.com', '', 'Store Team Leader', 'Active', 'Tony Franco', '', '', '', '2016-06-17', '', '1895', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(33, 'Angelo', 'DiRodrico', 'workorders@tweatt.com', '', 'Sales Representative', 'Active', 'Angelo DiRodrico', '', '', '', '2016-07-29', '', '162', '2022-07-21 14:09:39', '2022-07-22 12:32:19'),
(34, 'Maurice', 'Gaquer', 'mgaquer@tweatt.com', '', 'Sales Representative', 'Active', 'Maurice Gaquer', '', '', '', '2016-08-03', '', '162', '2022-07-21 14:09:39', '2022-07-22 12:32:19'),
(35, 'Paul', 'Gormezano', 'Paul.Gormezano@thewirelessexperience.com', '', 'Store Team Leader', 'Active', 'Paul Gormezano', '', '', '', '2016-08-03', '', '1797', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(36, 'Mark', 'Andrien', 'mandrien@tweatt.com', '', 'Sales Representative', 'Active', 'Mark Andrien', '', '', '', '2016-08-28', '', '1230', '2022-07-21 14:09:39', '2022-07-22 12:32:19'),
(37, 'Karissa', 'Pagan', 'kpagan@tweatt.com', '', 'Store Team Leader', 'Active', 'Karissa Pagan', '', '', '', '2017-02-10', '', '1631', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(38, 'Ram', 'Thapa', 'Ram.Thapa@thewirelessexperience.com', '', 'Store Team Leader', 'Active', 'Ram Thapa', '', '', '', '2017-04-13', '', '1895', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(39, 'Krystina', 'Mollo', 'kmollo@tweatt.com', '', 'Human Resources', 'Active', 'Krystina Mollo', '', '', '', '2017-05-09', '', '57', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(40, 'Sylena', 'Bettler', 'Sylena.Bettler@thewirelessexperience.com', '', 'Store Team Leader', 'Active', 'Sylena Bettler', '', '', '', '2017-06-12', '', '2523', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(41, 'Andre', 'Smith', 'Andre.Smith@thewirelessexperience.com', '', 'Store Team Leader', 'Active', 'Andre Smith', '', '', '', '2017-07-11', '', '3236', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(42, 'Francisco', 'Velez', 'Francisco.Velez@thewirelessexperience.com', '', 'Store Team Leader', 'Active', 'Francisco Velez', '', '', '', '2017-08-21', '', '2523', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(43, 'Michael', 'LaFace', 'Michael.LaFace@thewirelessexperience.com', '', 'Store Team Leader', 'Active', 'Michael LaFace', '', '', '', '2017-09-19', '', '1797', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(44, 'Jah', 'Williams', 'Jahniquia.Williams@thewirelessexperience.com', '', 'Store Team Leader', 'Active', 'Jah Williams', '', '', '', '2017-09-28', '', '2559', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(45, 'William', 'Garcia', 'William.Garcia@thewirelessexperience.com', '', 'District Team Leader', 'Active', 'William Garcia', '', '', '', '2017-12-18', '', '528', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(46, 'Jennifer', 'Quinn', 'jquinn@tweatt.com', '', 'Admin', 'Active', 'Jennifer Quinn', '', '', '', '2018-01-03', '', '', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(47, 'Jonathan', 'Villanueva', 'Jonathan.Villanueva@thewirelessexperience.com', '', 'Store Team Leader', 'Active', 'Jonathan Villanueva', '', '', '', '2018-01-04', '', '224', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(48, 'Kaylin', 'Iaione', 'Kaylin.Iaione@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Kaylin Iaione', '', '', '', '2018-01-17', '', '3554', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(49, 'Zachary', 'Schreiber', 'Zachary.Schreiber@thewirelessexperience.com', '', 'Store Team Leader', 'Active', 'Zachary Schreiber', '', '', '', '2018-01-24', '', '2675', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(50, 'Eric', 'Burkett', 'Eric.Burkett@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Eric Burkett', '', '', '', '2018-02-15', '', '1071', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(51, 'Carly', 'Dufford', 'cdufford@tweatt.com', '', 'Human Resources', 'Active', 'Carly Dufford', '', '', '', '2018-04-02', '', '552', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(52, 'Kelly', 'Rossino', 'krossino@tweatt.com', '', 'Sales Representative', 'Active', 'Kelly Rossino', '', '', '', '2018-04-03', '', '735', '2022-07-21 14:09:39', '2022-07-22 12:32:19'),
(53, 'Michael', 'Chammas', 'Michael.Chammas@thewirelessexperience.com', '', 'Store Team Leader', 'Active', 'Michael Chammas', '', '', '', '2018-06-18', '', '1895', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(54, 'Anthony', 'Boncoraglio', 'Anthony.Boncoraglio@thewirelessexperience.com', '', 'Store Team Leader', 'Active', 'Anthony Boncoraglio', '', '', '', '2018-07-02', '', '2127', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(55, 'Donald', 'Parr', 'dparr@tweatt.com', '', 'District Team Leader', 'Active', 'Donald Parr', '', '', '', '2018-08-06', '', '528', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(56, 'Trever', 'Lowe', 'trever.lowe@thewirelessexperience.com', '', 'Store Team Leader', 'Active', 'Trever Lowe', '', '', '', '2018-09-24', '', '1631', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(57, 'Jonathan', 'Depaz', 'Jonathan.Depaz@thewirelessexperience.com', '', 'Store Team Leader', 'Active', 'Jonathan Depaz', '', '', '', '2018-09-26', '', '2675', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(58, 'Samuel', 'Huang', 'shuang@tweatt.com', '', 'District Team Leader', 'Active', 'Samuel Huang', '', '', '', '2018-10-22', '', '528', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(59, 'Josue', 'Lopez', 'Josue.Lopez@thewirelessexperience.com', '', 'Store Team Leader', 'Active', 'Josue Lopez', '', '', '', '2018-10-22', '', '1631', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(60, 'Gage', 'Oltmann', 'Gage.Oltmann@thewirelessexperience.com', '', 'Store Team Leader', 'Active', 'Gage Oltmann', '', '', '', '2018-11-05', '', '1797', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(61, 'Sebastien', 'Saintil', 'Sebastien.Saintil@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Sebastien Saintil', '', '', '', '2020-07-27', '', '2018', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(62, 'Carley', 'Swayne', 'Carley.Swayne@thewirelessexperience.com', '', 'Store Team Leader', 'Active', 'Carley Swayne', '', '', '', '2018-12-17', '', '3236', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(63, 'Thomas', 'Hynes', 'Thomas.Hynes@thewirelessexperience.com', '', 'Store Team Leader', 'Active', 'Thomas Hynes', '', '', '', '2019-08-16', '', '1797', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(64, 'Manu', 'Mukadi', 'manu.mukadi@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Manu Mukadi', '', '', '', '2019-01-21', '', '2018', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(65, 'Gary', 'Streeter', 'Gary.Streeter@thewirelessexperience.com', '', 'Store Team Leader', 'Active', 'Gary Streeter', '', '', '', '2019-11-01', '', '1895', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(66, 'Daniel', 'Canavan', 'Daniel.Canavan@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Daniel Canavan', '', '', '', '2019-03-11', '', '1191', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(67, 'Alison', 'Omelio', 'aomelio@tweatt.com', '', 'Sales Representative', 'Active', 'Alison Omelio', '', '', '', '2019-04-22', '', '1638', '2022-07-21 14:09:39', '2022-07-22 12:32:19'),
(68, 'Derrick', 'Preston', 'Derrick.Preston@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Derrick Preston', '', '', '', '2019-04-22', '', '2682', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(69, 'Jasmine', 'Washington', 'Jasmine.Washington@thewirelessexperience.com', '', 'Store Team Leader', 'Active', 'Jasmine Washington', '', '', '', '2019-08-13', '', '2559', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(70, 'Sarah', 'Moore', 'Sarah.Moore@thewirelessexperience.com', '', 'Store Team Leader', 'Active', 'Sarah Moore', '', '', '', '2019-05-20', '', '224', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(71, 'Barry', 'Timony', 'btimony@tweatt.com', '', 'District Team Leader', 'Active', 'Barry Timony', '', '', '', '2020-11-09', '', '528', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(72, 'Sharyta', 'Gray', 'Sharyta.Gray@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Sharyta Gray', '', '', '', '2019-07-15', '', '2070', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(73, 'James', 'Yoder', 'jyoder@tweatt.com', '', 'Admin', 'Active', 'James Yoder', '', '', '', '2019-07-15', '', '2134', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(74, 'Corbyn', 'Whiles', 'Corbyn.Whiles@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Corbyn Whiles', '', '', '', '2019-08-05', '', '2304', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(75, 'Kyle', 'Bair', 'Kyle.Bair@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Kyle Bair', '', '', '', '2019-08-05', '', '2889', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(76, 'Samantha', 'Reimiller', 'Samantha.Reimiller@thewirelessexperience.com', '', 'Store Team Leader', 'Active', 'Samantha Reimiller', '', '', '', '2019-08-19', '', '224', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(77, 'Jason', 'Coppola', 'Jason.Coppola@thewirelessexperience.com', '', 'Store Team Leader', 'Active', 'Jason Coppola', '', '', '', '2020-08-03', '', '2523', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(78, 'Kyle', 'Wilson', 'Kyle.Wilson@thewirelessexperience.com', '', 'Store Team Leader', 'Active', 'Kyle Wilson', '', '', '', '2019-08-26', '', '224', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(79, 'Thomas', 'Aoki', 'TAoki@Tweatt.com', '', 'Admin', 'Active', 'Thomas Aoki', '', '', '', '2019-08-30', '', '3', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(80, 'Scott', 'Crismond', 'Scott.Crismond@thewirelessexperience.com', '', 'Store Team Leader', 'Active', 'Scott Crismond', '', '', '', '2019-09-30', '', '2523', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(81, 'Isaac', 'Medas', 'Isaac.Medas@thewirelessexperience.com', '', 'Store Team Leader', 'Active', 'Isaac Medas', '', '', '', '2019-09-16', '', '2127', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(82, 'Michael', 'Vrotsos', 'Michael.Vrotsos@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Michael Vrotsos', '', '', '', '2019-09-30', '', '3137', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(83, 'Chantal', 'Knapp', 'Chantal.Knapp@thewirelessexperience.com', '', 'Store Team Leader', 'Active', 'Chantal Knapp', '', '', '', '2019-10-07', '', '3236', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(84, 'Joshua', 'Maletta', 'Joshua.Maletta@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Joshua Maletta', '', '', '', '2019-10-07', '', '2440', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(85, 'Joel', 'Walsh', 'Joel.Walsh@thewirelessexperience.com', '', 'Store Team Leader', 'Active', 'Joel Walsh', '', '', '', '2019-10-07', '', '224', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(86, 'Daniel', 'Smith', 'Dan.Smith@thewirelessexperience.com', '', 'Store Team Leader', 'Active', 'Daniel Smith', '', '', '', '2019-11-11', '', '1895', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(87, 'Christopher', 'Perez', 'Christopher.Perez@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Christopher Perez', '', '', '', '2020-02-03', '', '2079', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(88, 'Brendan', 'Williamson', 'Brendan.Williamson@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Brendan Williamson', '', '', '', '2020-02-05', '', '2009', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(89, 'Adam', 'Rolfzen', 'Adam.Rolfzen@thewirelessexperience.com', '', 'Store Team Leader', 'Active', 'Adam Rolfzen', '', '', '', '2020-02-24', '', '2718', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(90, 'Thomas', 'Segnan', 'Thomas.Segnan@thewirelessexperience.com', '', 'Store Team Leader', 'Active', 'Thomas Segnan', '', '', '', '2020-03-09', '', '2127', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(91, 'Jack', 'Turner', 'Jack.Turner@thewirelessexperience.com', '', 'Store Team Leader', 'Active', 'Jack Turner', '', '', '', '2020-06-29', '', '3236', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(92, 'Nicholas', 'Sutton', 'Nicholas.Sutton@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Nicholas Sutton', '', '', '', '2020-06-30', '', '2682', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(93, 'Tristan', 'Greiner', 'Tristan.Greiner@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Tristan Greiner', '', '', '', '2020-07-06', '', '2203', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(94, 'Akeem', 'Adedoyin', 'Akeem.Adedoyin@thewirelessexperience.com', '', 'Store Team Leader', 'Active', 'Akeem Adedoyin', '', '', '', '2020-07-06', '', '1631', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(95, 'Schneider', 'Marceus', 'smarceus@tweatt.com', '', 'District Team Leader', 'Active', 'Schneider Marceus', '', '', '', '2020-07-27', '', '2134', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(96, 'Luiz', 'Vasquez', 'Luiz.Vasquez@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Luiz Vasquez', '', '', '', '2020-07-13', '', '1191', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(97, 'Daniel', 'Crawford', 'Daniel.Crawford@thewirelessexperience.com', '', 'Store Team Leader', 'Active', 'Daniel Crawford', '', '', '', '2020-08-05', '', '2127', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(98, 'Lloyd', 'Murphy', 'Lloyd.Murphy@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Lloyd Murphy', '', '', '', '2021-04-13', '', '1573', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(99, 'Wendell', 'Lewis', 'wendell.lewis@thewirelessexperience.com', '', 'Store Team Leader', 'Active', 'Wendell Lewis', '', '', '', '2020-08-17', '', '2559', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(100, 'Alazia', 'Turner', 'alazia.turner@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Alazia Turner', '', '', '', '2020-08-31', '', '2650', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(101, 'Ariel', 'Ferrufino', 'aferrufino@tweatt.com', '', 'District Team Leader', 'Active', 'Ariel Ferrufino', '', '', '', '2020-08-24', '', '528', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(102, 'Clara', 'Nemeth', 'clara.nemeth@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Clara Nemeth', '', '', '', '2020-08-31', '', '2268', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(103, 'Alexis', 'Garcia', 'Alexis.Garcia@thewirelessexperience.com', '', 'Store Team Leader', 'Active', 'Alexis Garcia', '', '', '', '2020-09-07', '', '2523', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(104, 'Jerrell', 'Blaine', 'Jerrell.Blaine@thewirelessexperience.com', '', 'Store Team Leader', 'Active', 'Jerrell Blaine', '', '', '', '2020-09-21', '', '3236', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(105, 'Mannie', 'Bowling', 'Mannie.Bowling@thewirelessexperience.com', '', 'Store Team Leader', 'Active', 'Mannie Bowling', '', '', '', '2020-09-28', '', '2523', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(106, 'Dalton', 'Callen', 'dalton.callen@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Dalton Callen', '', '', '', '2020-10-19', '', '2188', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(107, 'Courtney', 'Orben', 'Courtney.orben@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Courtney Orben', '', '', '', '2020-10-19', '', '2268', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(108, 'Joshua', 'Hoch', 'Joshua.Hoch@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Joshua Hoch', '', '', '', '2020-10-13', '', '2942', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(109, 'Suzanne', 'Garbarino', 'Suzanne.Garbarino@thewirelessexperience.com', '', 'Store Team Leader', 'Active', 'Suzanne Garbarino', '', '', '', '2020-10-26', '', '2675', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(110, 'Derek', 'McDill', 'Derek.McDill@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Derek McDill', '', '', '', '2020-11-09', '', '2196', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(111, 'Zacary', 'Wagner', 'rwagner@tweatt.com', '', 'District Team Leader', 'Active', 'Zacary Wagner', '', '', '', '2020-11-30', '', '2134', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(112, 'Mikaela', 'Ballard', 'mikaela.ballard@thewirelessexperience.com', '', 'Store Team Leader', 'Active', 'Mikaela Ballard', '', '', '', '2020-11-16', '', '2559', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(113, 'Ely', 'Zeigler', 'Ely.Zeigler@thewirelessexperience.com', '', 'Store Team Leader', 'Active', 'Ely Zeigler', '', '', '', '2020-11-30', '', '3236', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(114, 'Kaitlin', 'Snyder', 'Kaitlin.Snyder@thewirelessexperience.com', '', 'Store Team Leader', 'Active', 'Kaitlin Snyder', '', '', '', '2021-01-04', '', '2523', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(115, 'Tyler', 'Smith', 'tyler.smith@thewirelessexperience.com', '', 'District Team Leader', 'Active', 'Tyler Smith', '', '', '', '2021-01-11', '', '528', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(116, 'Chantler', 'Williamson', 'chantler.williamson@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Chantler Williamson', '', '', '', '2021-01-25', '', '1976', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(117, 'David', 'Yaeger', 'David.Yaeger@thewirelessexperience.com', '', 'Store Team Leader', 'Active', 'David Yaeger', '', '', '', '2021-01-25', '', '2127', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(118, 'Abraham', 'Olivares', 'abraham.olivares@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Abraham Olivares', '', '', '', '2021-02-01', '', '2788', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(119, 'Shaina', 'Diaz', 'Shaina.Diaz@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Shaina Diaz', '', '', '', '2021-02-08', '', '3215', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(120, 'Kenneth', 'Jackson', 'kenneth.jackson@thewirelessexperience.com', '', 'Store Team Leader', 'Active', 'Kenneth Jackson', '', '', '', '2021-03-16', '', '2718', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(121, 'Brian', 'Rachmaciej', 'Brian.Rachmaciej@thewirelessexperience.com', '', 'Store Team Leader', 'Active', 'Brian Rachmaciej', '', '', '', '2021-03-08', '', '1631', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(122, 'Justin', 'Strand', 'justin.strand@thewirelessexperience.com', '', 'Store Team Leader', 'Active', 'Justin Strand', '', '', '', '2021-03-22', '', '1797', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(123, 'Deonte', 'Ballard', 'deonte.ballard@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Deonte Ballard', '', '', '', '2021-03-22', '', '2440', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(124, 'Phillip', 'Jackson', 'phillip.jackson@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Phillip Jackson', '', '', '', '2021-03-29', '', '2554', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(125, 'Allen', 'Del Castillo', 'Allen.DelCastillo@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Allen Del Castillo', '', '', '', '2021-03-22', '', '2572', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(126, 'Jacob', 'Dalimonte', 'Jacob.Dalimonte@thewirelessexperience.com', '', 'Store Team Leader', 'Active', 'Jacob Dalimonte', '', '', '', '2021-03-22', '', '1895', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(127, 'Cameron', 'Schlussler', 'cameron.schlussler@thewirelessexperience.com', '', 'Store Team Leader', 'Active', 'Cameron Schlussler', '', '', '', '2021-04-12', '', '1797', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(128, 'Chris', 'Johnson', 'chris.johnson@thewirelessexperience.com', '', 'Store Team Leader', 'Active', 'Chris Johnson', '', '', '', '2021-04-26', '', '2127', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(129, 'Jason', 'Kapo', 'jason.kapo@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Jason Kapo', '', '', '', '2021-04-26', '', '2009', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(130, 'Rossi', 'Wilkins', 'rossi.wilkins@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Rossi Wilkins', '', '', '', '2021-05-03', '', '1491', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(131, 'Quarri', 'Anderson', 'quarri.anderson@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Quarri Anderson', '', '', '', '2021-05-03', '', '1573', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(132, 'Jack', 'Lubrecht', 'jack.lubrecht@thewirelessexperience.com', '', 'Store Team Leader', 'Active', 'Jack Lubrecht', '', '', '', '2021-05-10', '', '2127', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(133, 'Jacob', 'Gusst', 'jacob.gusst@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Jacob Gusst', '', '', '', '2021-05-10', '', '1961', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(134, 'Karsten', 'Krejcarek', 'kkrejcarek@tweatt.com', '', 'Admin', 'Active', 'Karsten Krejcarek', '', '', '', '2021-05-05', '', '735', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(135, 'RyQuan', 'Donaldson', 'ryquan.donaldson@thewirelessexperience.com', '', 'Store Team Leader', 'Active', 'RyQuan Donaldson', '', '', '', '2021-05-10', '', '3236', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(136, 'Tatiana', 'Tiburcio', 'tatiana.tiburcio@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Tatiana Tiburcio', '', '', '', '2021-05-25', '', '1743', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(137, 'Lionel', 'Dessources', 'lionel.dessources@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Lionel Dessources', '', '', '', '2021-05-24', '', '2785', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(138, 'Jesse', 'Coleman', 'jesse.coleman@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Jesse Coleman', '', '', '', '2021-05-17', '', '3122', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(139, 'April', 'Stapleton', 'april.stapleton@thewirelessexperience.com', '', 'Store Team Leader', 'Active', 'April Stapleton', '', '', '', '2021-05-24', '', '224', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(140, 'Alexander', 'Downey', 'alexander.downey@thewirelessexperience.com', '', 'Store Team Leader', 'Active', 'Alexander Downey', '', '', '', '2021-05-24', '', '2559', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(141, 'Muhammad', 'Shaikh', 'muhammad.shaikh@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Muhammad Shaikh', '', '', '', '2021-06-01', '', '1900', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(142, 'Elijah', 'Casseus', 'elijah.casseus@thewirelessexperience.com', '', 'Store Team Leader', 'Active', 'Elijah Casseus', '', '', '', '2021-06-01', '', '1895', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(143, 'Camryn', 'Hamlett', 'camryn.hamlett@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Camryn Hamlett', '', '', '', '2021-06-07', '', '2070', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(144, 'Andre', 'Woodhouse', 'andre.woodhouse@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Andre Woodhouse', '', '', '', '2021-06-21', '', '2718', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(145, 'Matthew', 'Suarez', 'matthew.suarez@thewirelessexperience.com', '', 'Store Team Leader', 'Active', 'Matthew Suarez', '', '', '', '2021-06-08', '', '2523', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(146, 'Jason', 'Norris', 'jason.norris@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Jason Norris', '', '', '', '2021-06-21', '', '2740', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(147, 'Austin', 'Matusko', 'austin.matusko@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Austin Matusko', '', '', '', '2021-06-14', '', '2918', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(148, 'Brooke', 'Weiss', 'brooke.weiss@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Brooke Weiss', '', '', '', '2021-06-28', '', '783', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(149, 'Johnny', 'Brown', 'johnny.brown@thewirelessexperience.com', '', 'Store Team Leader', 'Active', 'Johnny Brown', '', '', '', '2021-07-05', '', '3236', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(150, 'Hector', 'Rivera', 'hector.rivera@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Hector Rivera', '', '', '', '2021-06-28', '', '3068', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(151, 'Momo', 'Khazir', 'momo.khazir@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Momo Khazir', '', '', '', '2021-06-28', '', '1511', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(152, 'Sely', 'Rosa', 'sely.rosa@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Sely Rosa', '', '', '', '2021-06-29', '', '1432', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(153, 'Angel', 'Hackney', 'ahackney@tweatt.com', '', 'Human Resources', 'Active', 'Angel Hackney', '', '', '', '2021-06-28', '', '57', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(154, 'Jerry', 'Hutchison', 'jerry.hutchison@thewirelessexperience.com', '', 'Store Team Leader', 'Active', 'Jerry Hutchison', '', '', '', '2021-06-28', '', '2127', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(155, 'Justin', 'Jones', 'justin.jones@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Justin Jones', '', '', '', '2021-07-05', '', '2594', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(156, 'Shay', 'Lloyd', 'shay.lloyd@thewirelessexperience.com', '', 'Store Team Leader', 'Active', 'Shay Lloyd', '', '', '', '2021-07-12', '', '2559', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(157, 'Naz', 'Amaya', 'naz.carolina-amaya@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Naz Amaya', '', '', '', '2021-07-07', '', '2018', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(158, 'Katelyn', 'Dawsey', 'kate.dawsey@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Katelyn Dawsey', '', '', '', '2021-07-12', '', '663', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(159, 'Averi', 'Kellon', 'averi.kellon@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Averi Kellon', '', '', '', '2021-07-12', '', '1652', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(160, 'Joshua', 'Orso', 'josh.orso@thewirelessexperience.com', '', 'Store Team Leader', 'Active', 'Joshua Orso', '', '', '', '2021-07-12', '', '224', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(161, 'Nicole', 'De La Cruz', 'nicole.delacruz@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Nicole De La Cruz', '', '', '', '2021-07-19', '', '1432', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(162, 'Ilt', 'Kamil', 'ilt.kamil@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Ilt Kamil', '', '', '', '2021-07-19', '', '2241', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(163, 'Sophia', 'Echevarria', 'sophia.echevarria@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Sophia Echevarria', '', '', '', '2021-08-02', '', '1511', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(164, 'Blake', 'Chisholm', 'blake.chisholm@thewirelessexperience.com', '', 'Store Team Leader', 'Active', 'Blake Chisholm', '', '', '', '2021-07-19', '', '3236', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(165, 'Lexi', 'Loor', 'lexi.loor@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Lexi Loor', '', '', '', '2021-07-19', '', '2268', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(166, 'Michael', 'Wilson-Spivak', 'michael.wilson-spivak@thewirelessexperience.com', '', 'Store Team Leader', 'Active', 'Michael Wilson-Spivak', '', '', '', '2021-07-19', '', '2127', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(167, 'Maycol', 'Gonzalez', 'maycol.gonzalez@thewirelessexperience.com', '', 'Store Team Leader', 'Active', 'Maycol Gonzalez', '', '', '', '2021-08-02', '', '3236', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(168, 'Zachary', 'Ulloa', 'zack.ulloa@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Zachary Ulloa', '', '', '', '2021-08-02', '', '1933', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(169, 'Jenuin', 'Sanchez', 'jen.sanchez@thewirelessexperience.com', '', 'Store Team Leader', 'Active', 'Jenuin Sanchez', '', '', '', '2021-07-26', '', '1797', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(170, 'Nicole', 'Verbejus', 'nicole.verbejus@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Nicole Verbejus', '', '', '', '2021-07-26', '', '2542', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(171, 'Time', 'Clock1', 'tctest1@tweatt.com', '', 'Sales Representative', 'Active', 'Time Clock1', '', '', '', '2021-07-30', '', '3103', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(172, 'Time', 'Clock2', 'tctest2@tweatt.com', '', 'Store Team Leader', 'Active', 'Time Clock2', '', '', '', '2021-07-29', '', '3104', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(173, 'Time', 'Clock3', 'tctest3@tweatt.com', '', 'District Team Leader', 'Active', 'Time Clock3', '', '', '', '2021-07-28', '', '2134', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(174, 'Bryan', 'Aguilar-Lopez', 'bryan.aguilar-lopez@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Bryan Aguilar-Lopez', '', '', '', '2021-08-09', '', '3087', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(175, 'Zach', 'Shields', 'zach.shields@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Zach Shields', '', '', '', '2021-08-09', '', '2677', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(176, 'Omar', 'Rupiza-Ramos', 'omar.rupiza-ramos@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Omar Rupiza-Ramos', '', '', '', '2021-08-09', '', '274', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(177, 'Vlad', 'David', 'vlad.david@thewirelessexperience.com', '', 'Store Team Leader', 'Active', 'Vlad David', '', '', '', '2021-08-09', '', '2127', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(178, 'Taylor', 'Jones', 'taylor.jones@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Taylor Jones', '', '', '', '2021-08-09', '', '3034', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(179, 'Ava', 'Dalfonso', 'ava.dalfonso@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Ava Dalfonso', '', '', '', '2021-08-16', '', '2470', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(180, 'Sofia', 'Delacruz', 'sofia.delacruz@thewirelessexperience.com', '', 'Store Team Leader', 'Active', 'Sofia Delacruz', '', '', '', '2021-08-16', '', '1631', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(181, 'Natasha', 'Thorpe', 'natasha.thorpe@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Natasha Thorpe', '', '', '', '2021-08-30', '', '2304', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(182, 'Brian', 'Bonardi', 'brian.bonardi@thewirelessexperience.com', '', 'Store Team Leader', 'Active', 'Brian Bonardi', '', '', '', '2021-08-30', '', '2127', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(183, 'Danielle', 'Sheppard', 'danielle.sheppard@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Danielle Sheppard', '', '', '', '2021-08-30', '', '2718', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(184, 'Jake', 'Calderon', 'jake.calderon@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Jake Calderon', '', '', '', '2021-08-30', '', '2203', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(185, 'Derkin', 'Shearer', 'derkin.shearer@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Derkin Shearer', '', '', '', '2021-09-09', '', '2682', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(186, 'Gabby', 'Shively', 'gabby.shively@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Gabby Shively', '', '', '', '2021-09-06', '', '1900', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(187, 'Britney', 'Husfelt', 'britney.husfelt@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Britney Husfelt', '', '', '', '2021-08-30', '', '2948', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(188, 'Matthew', 'Cathey', 'matt.cathey@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Matthew Cathey', '', '', '', '2021-08-30', '', '2740', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(189, 'Zachary', 'Stlaurent', 'zach.stlaurent@thewirelessexperience.com', '', 'Store Team Leader', 'Active', 'Zachary Stlaurent', '', '', '', '2021-08-30', '', '1631', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(190, 'Jason', 'Riston', 'jason.riston@thewirelessexperience.com', '', 'Store Team Leader', 'Active', 'Jason Riston', '', '', '', '2021-09-13', '', '2559', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(191, 'Karl', 'Ferguson', 'karl.ferguson@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Karl Ferguson', '', '', '', '2021-09-13', '', '3554', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(192, 'Kcee', 'Dolom', 'kcee.dolom@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Kcee Dolom', '', '', '', '2021-09-07', '', '2440', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(193, 'Ryan', 'Lopez', 'ryan.lopez@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Ryan Lopez', '', '', '', '2021-09-09', '', '1933', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(194, 'Domingos', 'Gomes', 'domingos.gomes@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Domingos Gomes', '', '', '', '2021-09-13', '', '2018', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(195, 'Jazmyne', 'Wilson', 'jazmyne.wilson@thewirelessexperience.com', '', 'Store Team Leader', 'Active', 'Jazmyne Wilson', '', '', '', '2021-09-13', '', '2675', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(196, 'Noah', 'White', 'noah.white@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Noah White', '', '', '', '2021-09-13', '', '2907', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(197, 'Anthony', 'Reyes', 'anthony.reyes@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Anthony Reyes', '', '', '', '2021-09-27', '', '3271', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(198, 'Austin', 'Blanchette', 'austin.blanchette@thewirelessexperience.com', '', 'Store Team Leader', 'Active', 'Austin Blanchette', '', '', '', '2021-09-22', '', '1895', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(199, 'Summer', 'Lemeur', 'summer.lemeur@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Summer Lemeur', '', '', '', '2021-10-04', '', '3044', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(200, 'Inventory', 'Staff Support', 'inventory.StaffSupport@tweatt.com', '', 'Human Resources', 'Active', 'Inventory Staff Support', '', '', '', '2021-09-01', '', '', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(201, 'Cricket', 'IT', 'cricketit@tweatt.com', '', 'Admin', 'Active', 'Cricket IT', '', '', '', '2021-09-01', '', '', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(202, 'Cricket', 'HR', 'crickethr@tweatt.com', '', 'Human Resources', 'Active', 'Cricket HR', '', '', '', '2021-09-01', '', '', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(203, 'Sylvia', 'Powell', 'sylvia.powell@thewirelessexperience.com', '', 'Store Team Leader', 'Active', 'Sylvia Powell', '', '', '', '2021-09-20', '', '1895', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(204, 'Danny', 'Aguirre', 'danny.aguirre@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Danny Aguirre', '', '', '', '2021-09-27', '', '3122', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(205, 'Brian', 'Sousa', 'brian.sousa@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Brian Sousa', '', '', '', '2021-09-27', '', '1397', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(206, 'Isaiah', 'Nelson', 'isaiah.nelson@thewirelessexperience.com', '', 'Store Team Leader', 'Active', 'Isaiah Nelson', '', '', '', '2021-09-27', '', '1797', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(207, 'Ian', 'Vazquez', 'ian.vazquez@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Ian Vazquez', '', '', '', '2021-09-27', '', '3362', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(208, 'Rian', 'Watkins', 'rian.watkins@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Rian Watkins', '', '', '', '2021-10-04', '', '2907', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(209, 'Julio', 'Arroyo', 'jarroyo@tweatt.com', '', 'District Team Leader', 'Active', 'Julio Arroyo', '', '', '', '2021-10-04', '', '43', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(210, 'Danny', 'Guillermo', 'danny.guillermo@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Danny Guillermo', '', '', '', '2021-10-18', '', '2572', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(211, 'Brendon', 'Golden', 'brendon.golden@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Brendon Golden', '', '', '', '2021-10-18', '', '2677', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(212, 'Noah', 'Long', 'noah.long@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Noah Long', '', '', '', '2021-10-11', '', '274', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(213, 'Matthew', 'Flebotte', 'matthew.flebotte@thewirelessexperience.com', '', 'Store Team Leader', 'Active', 'Matthew Flebotte', '', '', '', '2021-10-11', '', '1631', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(214, 'Deandre', 'Chapple', 'deandre.chapple@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Deandre Chapple', '', '', '', '2021-10-18', '', '3169', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(215, 'Kevin', 'Shulca', 'kevin.shulca@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Kevin Shulca', '', '', '', '2021-10-25', '', '1933', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(216, 'Dawson', 'Maurer', 'Dawson.Maurer@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Dawson Maurer', '', '', '', '2021-10-25', '', '1639', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(217, 'Khalief', 'Williams', 'Khalief.Williams@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Khalief Williams', '', '', '', '2021-10-18', '', '2906', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(218, 'Jason', 'Locke', 'jason.locke@thewirelessexperience.com', '', 'Store Team Leader', 'Active', 'Jason Locke', '', '', '', '2021-10-25', '', '2675', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(219, 'Ismail', 'Chehouri', 'ismail.chehouri@thewirelessexperience.com', '', 'Store Team Leader', 'Active', 'Ismail Chehouri', '', '', '', '2021-10-25', '', '2523', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(220, 'Ezekiel', 'Azzaretti', 'ezekiel.azzaretti@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Ezekiel Azzaretti', '', '', '', '2021-10-25', '', '2883', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(221, 'Tatyana', 'Homacki', 'tatyana.homacki@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Tatyana Homacki', '', '', '', '2021-11-08', '', '1875', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(222, 'Justin', 'Gonzalez', 'justin.gonzalez@thewirelessexperience.com', '', 'Store Team Leader', 'Active', 'Justin Gonzalez', '', '', '', '2021-11-01', '', '1797', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(223, 'Valerie', 'Guava', 'valerie.guava@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Valerie Guava', '', '', '', '2021-11-02', '', '1432', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(224, 'Lebene', 'Attipoe', 'lebene.attipoe@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Lebene Attipoe', '', '', '', '2021-11-01', '', '1237', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(225, 'Curtis', 'Kamara', 'curtis.kamara@thewirelessexperience.com', '', 'Store Team Leader', 'Active', 'Curtis Kamara', '', '', '', '2021-11-01', '', '2718', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(226, 'Diego', 'Cabrera', 'Diego.Cabrera@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Diego Cabrera', '', '', '', '2021-06-04', '', '3382', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(227, 'Mario', 'Matuawana', 'Mario.Matuawana@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Mario Matuawana', '', '', '', '2020-02-13', '', '2785', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(228, 'Kenzley', 'Duvilaire', 'Kenzley.Duvilaire@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Kenzley Duvilaire', '', '', '', '2019-10-22', '', '3200', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(229, 'Joel', 'Dos Santos', 'joel.dossantos@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Joel Dos Santos', '', '', '', '2020-02-06', '', '2785', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(230, 'Aliz', 'Morales', 'aliz.morales@thewirelessexperience.com', '', 'Store Team Leader', 'Active', 'Aliz Morales', '', '', '', '2021-11-01', '', '1797', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(231, 'Wesley', 'Greenwood', 'wesley.greenwood@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Wesley Greenwood', '', '', '', '2021-03-23', '', '3260', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(232, 'Frank', 'Malave', 'frank.malave@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Frank Malave', '', '', '', '2021-11-08', '', '3273', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(233, 'Will', 'Woodson', 'will.woodson@thewirelessexperience.com', '', 'Store Team Leader', 'Active', 'Will Woodson', '', '', '', '2021-11-08', '', '2675', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(234, 'Michael', 'Kurdonik', 'michael.kurdonik@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Michael Kurdonik', '', '', '', '2021-11-08', '', '2862', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(235, 'Jared', 'Rogers', 'jared.rogers@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Jared Rogers', '', '', '', '2021-11-15', '', '3228', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(236, 'Zoey', 'Monte', 'zoey.monte@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Zoey Monte', '', '', '', '2021-11-15', '', '785', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(237, 'Zain', 'Dawood', 'zain.dawood@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Zain Dawood', '', '', '', '2021-11-15', '', '1961', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(238, 'McKenzie', 'Channels', 'McKenzie.Channels@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'McKenzie Channels', '', '', '', '2021-11-16', '', '2718', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(239, 'Joshua', 'Rodriguez', 'joshua.rodriguez@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Joshua Rodriguez', '', '', '', '2021-11-29', '', '1071', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(240, 'Theresa', 'Muniz', 'Theresa.Muniz@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Theresa Muniz', '', '', '', '2021-11-29', '', '2188', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(241, 'Brandon', 'Parker', 'brandon.parker@thewirelessexperience.com', '', 'Store Team Leader', 'Active', 'Brandon Parker', '', '', '', '2022-01-03', '', '3236', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(242, 'Layne', 'Longo', 'layne.longo@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Layne Longo', '', '', '', '2021-12-06', '', '2242', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(243, 'Darius', 'Flores', 'Darius.Flores@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Darius Flores', '', '', '', '2022-01-04', '', '3164', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(244, 'Thomas', 'DeLucca', 'Thomas.DeLucca@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Thomas DeLucca', '', '', '', '2022-01-04', '', '3146', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(245, 'Latrell', 'Townsend', 'Latrell.Townsend@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Latrell Townsend', '', '', '', '2022-01-04', '', '3313', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(246, 'Natalie', 'Schwartz', 'Natalie.Schwartz@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Natalie Schwartz', '', '', '', '2022-01-10', '', '3074', '2022-07-21 14:09:39', '2022-07-22 12:29:58');
INSERT INTO `employees` (`id`, `firstname`, `lastname`, `email`, `password`, `designation`, `status`, `fullname`, `home_number`, `cellular_number`, `work_number`, `start_date`, `terminate_date`, `supervisor`, `created`, `updated`) VALUES
(247, 'Shamauri', 'Rainey', 'Shamauri.Rainey@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Shamauri Rainey', '', '', '', '2022-01-05', '', '1191', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(248, 'Magnus', 'Mammy', 'magnus.mammy@thewirelessexperience.com', '', 'Store Team Leader', 'Active', 'Magnus Mammy', '', '', '', '2022-01-05', '', '1631', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(249, 'Giselle', 'Corniel', 'Giselle.Corniel@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Giselle Corniel', '', '', '', '2022-01-04', '', '3068', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(250, 'Joseph', 'Awonusi', 'Joseph.Awonusi@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Joseph Awonusi', '', '', '', '2022-01-04', '', '1573', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(251, 'Brianna', 'Skinner', 'brianna.skinner@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Brianna Skinner', '', '', '', '2022-01-10', '', '785', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(252, 'Mae', 'Dumonet', 'mae.dumont@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Mae Dumonet', '', '', '', '2022-01-24', '', '2604', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(253, 'Spirit', 'Jones', 'Spirit.Jones@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Spirit Jones', '', '', '', '2022-01-10', '', '2984', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(254, 'IT', 'Staff Support', 'It.staffsupport@tweatt.com', '', 'Human Resources', 'Active', 'IT Staff Support', '', '', '', '2021-09-01', '', '', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(255, 'HR', 'Staff Support', 'Hr.staffsupport@tweatt.com', '', 'Human Resources', 'Active', 'HR Staff Support', '', '', '', '2021-09-01', '', '', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(256, 'AP', 'Staff Support', 'Ap.staffsupport@tweatt.com', '', 'Human Resources', 'Active', 'AP Staff Support', '', '', '', '2021-09-01', '', '', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(257, 'Reporting', 'Staff Support', 'Reporting.staffsupport@tweatt.com', '', 'Human Resources', 'Active', 'Reporting Staff Support', '', '', '', '2021-09-01', '', '', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(258, 'Lars', 'Rieck', 'Lars.Rieck@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Lars Rieck', '', '', '', '2022-01-17', '', '1900', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(259, 'Test', 'Test', 'Test@tweatt.com', '', 'Store Team Leader', 'Active', 'Test Test', '', '', '', '2022-01-16', '', '', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(260, 'Andrew', 'Arocho', 'Andrew.Arocho@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Andrew Arocho', '', '', '', '2022-01-24', '', '2594', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(261, 'Anthony', 'Boyd', 'Anthony.Boyd@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Anthony Boyd', '', '', '', '2022-01-24', '', '2242', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(262, 'Michaela', 'Bitting', 'Michaela.Bitting@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Michaela Bitting', '', '', '', '2022-01-31', '', '2713', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(263, 'Matthew', 'Ludovico', 'Matthew.Ludovico@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Matthew Ludovico', '', '', '', '2022-01-31', '', '3194', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(264, 'Rebeca', 'Henriquez', 'Rebeca.Henriquez@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Rebeca Henriquez', '', '', '', '2022-01-31', '', '3034', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(265, 'Connor', 'Mahon', 'Connor.Mahon@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Connor Mahon', '', '', '', '2022-01-31', '', '1848', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(266, 'Angel', 'Diaz', 'angel.diaz@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Angel Diaz', '', '', '', '2022-02-07', '', '3304', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(267, 'Stephen', 'Macneal', 'Stephen.Macneal@thewirelessexperience.com', '', 'Store Team Leader', 'Active', 'Stephen Macneal', '', '', '', '2022-02-14', '', '2718', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(268, 'Julie', 'Soto', 'Julie.Soto@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Julie Soto', '', '', '', '2022-02-16', '', '1743', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(269, 'Peter', 'Abate', 'Peter.Abate@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Peter Abate', '', '', '', '2022-02-07', '', '3228', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(270, 'Kessie', 'Luscher', 'Kessie.Luscher@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Kessie Luscher', '', '', '', '2022-02-07', '', '3079', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(271, 'Brenin', 'Hernandez', 'brenin.hernandez@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Brenin Hernandez', '', '', '', '2022-02-07', '', '1397', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(272, 'Moi', 'Robinson', 'Moi.Robinson@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Moi Robinson', '', '', '', '2022-02-07', '', '1875', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(273, 'Milan', 'Patel', 'Milan.Patel@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Milan Patel', '', '', '', '2022-02-07', '', '3228', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(274, 'Ruby', 'Young', 'Ruby.Young@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Ruby Young', '', '', '', '2022-02-14', '', '274', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(275, 'Snook', 'Washington', 'Snook.Washington@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Snook Washington', '', '', '', '2022-02-14', '', '1573', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(276, 'Kenyatta', 'Peaker', 'Kenyatta.Peaker@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Kenyatta Peaker', '', '', '', '2022-02-21', '', '2241', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(277, 'Fabian', 'Chavarria', 'Fabian.Chavarria@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Fabian Chavarria', '', '', '', '2022-02-14', '', '2542', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(278, 'Stephen', 'Tabaczynski', 'Stephen.Tabaczynski@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Stephen Tabaczynski', '', '', '', '2022-02-14', '', '3000', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(279, 'Austin', 'Sheridan', 'Austin.Sheridan@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Austin Sheridan', '', '', '', '2022-02-28', '', '2883', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(280, 'Dahiana', 'Delacruz', 'dahiana.delacruz@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Dahiana Delacruz', '', '', '', '2022-02-21', '', '1432', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(281, 'Kaitlyn', 'Wilson', 'Kaitlyn.Wilson@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Kaitlyn Wilson', '', '', '', '2022-03-07', '', '1491', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(282, 'Kristen', 'Broderick', 'kbroderick@tweatt.com', '', 'Sales Representative', 'Active', 'Kristen Broderick', '', '', '', '2022-02-21', '', '1638', '2022-07-21 14:09:39', '2022-07-22 12:32:19'),
(283, 'Dan', 'Hook', 'Dan.Hook@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Dan Hook', '', '', '', '2022-02-28', '', '2862', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(284, 'Maddie', 'Lauria', 'maddie.Lauria@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Maddie Lauria', '', '', '', '2022-03-14', '', '2740', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(285, 'Kyle', 'Beck', 'Kyle.Beck@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Kyle Beck', '', '', '', '2022-03-14', '', '783', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(286, 'Tara', 'Will', 'Tara.Will@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Tara Will', '', '', '', '2022-03-14', '', '3362', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(287, 'Travis', 'Smith', 'Travis.Smith@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Travis Smith', '', '', '', '2022-03-07', '', '1639', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(288, 'Benny', 'Berrafato', 'Benny.Berrafato@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Benny Berrafato', '', '', '', '2022-03-07', '', '663', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(289, 'Gizel', 'Yeretzian', 'gizel.yeretzian@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Gizel Yeretzian', '', '', '', '2022-03-21', '', '2604', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(290, 'Drew', 'Phillips', 'Drew.Phillips@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Drew Phillips', '', '', '', '2022-03-07', '', '3146', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(291, 'Kwame', 'Goulbourne', 'Kwame.Goulbourne@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Kwame Goulbourne', '', '', '', '2022-03-09', '', '1540', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(292, 'Joe', 'Esposito', 'Joe.Esposito@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Joe Esposito', '', '', '', '2022-03-14', '', '3074', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(293, 'Renz', 'Dumandan', 'Renz.Dumandan@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Renz Dumandan', '', '', '', '2022-03-14', '', '1976', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(294, 'Myles', 'Cole', 'Myles.Cole@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Myles Cole', '', '', '', '2022-03-16', '', '2009', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(295, 'JORDAN', 'GOLDSTEIN', 'Jordan.Goldstein@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'JORDAN GOLDSTEIN', '', '', '', '2022-03-14', '', '3044', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(296, 'Chris', 'Favilla', 'Chris.Favilla@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Chris Favilla', '', '', '', '2022-03-14', '', '1760', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(297, 'Elder', 'Ordonez', 'Elder.ordonez@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Elder Ordonez', '', '', '', '2022-03-14', '', '3169', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(298, 'Jake', 'Ashby', 'jake.Ashby@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Jake Ashby', '', '', '', '2022-03-21', '', '1573', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(299, 'Corii', 'Hamlett', 'Corii.Hamlett@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Corii Hamlett', '', '', '', '2022-03-16', '', '1573', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(300, 'Edwin', 'Torres', 'Edwin.Torres@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Edwin Torres', '', '', '', '2022-04-04', '', '2510', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(301, 'Nile', 'Howard', 'Nile.Howard@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Nile Howard', '', '', '', '2022-03-21', '', '3087', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(302, 'Josh', 'Alpha', 'Josh.Alpha@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Josh Alpha', '', '', '', '2022-03-28', '', '3273', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(303, 'Joe', 'Camilo', 'Joe.Camilo@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Joe Camilo', '', '', '', '2022-03-21', '', '3087', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(304, 'Asad', 'Mahmood', 'Asad.Mahmood@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Asad Mahmood', '', '', '', '2022-04-10', '', '1237', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(305, 'Patrick', 'Gagai', 'Patrick.Gagai@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Patrick Gagai', '', '', '', '2022-03-27', '', '3000', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(306, 'Brendan', 'Young', 'Brendan.Young@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Brendan Young', '', '', '', '2022-03-27', '', '2984', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(307, 'Nebia', 'Chism', 'Nebia.CHISM@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Nebia Chism', '', '', '', '2022-03-27', '', '2650', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(308, 'Carson', 'Ellis', 'Carson.Ellis@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Carson Ellis', '', '', '', '2022-03-27', '', '2470', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(309, 'Cheyenne', 'Laine', 'Cheyenne.Laine@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Cheyenne Laine', '', '', '', '2022-03-27', '', '3287', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(310, 'Maryam', 'Bint-Shafeeq', 'Maryam.Bint-Shafeeq@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Maryam Bint-Shafeeq', '', '', '', '2022-03-28', '', '1071', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(311, 'Bruce', 'Botelho', 'Bruce.Botelho@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Bruce Botelho', '', '', '', '2022-03-28', '', '3164', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(312, 'Shane', 'Ryder', 'Shane.Ryder@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Shane Ryder', '', '', '', '2022-03-30', '', '2196', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(313, 'Molly', 'Amaral', 'Molly.Amaral@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Molly Amaral', '', '', '', '2022-03-28', '', '3137', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(314, 'Willie', 'Hines', 'Willie.Hines@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Willie Hines', '', '', '', '2022-04-04', '', '3445', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(315, 'Carissa', 'Davis', 'carissa.Davis@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Carissa Davis', '', '', '', '2022-04-04', '', '2242', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(316, 'Benjamin', 'Ciesla', 'Benjamin.Ciesla@thewirelessexperience.com', '', 'Store Team Leader', 'Active', 'Benjamin Ciesla', '', '', '', '2022-04-04', '', '1797', '2022-07-21 14:09:39', '2022-07-21 14:09:39'),
(317, 'Brooke', 'Minotti', 'Brooke.Minotti@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Brooke Minotti', '', '', '', '2022-04-04', '', '3000', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(318, 'Maria', 'Gomez', 'Maria.Gomez@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Maria Gomez', '', '', '', '2022-04-04', '', '3146', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(319, 'Chris', 'Maloney', 'Chris.Maloney@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Chris Maloney', '', '', '', '2022-04-04', '', '3200', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(320, 'Allison', 'Diaz', 'Allison.Diaz@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Allison Diaz', '', '', '', '2022-04-18', '', '1573', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(321, 'Bri', 'Cortez', 'Bri.Cortez@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Bri Cortez', '', '', '', '2022-04-11', '', '1639', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(322, 'Norman', 'Seeley', 'Norman.Seeley@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Norman Seeley', '', '', '', '2022-04-11', '', '2816', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(323, 'Bo', 'Tran', 'Bo.Tran@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Bo Tran', '', '', '', '2022-04-11', '', '2572', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(324, 'Nicolle', 'Ortiz', 'nicolle.gonzalez@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Nicolle Ortiz', '', '', '', '2022-04-25', '', '2889', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(325, 'Kevin', 'Pierre', 'Kevin.Pierre@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Kevin Pierre', '', '', '', '2022-04-11', '', '3283', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(326, 'Adam', 'Wachter', 'Adam.wachter@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Adam Wachter', '', '', '', '2022-05-02', '', '2497', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(327, 'Eric', 'Weitzel', 'Eric.Weitzel@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Eric Weitzel', '', '', '', '2022-04-25', '', '2203', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(328, 'Andy', 'Donkor', 'Andy.Donkor@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Andy Donkor', '', '', '', '2022-04-25', '', '2554', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(329, 'Alex', 'Atherley', 'Alex.Atherley@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Alex Atherley', '', '', '', '2022-04-25', '', '3215', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(330, 'Cody', 'Coers', 'Cody.Coers@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Cody Coers', '', '', '', '2022-04-18', '', '3260', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(331, 'Jude', 'Weekes-Young', 'Jude.Weekes-Young@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Jude Weekes-Young', '', '', '', '2022-04-18', '', '3228', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(332, 'Henrique', 'Laigner', 'Henrique.Laigner@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Henrique Laigner', '', '', '', '2022-04-25', '', '2918', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(333, 'Stephanie', 'Drovich', 'Stephanie.Drovich@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Stephanie Drovich', '', '', '', '2022-04-18', '', '3174', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(334, 'Divine', 'Nwani', 'Divine.Nwani@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Divine Nwani', '', '', '', '2022-05-02', '', '3445', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(335, 'Brett', 'Hunt-Johnson', 'Brett.Hunt-Johnson@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Brett Hunt-Johnson', '', '', '', '2022-04-20', '', '2440', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(336, 'Emily', 'Erickson', 'Emily.Erickson@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Emily Erickson', '', '', '', '2022-04-25', '', '3079', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(337, 'Kayla', 'Ramos', 'Kayla.Ramos@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Kayla Ramos', '', '', '', '2022-04-24', '', '2942', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(338, 'Christian', 'Cook', 'Christian.Cook@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Christian Cook', '', '', '', '2022-04-24', '', '1540', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(339, 'Dan', 'Imbriaco', 'Dan.Imbriaco@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Dan Imbriaco', '', '', '', '2022-05-02', '', '3174', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(340, 'Jorge', 'Graubard', 'Jorge.Graubard@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Jorge Graubard', '', '', '', '2022-04-24', '', '2883', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(341, 'Garesha', 'Deabreu', 'Garesha.Deabreu@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Garesha Deabreu', '', '', '', '2022-05-03', '', '2906', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(342, 'Ty-Anthony', 'Conner', 'Ty-Anthony.Conner@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Ty-Anthony Conner', '', '', '', '2022-05-09', '', '2470', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(343, 'Eli', 'Valle', 'eli.delvalle@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Eli Valle', '', '', '', '2022-05-02', '', '1573', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(344, 'Khadee', 'Barrett', 'Khadee.Barrett@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Khadee Barrett', '', '', '', '2022-05-02', '', '1848', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(345, 'Larry', 'Knight', 'Larry.Knight@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Larry Knight', '', '', '', '2022-05-02', '', '2839', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(346, 'John', 'Adams', 'John.Adams@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'John Adams', '', '', '', '2022-05-02', '', '2862', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(347, 'Stephanie', 'Amaya', 'Stephanie.Amaya@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Stephanie Amaya', '', '', '', '2022-05-09', '', '2839', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(348, 'Angelo', 'Mills', 'Angelo.Mills@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Angelo Mills', '', '', '', '2022-05-02', '', '3287', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(349, 'Alex', 'Pierre', 'Alex.Pierre@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Alex Pierre', '', '', '', '2022-05-02', '', '1639', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(350, 'Sahil', 'Sahjani', 'Sahil.Sahjani@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Sahil Sahjani', '', '', '', '2022-05-02', '', '3304', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(351, 'Tyler', 'Richards', 'Tyler.Richards@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Tyler Richards', '', '', '', '2022-05-09', '', '2906', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(352, 'Nick', 'Vovchik', 'nick.vovchik@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Nick Vovchik', '', '', '', '2022-05-02', '', '1564', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(353, 'Ahmed', 'Mendy', 'Ahmed.Mendy@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Ahmed Mendy', '', '', '', '2022-05-16', '', '2778', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(354, 'Jasmine', 'Wilson', 'jwilson@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Jasmine Wilson', '', '', '', '2022-05-05', '', '2778', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(355, 'Daniela', 'Pelaez', 'Daniela.Pelaez@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Daniela Pelaez', '', '', '', '2022-05-09', '', '2839', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(356, 'Jessica', 'Robinson', 'Jessica.ROBINSON@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Jessica Robinson', '', '', '', '2022-05-09', '', '1237', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(357, 'Marlou', 'Villaluna', 'Marlou.Villaluna@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Marlou Villaluna', '', '', '', '2022-05-24', '', '3000', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(358, 'Rony', 'Asencio', 'Rony.Asencio@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Rony Asencio', '', '', '', '2022-05-09', '', '3215', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(359, 'Madi', 'Peters', 'Madi.Peters@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Madi Peters', '', '', '', '2022-05-16', '', '3445', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(360, 'Jessica', 'Spence', 'Jessica.Spence@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Jessica Spence', '', '', '', '2022-05-16', '', '2816', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(361, 'Angel', 'Paulino', 'Angel.Paulino@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Angel Paulino', '', '', '', '2022-05-16', '', '2713', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(362, 'Edwin', 'Velasco', 'edwin.velasco@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Edwin Velasco', '', '', '', '2022-05-16', '', '3271', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(363, 'Lena', 'Rondon', 'Lena.Rondon@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Lena Rondon', '', '', '', '2022-05-16', '', '1564', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(364, 'Kamel', 'Wilson', 'Kamel.Wilson@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Kamel Wilson', '', '', '', '2022-05-17', '', '3169', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(365, 'Kyle', 'Fischbach', 'Kyle.Fischbach@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Kyle Fischbach', '', '', '', '2022-05-23', '', '2255', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(366, 'Tori', 'Sheets', 'Tori.Sheets@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Tori Sheets', '', '', '', '2022-05-23', '', '1071', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(367, 'Herol', 'Valcin', 'Herol.Valcin@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Herol Valcin', '', '', '', '2022-06-08', '', '2788', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(368, 'Jason', 'Johnson', 'Jason.Johnson@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Jason Johnson', '', '', '', '2022-05-23', '', '2255', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(369, 'Angele', 'Camacho', 'Angele.Camacho@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Angele Camacho', '', '', '', '2022-05-25', '', '1540', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(370, 'Kay', 'Mezilus', 'Kay.Mezilus@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Kay Mezilus', '', '', '', '2022-06-06', '', '3194', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(371, 'Brian', 'Hernandez', 'Brian.Hernandez@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Brian Hernandez', '', '', '', '2022-05-30', '', '2079', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(372, 'Marvine', 'Cesar', 'Marvine.Cesar@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Marvine Cesar', '', '', '', '2022-05-25', '', '2785', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(373, 'Nicholas', 'Nath', 'Nicholas.Nath@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Nicholas Nath', '', '', '', '2022-06-01', '', '3283', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(374, 'Julia', 'Lozzi', 'Julia.Lozzi@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Julia Lozzi', '', '', '', '2022-06-01', '', '2816', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(375, 'Liam', 'McGinley', 'Liam.McGinley@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Liam McGinley', '', '', '', '2022-06-06', '', '2839', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(376, 'Isabel', 'Rosa', 'isabel.rosa@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Isabel Rosa', '', '', '', '2022-06-01', '', '2188', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(377, 'Zachary', 'Zentz', 'zachary.zentz@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Zachary Zentz', '', '', '', '2022-06-06', '', '3146', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(378, 'Kai', 'Young', 'kai.young@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Kai Young', '', '', '', '2022-06-02', '', '2839', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(379, 'Kiara', 'Wheeler', 'Kiara.Wheeler@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Kiara Wheeler', '', '', '', '2022-06-06', '', '2778', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(380, 'Dane', 'Bodamer', 'dane.bodamer@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Dane Bodamer', '', '', '', '2022-06-20', '', '2542', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(381, 'Airrionna', 'Roberts', 'Airrionna.Roberts@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Airrionna Roberts', '', '', '', '2022-06-13', '', '3287', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(382, 'Leah', 'Robertson', 'Leah.Robertson@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Leah Robertson', '', '', '', '2022-06-06', '', '3068', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(383, 'Garrett', 'Murphy', 'Garrett.Murphy@thewirelessexperience.com', '', 'Sales Representative', 'Active', 'Garrett Murphy', '', '', '', '2022-06-13', '', '2788', '2022-07-21 14:09:39', '2022-07-22 12:29:58'),
(384, 'Samira', 'Egal', '', '', 'District Team Leader', 'Deactive', 'Samira J Egal', '202', '45', '11', '2022-07-25', '', '383', '2022-07-22 14:39:32', '2022-07-22 14:55:39');

-- --------------------------------------------------------

--
-- Table structure for table `employee_mata`
--

CREATE TABLE `employee_mata` (
  `id` int(11) NOT NULL,
  `employee` int(11) NOT NULL,
  `meta_key` varchar(100) NOT NULL,
  `meta_value` longtext NOT NULL,
  `created` varchar(100) NOT NULL,
  `updated` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `content` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `info` text NOT NULL,
  `created` varchar(100) NOT NULL,
  `updated` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `name`, `content`, `info`, `created`, `updated`) VALUES
(3, 'admin-sidebar', '[\r\n	{\r\n		\"icon\":\"<i class=\'fa-solid fa-house\'></i>\",\r\n		\"title\":\"Dashboard\",\r\n		\"link\":\"/\"\r\n	},\r\n	{\r\n		\"icon\":\"<i class=\'fa-solid fa-store\'></i>\",\r\n		\"title\":\"stores\",\r\n		\"link\":\"/stores\"\r\n	},\r\n	{\r\n		\"icon\":\"<i class=\'fa-solid fa-suitcase\'></i>\",\r\n		\"title\":\"HR Suit\",\r\n		\"link\":\"#\",\r\n		\"sub\":[\r\n			{\r\n				\"title\":\"Employees\",\r\n				\"link\":\"/employees\"\r\n			},\r\n			{\r\n				\"title\":\"PLE Compliance\",\r\n				\"link\":\"/compliance\"\r\n			},\r\n			{\r\n				\"title\":\"Business Card Generator\",\r\n				\"link\":\"/business-card\"\r\n			},\r\n			{\r\n				\"title\":\"News & Announcements\",\r\n				\"link\":\"/news\"\r\n			}\r\n\r\n		]\r\n	},\r\n	{\r\n		\"icon\":\"<i class=\'fa-solid fa-clipboard-list\'></i>\",\r\n		\"title\":\"Tickets\",\r\n		\"link\":\"/tickets\"\r\n	},\r\n	{\r\n		\"icon\":\"<i class=\'fa-solid fa-table\'></i>\",\r\n		\"title\":\"Form Builder\",\r\n		\"link\":\"/form-builder\"\r\n	},\r\n	{\r\n		\"icon\":\"<i class=\'fa-solid fa-address-card\'></i>\",\r\n		\"title\":\"Scorecard Hub\",\r\n		\"link\":\"/scorecard\"\r\n	},\r\n	{\r\n		\"icon\":\"<i class=\'fa-solid fa-chart-line\'></i>\",\r\n		\"title\":\"Operations & Reporting\",\r\n		\"link\":\"/reporting\"\r\n	},\r\n	{\r\n		\"icon\":\"<i class=\'fa-solid fa-wifi\'></i>\",\r\n		\"title\":\"SSO Connection\",\r\n		\"link\":\"/connections\"\r\n	}\r\n]', 'Sidebar Menu for Admin', '2022-07-14 10:58:05', '2022-07-19 12:33:43');

-- --------------------------------------------------------

--
-- Table structure for table `stores`
--

CREATE TABLE `stores` (
  `id` int(11) NOT NULL,
  `uid` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `location` text NOT NULL,
  `district` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `created` varchar(100) NOT NULL,
  `updated` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee_mata`
--
ALTER TABLE `employee_mata`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stores`
--
ALTER TABLE `stores`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=385;

--
-- AUTO_INCREMENT for table `employee_mata`
--
ALTER TABLE `employee_mata`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `stores`
--
ALTER TABLE `stores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
