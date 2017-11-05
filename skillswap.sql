-- phpMyAdmin SQL Dump
-- version 4.2.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 05, 2017 at 01:18 PM
-- Server version: 5.6.24
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `skillswap`
--

-- --------------------------------------------------------

--
-- Table structure for table `album`
--

CREATE TABLE IF NOT EXISTS `album` (
`album_id` int(11) unsigned NOT NULL,
  `album_date` datetime DEFAULT NULL,
  `album_location` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `album_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `album_desc` text COLLATE utf8_unicode_ci,
  `m_id` int(11) unsigned NOT NULL DEFAULT '1'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=13 ;

--
-- Dumping data for table `album`
--

INSERT INTO `album` (`album_id`, `album_date`, `album_location`, `album_title`, `album_desc`, `m_id`) VALUES
(1, '2008-10-20 12:11:53', '清水', '清水路邊老攤冰店', '清水路邊老攤冰店，很古早味的冰。', 27),
(2, '2008-10-20 12:13:08', '樹太老定食', '一家三口聚餐', '樹太老定食，不錯吃。', 27),
(3, '2008-10-20 12:14:37', '大翔書局', '十月份慶生', '幫朋友小朋友十月份慶生', 27),
(4, '2008-10-20 12:15:16', '三育書院', '三育書院', '三育書院很漂亮，假日可以進去逛逛。', 27),
(5, '2008-10-20 12:16:18', '文淵閣工作室', '忙碌的工作室', '大家忙著做卡片，很忙啊！', 25),
(6, '2008-10-20 12:17:22', '清水牛肉麵', '兒子吃牛肉麵', '清水牛肉麵，很好吃，看兒子的樣子就知道了。', 25),
(7, '2008-10-20 12:18:31', '埔里往武嶺的路上', '武嶺單車之旅', '武嶺，我來了。', 24),
(8, '2008-10-20 12:22:39', '高美溼地', '高美溼地', '高美溼地，怎麼拍都好看。', 24),
(9, '2008-10-20 12:24:31', '各處', '可愛的兒子', '嗯，真是可愛，誰生的嘛～～～', 24),
(10, '1111-11-11 00:00:00', '1111', 'test', '11111', 1);

-- --------------------------------------------------------

--
-- Table structure for table `albumphoto`
--

CREATE TABLE IF NOT EXISTS `albumphoto` (
`ap_id` int(11) unsigned NOT NULL,
  `album_id` int(11) unsigned DEFAULT NULL,
  `ap_subject` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ap_date` datetime DEFAULT NULL,
  `ap_picurl` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ap_hits` int(11) unsigned NOT NULL DEFAULT '0'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=52 ;

--
-- Dumping data for table `albumphoto`
--

INSERT INTO `albumphoto` (`ap_id`, `album_id`, `ap_subject`, `ap_date`, `ap_picurl`, `ap_hits`) VALUES
(1, 1, '清水路邊老攤冰店', '2008-10-20 12:13:03', 'IMAGE_042.jpg', 0),
(2, 1, '清水路邊老攤冰店', '2008-10-20 12:13:03', 'IMAGE_043.jpg', 0),
(3, 1, '清水路邊老攤冰店', '2008-10-20 12:13:03', 'IMAGE_044.jpg', 0),
(4, 1, '清水路邊老攤冰店', '2008-10-20 12:13:03', 'IMAGE_045.jpg', 0),
(5, 2, '樹太老定食', '2008-10-20 12:13:48', 'IMAGE_052.jpg', 0),
(6, 2, '樹太老定食', '2008-10-20 12:13:48', 'IMAGE_053.jpg', 0),
(7, 2, '樹太老定食', '2008-10-20 12:13:48', 'IMAGE_054.jpg', 0),
(8, 2, '樹太老定食', '2008-10-20 12:13:49', 'IMAGE_058.jpg', 1),
(9, 2, '樹太老定食', '2008-10-20 12:13:49', 'IMAGE_059.jpg', 0),
(10, 2, '樹太老定食', '2008-10-20 12:14:24', 'IMAGE_061.jpg', 0),
(11, 2, '樹太老定食', '2008-10-20 12:14:24', 'IMAGE_062.jpg', 0),
(12, 3, '十月份慶生', '2008-10-20 12:15:12', '200809202004_076.jpg', 0),
(13, 3, '十月份慶生', '2008-10-20 12:15:12', '200809202004_077.jpg', 1),
(14, 4, '三育書院', '2008-10-20 12:16:06', 'IMAGE_00073.jpg', 0),
(15, 4, '三育書院', '2008-10-20 12:16:06', 'IMAGE_00075.jpg', 1),
(16, 4, '三育書院', '2008-10-20 12:16:06', 'IMAGE_00076.jpg', 0),
(17, 4, '三育書院', '2008-10-20 12:16:06', 'IMAGE_00078.jpg', 0),
(18, 4, '三育書院', '2008-10-20 12:16:06', 'IMAGE_00079.jpg', 0),
(19, 5, '忙碌的工作室', '2008-10-20 12:17:20', 'IMAGE_011.jpg', 0),
(20, 5, '忙碌的工作室', '2008-10-20 12:17:20', 'IMAGE_012.jpg', 1),
(21, 5, '忙碌的工作室', '2008-10-20 12:17:20', 'IMAGE_013.jpg', 0),
(22, 5, '忙碌的工作室', '2008-10-20 12:17:20', 'IMAGE_015.jpg', 0),
(23, 6, '清水牛肉麵', '2008-10-20 12:18:28', 'IMAGE_034.jpg', 0),
(24, 6, '清水牛肉麵', '2008-10-20 12:18:28', 'IMAGE_035.jpg', 0),
(25, 6, '清水牛肉麵', '2008-10-20 12:18:28', 'IMAGE_041.jpg', 0),
(26, 6, '清水牛肉麵', '2008-10-20 12:18:28', 'IMAGE_048.jpg', 0),
(27, 7, '武嶺單車之旅', '2008-10-20 12:19:50', 'DSC09616.JPG', 1),
(28, 7, '武嶺單車之旅', '2008-10-20 12:19:50', 'DSC09627.JPG', 0),
(29, 7, '武嶺單車之旅', '2008-10-20 12:19:50', 'DSC09631.JPG', 0),
(30, 7, '武嶺單車之旅', '2008-10-20 12:19:50', 'DSC09678.JPG', 0),
(31, 7, '武嶺單車之旅', '2008-10-20 12:19:50', 'DSC09685.JPG', 0),
(32, 7, '武嶺單車之旅', '2008-10-20 12:20:18', 'DSC09689.JPG', 1),
(33, 7, '武嶺單車之旅', '2008-10-20 12:20:18', 'DSC09692.JPG', 0),
(34, 7, '武嶺單車之旅', '2008-10-20 12:20:18', 'DSC09695.JPG', 0),
(35, 8, '高美溼地', '2008-10-20 12:23:11', 'IMAGE_049.jpg', 1),
(36, 8, '高美溼地', '2008-10-20 12:23:11', 'IMAGE_050.jpg', 3),
(37, 8, '高美溼地', '2008-10-20 12:23:11', 'IMAGE_051.jpg', 0),
(38, 9, '可愛的兒子', '2008-10-20 12:25:25', '200809201134_072.jpg', 1),
(39, 9, '可愛的兒子', '2008-10-20 12:25:25', 'DSCN3442.JPG', 2),
(40, 9, '可愛的兒子', '2008-10-20 12:25:25', 'DSCN3449.JPG', 1),
(41, 9, '可愛的兒子', '2008-10-20 12:25:25', 'DSCN3562.JPG', 0),
(42, 9, '可愛的兒子', '2008-10-20 12:25:25', 'DSCN3693.JPG', 0),
(43, 9, '可愛的兒子', '2008-10-20 12:25:44', 'IMAGE_00038.jpg', 7),
(44, 9, '可愛的兒子', '2008-10-20 12:25:44', 'IMAGE_00040.jpg', 3),
(45, 9, '可愛的兒子', '2008-10-20 12:25:44', 'IMAGE_00135.jpg', 2),
(46, 10, 'aaaa', '2017-11-05 17:22:45', 'aaa.jpg', 0),
(47, 10, 'bbbb', '2017-11-05 17:22:45', 'bbb.png', 0);

-- --------------------------------------------------------

--
-- Table structure for table `board`
--

CREATE TABLE IF NOT EXISTS `board` (
`boardid` int(11) unsigned NOT NULL,
  `boardname` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `boardsex` enum('男','女') COLLATE utf8_unicode_ci DEFAULT '男',
  `boardsubject` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `boardtime` datetime DEFAULT NULL,
  `boardmail` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `boardweb` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `boardcontent` text COLLATE utf8_unicode_ci,
  `boardavatar` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `boardlikes` int(11) unsigned NOT NULL DEFAULT '0'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=29 ;

--
-- Dumping data for table `board`
--

INSERT INTO `board` (`boardid`, `boardname`, `boardsex`, `boardsubject`, `boardtime`, `boardmail`, `boardweb`, `boardcontent`, `boardavatar`, `boardlikes`) VALUES
(12, 'aaaaa', '男', '', '2017-11-02 16:46:02', 'aaaa@gmail.com', '', 'with pic', 'aaa.jpg', 0),
(13, 'aaaaa', '男', '', '2017-11-02 16:47:23', 'aaaa@gmail.com', '', 'bbbegewrg', 'aaa.jpg', 0),
(14, 'aaaaa', '男', '', '2017-11-02 16:49:09', 'aaaa@gmail.com', '', 'gggg', 'aaa.jpg', 0),
(15, 'aaaaa', '男', '', '2017-11-02 16:49:49', 'aaaa@gmail.com', '', 'ffff', 'aaa.jpg', 0),
(16, 'aaaaa', '男', '', '2017-11-02 16:49:59', 'aaaa@gmail.com', '', 'geqrge', 'aaa.jpg', 0),
(17, 'bbbbb', '女', '', '2017-11-02 17:27:47', 'bbbbb@gmail.com', '', 'hahah', 'bbb.png', 0),
(18, 'bbbbb', '女', '', '2017-11-02 18:01:59', 'bbbbb@gmail.com', '', 'bbb', 'bbb.png', 2),
(19, 'bbbbb', '女', '', '2017-11-02 18:02:08', 'bbbbb@gmail.com', '', 'haha\r\n', 'bbb.png', 1),
(20, 'ccccc', '女', '', '2017-11-03 15:01:28', 'ccccc@gmail.com', '', 'ccc 1', 'ccc.jpg', 0),
(21, 'ccccc', '女', '', '2017-11-03 15:07:06', 'ccccc@gmail.com', '', 'haha', 'ccc.jpg', 4),
(22, 'ccccc', '女', '', '2017-11-03 15:57:31', 'ccccc@gmail.com', '', 'ddd', 'ccc.jpg', 6),
(23, 'aaaaa', '男', '', '2017-11-05 20:55:05', 'aaaa@gmail.com', '', 'Im done!', 'aaa.jpg', 0),
(24, 'aaaaa', '男', '', '2017-11-05 20:55:25', 'aaaa@gmail.com', '', 'hahaah', 'aaa.jpg', 0),
(25, 'aaaaa', '男', '', '2017-11-05 20:55:29', 'aaaa@gmail.com', '', 'shit!', 'aaa.jpg', 0),
(26, 'aaaaa', '男', '', '2017-11-05 21:00:48', 'aaaa@gmail.com', '', '徵求英文交換日文，意者私訊！', 'aaa.jpg', 0),
(27, 'bbbbb', '女', '', '2017-11-05 21:01:24', 'bbbbb@gmail.com', '', '徵求程式設計交換吉他，已有底子，請私訊', 'bbb.png', 0),
(28, 'ccccc', '女', '', '2017-11-05 21:01:52', 'ccccc@gmail.com', '', '徵求舞蹈交換英文，私訊洽談！謝謝！', 'ccc.jpg', 0);

-- --------------------------------------------------------

--
-- Table structure for table `memberdata`
--

CREATE TABLE IF NOT EXISTS `memberdata` (
`m_id` int(11) unsigned NOT NULL,
  `m_name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `m_username` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `m_passwd` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `m_sex` enum('男','女') COLLATE utf8_unicode_ci NOT NULL,
  `m_birthday` date DEFAULT NULL,
  `m_level` enum('admin','member') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'member',
  `m_email` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `m_url` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `m_phone` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `m_address` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `m_login` int(11) unsigned NOT NULL DEFAULT '0',
  `m_logintime` datetime DEFAULT NULL,
  `m_jointime` datetime NOT NULL,
  `m_profilepic` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=28 ;

--
-- Dumping data for table `memberdata`
--

INSERT INTO `memberdata` (`m_id`, `m_name`, `m_username`, `m_passwd`, `m_sex`, `m_birthday`, `m_level`, `m_email`, `m_url`, `m_phone`, `m_address`, `m_login`, `m_logintime`, `m_jointime`, `m_profilepic`) VALUES
(1, '系統管理員', 'admin', '21232f297a57a5a743894a0e4a801fc3', '男', NULL, 'admin', NULL, NULL, NULL, NULL, 9, '2017-11-01 17:51:29', '2008-10-20 16:36:15', NULL),
(2, '簡奉君', 'elven', '1c2fa708e741cbe6d9ccbc212b8b7041', '女', '1987-04-04', 'member', 'elven@superstar.com', NULL, '0966765556', '台北市濟洲北路12號2樓', 1, '2008-10-21 12:06:35', '2008-10-21 12:03:12', NULL),
(3, '黃靖輪', 'jinglun', 'f25e60462431302fd9f307f2debe5d53', '男', '1987-07-01', 'member', 'jinglun@superstar.com', NULL, '0918181111', '台北市敦化南路93號5樓', 0, NULL, '2008-10-21 12:06:08', NULL),
(4, '潘四敬', 'sugie', 'e509badfb371bdcdf9372d756a3b5d6d', '男', '1987-08-11', 'member', 'sugie@superstar.com', NULL, '0914530768', '台北市中央路201號7樓', 0, NULL, '2008-10-21 12:06:08', NULL),
(5, '賴勝恩', 'shane', '7790ffbb26cf6409e707105e92cde91e', '男', '1984-06-20', 'member', 'shane@superstar.com', NULL, '0946820035', '台北市建國路177號6樓', 0, NULL, '2008-10-21 12:06:08', NULL),
(6, '黎楚寧', 'ivy', 'a735c3e8bc21cbe0f03e501a1529e0b4', '女', '1988-02-15', 'member', 'ivy@superstar.com', NULL, '0920981230', '台北市忠孝東路520號6樓', 0, NULL, '2008-10-21 12:06:08', NULL),
(7, '蔡中穎', 'zhong', 'b9bacca867e5b52547700acf557dedea', '男', '1987-05-05', 'member', 'zhong@superstar.com', NULL, '0951983366', '台北市三民路1巷10號', 0, NULL, '2008-10-21 12:06:08', NULL),
(8, '徐佳螢', 'lala', '2e3817293fc275dbee74bd71ce6eb056', '女', '1985-08-30', 'member', 'lala@superstar.com', NULL, '0918123456', '台北市仁愛路100號', 0, NULL, '2008-10-21 12:06:08', NULL),
(9, '林雨媗', 'crystal', 'cc989606b586f33918fe0552dec367c8', '女', '1986-12-10', 'member', 'crystal@superstar.com', NULL, '0907408965', '台北市民族路204號', 0, NULL, '2008-10-21 12:06:08', NULL),
(10, '林心儀', 'peggy', 'c7622c1e0f716dc3b121bc1db7b6cb4e', '女', '1988-12-01', 'member', 'peggy@superstar.com', NULL, '0916456723', '台北市建國北路10號', 0, NULL, '2008-10-21 12:06:08', NULL),
(11, '王燕博', 'albert', '6c5bc43b443975b806740d8e41146479', '男', '1993-08-10', 'member', 'albert@superstar.com', NULL, '0918976588', '台北市北環路2巷80號', 0, NULL, '2008-10-21 12:06:08', NULL),
(15, '11111', 'hayasi00', 'b0baee9d279d34fa1dfd71aadb908c3f', '男', '1986-02-17', 'member', '11111@gmail.com', '', '', '', 31, '2017-11-01 16:05:55', '2017-06-19 14:25:55', NULL),
(17, 'ttttt', 'ttttt', '6cee4618fc4960d184eb7efbd0aa27b5', '女', '1986-02-17', 'member', 'ttttt@gmail.com', '', '', '', 1, '2017-11-01 17:51:10', '2017-11-01 17:51:03', NULL),
(24, 'aaaaa', 'aaaaa', '594f803b380a41396ed63dca39503542', '男', '1986-02-17', 'member', 'aaaa@gmail.com', '22222@com', '2891084324', '', 21, '2017-11-05 19:47:05', '2017-11-02 15:57:16', 'aaa.jpg'),
(25, 'bbbbb', 'bbbbb', 'a21075a36eeddd084e17611a238c7101', '女', '1986-02-17', 'member', 'bbbbb@gmail.com', 'hahaha@.com', '11111', 'qffffff', 6, '2017-11-05 21:01:02', '2017-11-02 17:27:37', 'bbb.png'),
(27, 'ccccc', 'ccccc', '67c762276bced09ee4df0ed537d164ea', '女', '1986-02-17', 'member', 'ccccc@gmail.com', '', '', '', 5, '2017-11-05 21:01:32', '2017-11-03 15:01:07', 'ccc.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE IF NOT EXISTS `message` (
`id` int(10) unsigned NOT NULL,
  `from_user_id` int(10) unsigned NOT NULL,
  `to_user_id` int(11) unsigned NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `created_At` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `album`
--
ALTER TABLE `album`
 ADD PRIMARY KEY (`album_id`);

--
-- Indexes for table `albumphoto`
--
ALTER TABLE `albumphoto`
 ADD PRIMARY KEY (`ap_id`);

--
-- Indexes for table `board`
--
ALTER TABLE `board`
 ADD PRIMARY KEY (`boardid`);

--
-- Indexes for table `memberdata`
--
ALTER TABLE `memberdata`
 ADD PRIMARY KEY (`m_id`), ADD UNIQUE KEY `m_username` (`m_username`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
 ADD PRIMARY KEY (`id`), ADD KEY `from_user_id` (`from_user_id`), ADD KEY `to_user_id` (`to_user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `album`
--
ALTER TABLE `album`
MODIFY `album_id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `albumphoto`
--
ALTER TABLE `albumphoto`
MODIFY `ap_id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=52;
--
-- AUTO_INCREMENT for table `board`
--
ALTER TABLE `board`
MODIFY `boardid` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT for table `memberdata`
--
ALTER TABLE `memberdata`
MODIFY `m_id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `message`
--
ALTER TABLE `message`
ADD CONSTRAINT `message_ibfk_1` FOREIGN KEY (`from_user_id`) REFERENCES `memberdata` (`m_id`) ON DELETE CASCADE,
ADD CONSTRAINT `message_ibfk_2` FOREIGN KEY (`to_user_id`) REFERENCES `memberdata` (`m_id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
