/*
Navicat MySQL Data Transfer

Source Server         : 本地连接
Source Server Version : 50617
Source Host           : localhost:3306
Source Database       : crm

Target Server Type    : MYSQL
Target Server Version : 50617
File Encoding         : 65001

Date: 2015-06-30 01:01:03
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for think_users
-- ----------------------------
DROP TABLE IF EXISTS `think_users`;
CREATE TABLE `think_users` (
  `userid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户id',
  `username` char(20) NOT NULL DEFAULT '' COMMENT '用户名',
  `password` char(32) NOT NULL DEFAULT '' COMMENT '密码',
  `nickname` char(20) NOT NULL DEFAULT '' COMMENT '昵称',
  `regdate` int(10) unsigned  COMMENT '注册时间',
  `lastdate` int(10) unsigned COMMENT '最后一次登录时间',
  `regip` char(15) DEFAULT '' COMMENT '注册ip',
  `lastip` char(15) DEFAULT '' COMMENT '最后一次登录ip',
  `loginnum` smallint(5) unsigned DEFAULT '0' COMMENT '登录次数',
  `mobile` char(11) DEFAULT '' COMMENT '手机号码',
  PRIMARY KEY (`userid`),
  UNIQUE KEY `username` (`username`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
