-- Adminer 4.1.0 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `AnswerGroup`;
CREATE TABLE `AnswerGroup` (
  `AnswerID` int(11) NOT NULL AUTO_INCREMENT,
  `QuestionaireID` int(11) NOT NULL,
  PRIMARY KEY (`AnswerID`,`QuestionaireID`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

INSERT INTO `AnswerGroup` (`AnswerID`, `QuestionaireID`) VALUES
(1,	1),
(2,	1);

DROP TABLE IF EXISTS `Answers`;
CREATE TABLE `Answers` (
  `AnswerID` int(11) NOT NULL,
  `QuestionID` int(11) NOT NULL,
  `ModuleID` varchar(10) NOT NULL,
  `StaffID` varchar(6) NOT NULL DEFAULT '',
  `NumValue` int(11) DEFAULT NULL,
  `TextValue` text,
  PRIMARY KEY (`AnswerID`,`QuestionID`,`ModuleID`,`StaffID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `Modules`;
CREATE TABLE `Modules` (
  `ModuleID` varchar(10) NOT NULL,
  `ModuleTitle` varchar(200) NOT NULL,
  PRIMARY KEY (`ModuleID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `Modules` (`ModuleID`, `ModuleTitle`) VALUES
('CS10110',	'Introduction to Computer Hardware, Operating Systems and Unix Tools'),
('CS10410',	'The Mathematics Driving License for Computer Science'),
('CS12020',	'Introduction to Programming'),
('CS12510',	'Functional Programming'),
('CS15020',	'Web Development Tools'),
('CS10720',	'Problems and Solutions'),
('CS12320',	'Programming Using an Object-Oriented Language'),
('CS18010',	'Professional and Personal Development'),
('CS20410',	'The Advanced Mathematics Driving License for Computer Science '),
('CS21120',	'Program Design, Data Structures and Algorithms '),
('CS22120',	'The Software Development Life Cycle'),
('CS23710',	'C and UNIX Programming'),
('CS24110',	'Image Processing'),
('CS25010',	'Web Programming'),
('CS25110',	'Introduction to System and Network Services Administration'),
('CS25410',	'Computer Architecture and Hardware '),
('CS26110',	'The Artificial Intelligence Toolbox Part 1: how to Find Solutions '),
('CS27020',	'Modelling Persistent Data'),
('CS28310',	'Introduction to Business Processes for Web Developers'),
('CS31310',	'Agile Methodologies '),
('CS32310',	'Advanced Computer Graphics '),
('CS34110',	'Computer Vision '),
('CS35710',	'Ubiquitous Computing '),
('CS35910',	'Internet Services Administration '),
('CS36110',	'Machine Learning '),
('CS36510',	'Space Robotics '),
('CS37420',	'E-Commerce: Implementation, Management and Security'),
('CS38110',	'Open Source Development Issues '),
('CS39820',	'Business Information Technology Group Project'),
('CS22310',	'User Centred Design and Human Computer Interaction '),
('CS22510',	'C++, C and Java Programming Paradigms '),
('CS25210',	'Client-Side Graphics Programming for the Web'),
('CS25710',	'Mobile, Embedded and Wearable Technology '),
('CS26210',	'The Artificial Intelligence Toolbox - Part ii: Programming in An Uncertain World '),
('CS26410',	'Introduction to Robotics '),
('CS27510',	'Commercial Database Applications '),
('CS35810',	'Further Issues in System and Network Services Administration '),
('CS36410',	'Intelligent Robotics '),
('CS38220',	'Professional Issues in the Computing Industry '),
('CS39440',	'Major Project '),
('CS39620',	'Minor Project '),
('CS39930',	'Web-Based Major Project ');

DROP TABLE IF EXISTS `Questionaires`;
CREATE TABLE `Questionaires` (
  `QuestionaireID` int(11) NOT NULL AUTO_INCREMENT,
  `QuestionaireName` varchar(20) NOT NULL,
  `QuestionaireDepartment` enum('Art','IBERS','CompSci','Welsh') NOT NULL,
  PRIMARY KEY (`QuestionaireID`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

INSERT INTO `Questionaires` (`QuestionaireID`, `QuestionaireName`, `QuestionaireDepartment`) VALUES
(1,	'test',	'CompSci'),
(2,	'test',	'CompSci');

DROP TABLE IF EXISTS `Questions`;
CREATE TABLE `Questions` (
  `QuestionID` int(11) NOT NULL,
  `Staff` bit(1) NOT NULL,
  `QuestionText` text NOT NULL,
  `QuestionText_welsh` text NOT NULL,
  `Type` enum('rate','text') NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `Questions` (`QuestionID`, `Staff`, `QuestionText`, `QuestionText_welsh`, `Type`) VALUES
(1,	CONV('0', 2, 10) + 0,	'I have learned a good deal from this module',	'Rydw i wedi dysgu llawer o\'r modiwl',	'rate'),
(2,	CONV('1', 2, 10) + 0,	'This module was well taught by %s',	'Mae\'r modiwl ei haddysgu yn dda %s',	'rate'),
(3,	CONV('0', 2, 10) + 0,	'What one thing would you change to improve this module, and why?',	'Gwelliannau Modiwl, a pham?',	'text'),
(4,	CONV('0', 2, 10) + 0,	'Please add any further comments on this module below',	'sylwadau pellach',	'text');

DROP TABLE IF EXISTS `Staff`;
CREATE TABLE `Staff` (
  `UserID` varchar(6) NOT NULL,
  `Name` varchar(30) NOT NULL,
  PRIMARY KEY (`UserID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `Staff` (`UserID`, `Name`) VALUES
('bpt',	'Bernie Tiddeman'),
('dpb',	'Dave Barnes'),
('mhl',	'Mark Lee'),
('cjp',	'Chris Price'),
('qqs',	'Qiang Shen'),
('rrz',	'Reyer Zwiggelaar'),
('geg18',	'Georgios Gkoutos'),
('jgh',	'Jun He'),
('thj10',	'Thomas Jansen'),
('ffl',	'Frederic Labrosse'),
('yyl',	'Yonghuai Liu'),
('fwl',	'Fred Long'),
('mjn',	'Mark Neal'),
('waa2',	'Wayne Aubrey'),
('afc',	'Amanda Clare'),
('hmd1',	'Hannah Dee'),
('nwh',	'Nigel Hardy'),
('rkj',	'Richard Jensen'),
('cul',	'Chuan Lu'),
('phs',	'Patricia Shaw'),
('eds',	'Edel Sherratt'),
('nns',	'Neal Snooke'),
('elt7',	'Elio Tuci'),
('mxw',	'Myra Wilson'),
('roh25',	'Robert Hoehndorf'),
('ncm',	'Neil MacParthalain'),
('cns',	'Changjing Shang'),
('job46',	'Jonathan Bell'),
('alg25',	'Alexandros Giagkos'),
('weh',	'Wenda He'),
('hem23',	'Helen Miles'),
('cos',	'Colin Sauze'),
('hgs08',	'Harry Strange'),
('lgt',	'Laurence Tyler'),
('dap',	'Dave Price'),
('cwl',	'Chris Loftus'),
('rrrp',	'Rhys Parry'),
('ais',	'Adrian Shaw'),
('rcs',	'Richard Shipman'),
('aos',	'Andy Starr'),
('nst',	'Neil Taylor'),
('ltt',	'Lynda Thomas'),
('ohe',	'John Edkins'),
('hoh',	'Horst Holstein'),
('htp',	'Heather Phillips'),
('rds',	'David Sherratt'),
('mfb',	'Frank Bott'),
('esa3',	'Eslam Al-Hersh'),
('faa3',	'Fahad Alghamdi'),
('bua',	'Bushra Alolayan'),
('yar',	'Yambu Andrik Rampun'),
('szb',	'Suzana Barreto'),
('ttb7',	'Tom Blanchard'),
('juc3',	'Juan Cao'),
('jec44',	'Jessica Charlton'),
('chc16',	'Chengyuan Chen'),
('tic4',	'Tianhua Chen'),
('mfc1',	'Michael Clarke'),
('jtg09',	'James Green'),
('chg12',	'Chen Gui'),
('shj1',	'Shangzhu Jin'),
('mjw9',	'Max Walker'),
('oal',	'Olalekan Lanihun'),
('zhl6',	'Zhenpeng Li'),
('lul1',	'Lu Lou'),
('mhm1',	'Muhanad Mohammed'),
('mum4',	'Muhammad Mohmand'),
('nkn',	'Nitin Naik'),
('apn3',	'Aparajit Narayan'),
('mro7',	'Mark Ososinski'),
('lip8',	'Lilan Pan'),
('map13',	'Matthew Pugh'),
('jjr6',	'Jonathan Roscoe'),
('pds7',	'Peter Scully'),
('als31',	'Alassane Seck'),
('lls08',	'Liang Shen'),
('jis17',	'Jingping Song'),
('pas23',	'Pan Su'),
('sfw7',	'Shisheng Wang'),
('liw19',	'Liping Wang'),
('muw1',	'Muhammad Waqar'),
('yoz1',	'Yongfeng Zhang'),
('liz5',	'Ling Zheng'),
('emp22',	'Emma Posey'),
('cls26',	'Claie Suaze'),
('niz2',	'Ni Zhu'),
('prw4',	'Phillip Wilkinson'),
('ghd',	'Huw Davies'),
('jig',	'John Gilbey'),
('spk',	'Stephen Kingston'),
('rrp',	'Rhys Parry');

DROP TABLE IF EXISTS `StaffToModules`;
CREATE TABLE `StaffToModules` (
  `ModuleID` varchar(200) NOT NULL,
  `UserID` varchar(6) NOT NULL,
  `QuestionaireID` int(11) NOT NULL,
  PRIMARY KEY (`ModuleID`,`UserID`,`QuestionaireID`),
  KEY `UserID` (`UserID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `StaffToModules` (`ModuleID`, `UserID`, `QuestionaireID`) VALUES
('CS10110',	'dap',	0),
('CS10110',	'lgt',	0),
('CS10110',	'mfc1',	0),
('CS10410',	'dap',	0),
('CS10410',	'nkn',	0),
('CS10720',	'thj10',	0),
('CS12020',	'aos',	0),
('CS12320',	'cwl',	0),
('CS12510',	'afc',	0),
('CS15010',	'hmd1',	0),
('CS15020',	'ais',	0),
('CS18010',	'fwl',	0),
('CS18010',	'hmd1',	0),
('CS20410',	'afc',	0),
('CS20410',	'fwl',	0),
('CS21120',	'ltt',	0),
('CS21120',	'ncm',	0),
('CS21120',	'rcs',	0),
('CS22120',	'bpt',	0),
('CS22120',	'cjp',	0),
('CS22120',	'dap',	0),
('CS22310',	'nwh',	0),
('CS22510',	'ffl',	0),
('CS22510',	'job46',	0),
('CS23710',	'dap',	0),
('CS23710',	'fwl',	0),
('CS24110',	'yyl',	0),
('CS25010',	'ais',	0),
('CS25010',	'jjr6',	0),
('CS25110',	'ais',	0),
('CS25110',	'jig',	0),
('CS25110',	'spk',	0),
('CS25210',	'hmd1',	0),
('CS25410',	'thj10',	0),
('CS25710',	'cos',	0),
('CS25710',	'nns',	0),
('CS26110',	'rkj',	0),
('CS26210',	'elt7',	0),
('CS26210',	'mxw',	0),
('CS26410',	'mxw',	0),
('CS26410',	'ttb7',	0),
('CS27020',	'eds',	0),
('CS27020',	'nkn',	0),
('CS27510',	'rcs',	0),
('CS28310',	'eds',	0),
('CS31310',	'eds',	0),
('CS32310',	'bpt',	0),
('CS32310',	'hoh',	0),
('CS34110',	'ffl',	0),
('CS34110',	'yyl',	0),
('CS35710',	'mjn',	0),
('CS35810',	'ais',	0),
('CS35810',	'jig',	0),
('CS35810',	'spk',	0),
('CS35910',	'ais',	0),
('CS35910',	'jig',	0),
('CS35910',	'spk',	0),
('CS36110',	'cul',	0),
('CS36110',	'yyl',	0),
('CS36410',	'mjn',	0),
('CS36410',	'mxw',	0),
('CS36510',	'dpb',	0),
('CS37420',	'cwl',	0),
('CS37420',	'nst',	0),
('CS38110',	'rcs',	0),
('CS38220',	'mfb',	0),
('CS38220',	'rrp',	0),
('CS39820',	'rrp',	0);

DROP TABLE IF EXISTS `Students`;
CREATE TABLE `Students` (
  `UserID` varchar(6) NOT NULL,
  `Department` enum('Art','IBERS','CompSci','Welsh') NOT NULL,
  PRIMARY KEY (`UserID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `Students` (`UserID`, `Department`) VALUES
('keo7',	'CompSci'),
('stm26',	'CompSci'),
('abc1',	'CompSci');

DROP TABLE IF EXISTS `StudentsToModules`;
CREATE TABLE `StudentsToModules` (
  `UserID` varchar(6) NOT NULL,
  `ModuleID` varchar(200) NOT NULL,
  `QuestionaireID` int(11) NOT NULL,
  PRIMARY KEY (`UserID`,`ModuleID`,`QuestionaireID`),
  KEY `ModuleID` (`ModuleID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `StudentsToModules` (`UserID`, `ModuleID`, `QuestionaireID`) VALUES
('abc1',	'CS10110',	1),
('keo7',	'CS28310',	1),
('keo7',	'CS31310',	0),
('keo7',	'CS35910',	0),
('keo7',	'CS37420',	0),
('keo7',	'CS38110',	0),
('keo7',	'CS38220',	0),
('keo7',	'CS39440',	0),
('stm26',	'CS10110',	0),
('stm26',	'CS10410',	0),
('stm26',	'CS10720',	0),
('stm26',	'CS12020',	0),
('stm26',	'CS12320',	0),
('stm26',	'CS12510',	0),
('stm26',	'CS18010',	0);

-- 2014-08-10 14:13:10