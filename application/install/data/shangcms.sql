/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50547
Source Host           : localhost:3306
Source Database       : shangcms

Target Server Type    : MYSQL
Target Server Version : 50547
File Encoding         : 65001

Date: 2018-12-04 00:23:27
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for shang_admin
-- ----------------------------
DROP TABLE IF EXISTS `shang_admin`;
CREATE TABLE `shang_admin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL DEFAULT '' COMMENT '登录名',
  `password` varchar(32) NOT NULL DEFAULT '' COMMENT '密码',
  `realname` varchar(20) NOT NULL DEFAULT '',
  `email` varchar(100) NOT NULL DEFAULT '',
  `logintime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '登录时间',
  `loginip` varchar(30) NOT NULL DEFAULT '' COMMENT '登录IP',
  `intro` varchar(255) NOT NULL,
  `islock` int(1) NOT NULL DEFAULT '0',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '管理员创建时间',
  `update_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='管理员';

-- ----------------------------
-- Records of shang_admin
-- ----------------------------
INSERT INTO `shang_admin` VALUES ('1', 'admin', 'c3284d0f94606de1fd2af172aba15bf3', '商学斌', '258775519@qq.com', '1543849581', '::1', '123', '0', '1543726520', '1543726520');

-- ----------------------------
-- Table structure for shang_article
-- ----------------------------
DROP TABLE IF EXISTS `shang_article`;
CREATE TABLE `shang_article` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `catid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '栏目ID',
  `title` varchar(120) NOT NULL DEFAULT '',
  `content` text NOT NULL,
  `thumb` varchar(100) NOT NULL DEFAULT '',
  `style` char(24) NOT NULL,
  `keywords` varchar(100) NOT NULL DEFAULT '',
  `description` mediumtext NOT NULL,
  `flag` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '推荐',
  `views` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(2) unsigned NOT NULL DEFAULT '1',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `catid` (`catid`,`status`,`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='文章内容表';


-- ----------------------------
-- Table structure for shang_category
-- ----------------------------
DROP TABLE IF EXISTS `shang_category`;
CREATE TABLE `shang_category` (
  `catid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `catname` varchar(30) NOT NULL,
  `catdir` varchar(30) NOT NULL,
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '1表示单页面 0文章栏目',
  `pid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '父栏目ID',
  `thumb` varchar(100) NOT NULL,
  `seotitle` varchar(50) NOT NULL,
  `keyword` varchar(120) NOT NULL,
  `description` mediumtext NOT NULL,
  `content` text NOT NULL,
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  PRIMARY KEY (`catid`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='栏目表';


-- ----------------------------
-- Table structure for shang_flink
-- ----------------------------
DROP TABLE IF EXISTS `shang_flink`;
CREATE TABLE `shang_flink` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '友情链接名称',
  `url` varchar(255) NOT NULL COMMENT 'url',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '描述',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态 1显示0不显示',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  `update_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='友情链接表';


-- ----------------------------
-- Table structure for shang_system
-- ----------------------------
DROP TABLE IF EXISTS `shang_system`;
CREATE TABLE `shang_system` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL DEFAULT '' COMMENT '标识',
  `title` varchar(50) NOT NULL DEFAULT '' COMMENT '名称',
  `remark` varchar(100) NOT NULL DEFAULT '' COMMENT '说明',
  `tvalue` varchar(150) NOT NULL DEFAULT '' COMMENT '参数类型',
  `typeid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '类型',
  `groupid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '分组',
  `value` text,
  `sort` smallint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COMMENT='系统设置表';

-- ----------------------------
-- Records of shang_system
-- ----------------------------
INSERT INTO `shang_system` VALUES ('1', 'site_name', '站点名称', '', '', '0', '1', '我的网站', '0');
INSERT INTO `shang_system` VALUES ('2', 'site_title', 'SEO标题', 'seo标题', '', '0', '1', '我的网站', '0');
INSERT INTO `shang_system` VALUES ('3', 'site_keywords', 'SEO关键字', 'seo关键词', '', '0', '1', '我的网站', '0');
INSERT INTO `shang_system` VALUES ('4', 'site_description', 'SEO描述', 'seo描述', 'textarea', '0', '1', '我的网站ffffff', '0');
INSERT INTO `shang_system` VALUES ('5', 'site_address', '地址', '', '', '0', '1', '', '0');
INSERT INTO `shang_system` VALUES ('6', 'site_closed', '关闭网站', '1表示临时关闭', 'radio', '0', '1', '0', '0');
INSERT INTO `shang_system` VALUES ('7', 'site_icp', 'ICP备案号', '', '', '0', '1', '', '0');
INSERT INTO `shang_system` VALUES ('8', 'site_tel', '客服电话', '', '', '0', '1', '18827633950', '0');
INSERT INTO `shang_system` VALUES ('9', 'site_wx', '站长微信号', '', '', '0', '1', '', '0');
INSERT INTO `shang_system` VALUES ('10', 'site_qq', '站长QQ', '', '', '0', '1', '83301043', '0');
INSERT INTO `shang_system` VALUES ('11', 'site_email', '邮箱', '', '', '0', '1', '258775519@qq.com', '0');
INSERT INTO `shang_system` VALUES ('12', 'display_thumbw', '缩略图宽度', '', '', '0', '2', '300', '0');
INSERT INTO `shang_system` VALUES ('13', 'display_thumbh', '缩略图高度', '', '', '0', '2', '300', '0');
INSERT INTO `shang_system` VALUES ('14', 'email_host', '邮箱服务器', '', '', '0', '3', 'smtp.exmail.qq.com', '0');
INSERT INTO `shang_system` VALUES ('15', 'email_port', '端口号', '', '', '0', '3', '25', '0');
INSERT INTO `shang_system` VALUES ('16', 'email_username', '邮箱用户名', '', '', '0', '3', 'petct@ixingmu.com.cn', '0');
INSERT INTO `shang_system` VALUES ('17', 'email_password', '邮箱密码', '', '', '0', '3', 'petsend88', '0');
INSERT INTO `shang_system` VALUES ('18', 'email_fromemail', '发件人邮箱', '', '', '0', '3', '258775519@qq.com', '0');
INSERT INTO `shang_system` VALUES ('19', 'database_path', '备份目录', '数据库备份路径,路径必须以 / 结尾', '', '0', '4', './public/data/', '0');
INSERT INTO `shang_system` VALUES ('20', 'database_size', '备份分卷大小', '用于限制压缩后的分卷最大长度。单位：B；建议设置20M', '', '0', '4', '20971520', '0');
INSERT INTO `shang_system` VALUES ('21', 'database_compress', '备份压缩开关', '压缩备份文件需要PHP环境支持gzopen,gzwrite函数', 'checkbox', '0', '4', '1', '0');
INSERT INTO `shang_system` VALUES ('22', 'database_level', '备份压缩级别', '数据库备份文件的压缩级别，该配置在开启压缩时生效', 'radio', '0', '4', '4', '0');
