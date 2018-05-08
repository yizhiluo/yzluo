/*
Navicat MySQL Data Transfer

Source Server         : xampp
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : blog5

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2018-05-08 11:41:45
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for blog_admin
-- ----------------------------
DROP TABLE IF EXISTS `blog_admin`;
CREATE TABLE `blog_admin` (
  `admin_id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_username` varchar(45) NOT NULL DEFAULT '' COMMENT '用户名',
  `admin_password` varchar(45) NOT NULL DEFAULT '' COMMENT '登录密码',
  PRIMARY KEY (`admin_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='后台管理员表';

-- ----------------------------
-- Table structure for blog_arc_tag
-- ----------------------------
DROP TABLE IF EXISTS `blog_arc_tag`;
CREATE TABLE `blog_arc_tag` (
  `arc_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  KEY `fk_table1_blog_article1_idx` (`arc_id`),
  KEY `fk_table1_blog_tag1_idx` (`tag_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='文章标签中间表';

-- ----------------------------
-- Table structure for blog_article
-- ----------------------------
DROP TABLE IF EXISTS `blog_article`;
CREATE TABLE `blog_article` (
  `arc_id` int(11) NOT NULL AUTO_INCREMENT,
  `arc_title` varchar(45) NOT NULL DEFAULT '' COMMENT '文章标题',
  `arc_author` varchar(45) NOT NULL DEFAULT '' COMMENT '文章作者',
  `arc_digest` varchar(200) NOT NULL DEFAULT '' COMMENT '文章摘要',
  `arc_content` text,
  `sendtime` int(11) NOT NULL DEFAULT '0' COMMENT '发表时间',
  `updatetime` int(11) NOT NULL DEFAULT '0' COMMENT '文章更新时间',
  `arc_click` int(11) NOT NULL DEFAULT '0' COMMENT '点击次数',
  `is_recycle` tinyint(4) NOT NULL DEFAULT '2' COMMENT '是否在回收站，1在回收站2代表不在回收站，默认2',
  `arc_thumb` varchar(100) NOT NULL DEFAULT '' COMMENT '文章缩略图',
  `cate_id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `arc_sort` int(11) NOT NULL DEFAULT '100' COMMENT '文章排序',
  PRIMARY KEY (`arc_id`),
  KEY `fk_blog_article_blog_cate_idx` (`cate_id`),
  KEY `fk_blog_article_blog_admin1_idx` (`admin_id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COMMENT='文章表';

-- ----------------------------
-- Table structure for blog_attachment
-- ----------------------------
DROP TABLE IF EXISTS `blog_attachment`;
CREATE TABLE `blog_attachment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(80) NOT NULL,
  `filename` varchar(300) NOT NULL COMMENT '文件名',
  `path` varchar(300) NOT NULL COMMENT '路径',
  `extension` varchar(10) NOT NULL DEFAULT '' COMMENT '类型',
  `createtime` int(10) NOT NULL COMMENT '上传时间',
  `size` mediumint(9) NOT NULL COMMENT '文件大小',
  PRIMARY KEY (`id`),
  KEY `extension` (`extension`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='附件';

-- ----------------------------
-- Table structure for blog_cate
-- ----------------------------
DROP TABLE IF EXISTS `blog_cate`;
CREATE TABLE `blog_cate` (
  `cate_id` int(11) NOT NULL AUTO_INCREMENT,
  `cate_name` varchar(45) NOT NULL DEFAULT '' COMMENT '栏目名称',
  `cate_pid` int(11) NOT NULL DEFAULT '0' COMMENT '父id',
  `cate_sort` int(11) NOT NULL DEFAULT '100' COMMENT '栏目排序',
  PRIMARY KEY (`cate_id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COMMENT='栏目管理';

-- ----------------------------
-- Table structure for blog_link
-- ----------------------------
DROP TABLE IF EXISTS `blog_link`;
CREATE TABLE `blog_link` (
  `link_id` int(11) NOT NULL AUTO_INCREMENT,
  `link_name` varchar(45) NOT NULL DEFAULT '' COMMENT '友链名称',
  `link_url` varchar(100) NOT NULL DEFAULT '' COMMENT '友链url',
  `link_sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '友链排序',
  PRIMARY KEY (`link_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='友链数据表';

-- ----------------------------
-- Table structure for blog_tag
-- ----------------------------
DROP TABLE IF EXISTS `blog_tag`;
CREATE TABLE `blog_tag` (
  `tag_id` int(11) NOT NULL AUTO_INCREMENT,
  `tag_name` varchar(45) NOT NULL DEFAULT '' COMMENT '标签名称',
  PRIMARY KEY (`tag_id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COMMENT='标签管理';

-- ----------------------------
-- Table structure for blog_webset
-- ----------------------------
DROP TABLE IF EXISTS `blog_webset`;
CREATE TABLE `blog_webset` (
  `webset_id` int(11) NOT NULL AUTO_INCREMENT,
  `webset_name` varchar(45) NOT NULL DEFAULT '' COMMENT '配置项名称',
  `webset_value` varchar(45) NOT NULL DEFAULT '' COMMENT '配置项值',
  `webset_des` varchar(45) NOT NULL DEFAULT '' COMMENT '配置项描述',
  PRIMARY KEY (`webset_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='站点配置';
