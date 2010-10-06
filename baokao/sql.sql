-- phpMyAdmin SQL Dump
-- version 3.3.5
-- http://www.phpmyadmin.net
--
-- 主机: 127.0.0.1:3306
-- 生成日期: 2010 年 10 月 06 日 07:45
-- 服务器版本: 5.1.36
-- PHP 版本: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `lfy_newbaokao`
--

-- --------------------------------------------------------

--
-- 表的结构 `lfy_bk_num`
--

CREATE TABLE IF NOT EXISTS `lfy_bk_num` (
  `bk_id` int(11) NOT NULL AUTO_INCREMENT,
  `stu_join` varchar(10) COLLATE utf8_bin NOT NULL,
  `bk_num` int(11) NOT NULL,
  PRIMARY KEY (`bk_id`),
  KEY `stu_join` (`stu_join`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `lfy_bk_num`
--

INSERT INTO `lfy_bk_num` (`bk_id`, `stu_join`, `bk_num`) VALUES
(1, '2007', 5),
(2, '2009', 3);

-- --------------------------------------------------------

--
-- 表的结构 `lfy_config`
--

CREATE TABLE IF NOT EXISTS `lfy_config` (
  `kemu_name` varchar(20) COLLATE utf8_bin NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 转存表中的数据 `lfy_config`
--

INSERT INTO `lfy_config` (`kemu_name`) VALUES
('计算机应用基础');

-- --------------------------------------------------------

--
-- 表的结构 `lfy_lanfengye`
--

CREATE TABLE IF NOT EXISTS `lfy_lanfengye` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户编号',
  `user_name` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '用户名',
  `user_pwd` char(32) COLLATE utf8_bin NOT NULL COMMENT '用户密码',
  `last_time` int(11) NOT NULL DEFAULT '0' COMMENT '最后登陆时间',
  `last_ip` varchar(15) COLLATE utf8_bin NOT NULL DEFAULT '127.0.0.1' COMMENT '最后登陆ip地址',
  PRIMARY KEY (`user_id`),
  KEY `user_id` (`user_id`,`user_name`),
  KEY `user_name` (`user_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='管理员用户表' AUTO_INCREMENT=20 ;

--
-- 转存表中的数据 `lfy_lanfengye`
--

INSERT INTO `lfy_lanfengye` (`user_id`, `user_name`, `user_pwd`, `last_time`, `last_ip`) VALUES
(3, 'admin', '21232f297a57a5a743894a0e4a801fc3', 0, '127.0.0.1');

-- --------------------------------------------------------

--
-- 表的结构 `lfy_pici`
--

CREATE TABLE IF NOT EXISTS `lfy_pici` (
  `pc_id` int(11) NOT NULL AUTO_INCREMENT,
  `pc_name` varchar(50) COLLATE utf8_bin NOT NULL,
  `pc_join` varchar(10) COLLATE utf8_bin NOT NULL,
  `pc_num` int(11) NOT NULL,
  `pc_off` char(1) COLLATE utf8_bin NOT NULL DEFAULT 'f',
  `pc_address` varchar(50) COLLATE utf8_bin NOT NULL,
  `pc_time` varchar(50) COLLATE utf8_bin NOT NULL,
  `pc_beizhu` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`pc_id`),
  KEY `pc_id` (`pc_id`,`pc_join`,`pc_off`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `lfy_pici`
--


-- --------------------------------------------------------

--
-- 表的结构 `lfy_stubk_temp`
--

CREATE TABLE IF NOT EXISTS `lfy_stubk_temp` (
  `sb_id` int(11) NOT NULL AUTO_INCREMENT,
  `stu_no` varchar(20) COLLATE utf8_bin NOT NULL,
  `pc_id` int(11) NOT NULL,
  `sb_input_time` int(11) NOT NULL,
  `sb_input_ip` varchar(15) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`sb_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=12 ;

--
-- 转存表中的数据 `lfy_stubk_temp`
--


-- --------------------------------------------------------

--
-- 表的结构 `lfy_stu_hege`
--

CREATE TABLE IF NOT EXISTS `lfy_stu_hege` (
  `hg_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '合格编号',
  `stu_no` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '学号',
  `pc_id` int(11) NOT NULL COMMENT '批次编号',
  `hg_num` float NOT NULL DEFAULT '100' COMMENT '分数',
  PRIMARY KEY (`hg_id`),
  KEY `stu_no` (`stu_no`),
  KEY `pc_id` (`pc_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=6 ;

--
-- 转存表中的数据 `lfy_stu_hege`
--


-- --------------------------------------------------------

--
-- 表的结构 `lfy_stu_info`
--

CREATE TABLE IF NOT EXISTS `lfy_stu_info` (
  `stu_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '编号',
  `stu_no` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '学号',
  `stu_name` varchar(6) COLLATE utf8_bin NOT NULL COMMENT '姓名',
  `stu_sex` char(1) COLLATE utf8_bin NOT NULL COMMENT '性别',
  `depart_name` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '系别',
  `stu_class` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '专业班级',
  `stu_join` varchar(6) COLLATE utf8_bin NOT NULL COMMENT '入学时间',
  PRIMARY KEY (`stu_id`),
  UNIQUE KEY `stu_no_3` (`stu_no`),
  KEY `stu_no` (`stu_no`,`stu_name`,`stu_join`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='学生基本信息表' AUTO_INCREMENT=759 ;

--
-- 转存表中的数据 `lfy_stu_info`
--


-- --------------------------------------------------------

--
-- 表的结构 `lfy_stu_weiji`
--

CREATE TABLE IF NOT EXISTS `lfy_stu_weiji` (
  `wj_id` int(11) NOT NULL AUTO_INCREMENT,
  `stu_no` varchar(20) COLLATE utf8_bin NOT NULL,
  `pc_id` int(11) NOT NULL,
  `off` char(1) COLLATE utf8_bin NOT NULL DEFAULT 'f',
  `beizhu` text COLLATE utf8_bin NOT NULL COMMENT '违纪的备注信息',
  PRIMARY KEY (`wj_id`),
  KEY `stu_no` (`stu_no`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=8 ;

--
-- 转存表中的数据 `lfy_stu_weiji`
--

--
-- 表的结构 `lfy_stu_miankao`
--

CREATE TABLE IF NOT EXISTS `lfy_stu_miankao` (
  `mk_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '编号',
  `stu_no` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '学生学号',
  `beizhu` text COLLATE utf8_bin NOT NULL COMMENT '备注',
  `mk_time` int(11) NOT NULL COMMENT '免考时间',
  PRIMARY KEY (`mk_id`),
  KEY `stu_no` (`stu_no`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `lfy_stu_miankao`
--