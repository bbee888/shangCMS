CREATE TABLE `sxb_system` (
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
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;




INSERT INTO `sxb_system` VALUES ('1', 'site_name', '站点名称', '', '', '0', '0', '我的网站', '0');
INSERT INTO `sxb_system` VALUES ('2', 'site_title', '站点标题', '', '', '0', '0', '我的网站', '0');
INSERT INTO `sxb_system` VALUES ('3', 'site_keywords', '站点关键字', '', '', '0', '0', '我的网站', '0');
INSERT INTO `sxb_system` VALUES ('4', 'site_description', '站点描述', '', '', '0', '0', '我的网站', '0');
INSERT INTO `sxb_system` VALUES ('5', 'site_address', '公司地址', '', '', '0', '0', '浙江省杭州市', '0');
INSERT INTO `sxb_system` VALUES ('6', 'site_closed', '关闭网站', '', 'radio', '0', '0', '0', '0');
INSERT INTO `sxb_system` VALUES ('7', 'site_icp', 'ICP备案号', '', '', '0', '0', '', '0');
INSERT INTO `sxb_system` VALUES ('8', 'site_tel', '客服电话', '', '', '0', '0', '0571-11223311', '0');
INSERT INTO `sxb_system` VALUES ('9', 'site_wx', '客服微信号', '', '', '0', '0', '', '0');
INSERT INTO `sxb_system` VALUES ('10', 'site_qq', '客服QQ号码', '多个客服的QQ号码请以半角逗号（,）分隔，如果需要设定昵称则在号码后跟 /昵称。', '', '0', '0', '553212320', '0');
INSERT INTO `sxb_system` VALUES ('11', 'site_email', '邮件地址', '', '', '0', '0', '553212320@qq.com', '0');
INSERT INTO `sxb_system` VALUES ('12', 'display_thumbw', '缩略图宽度', '', '', '0', '0', '300', '0');
INSERT INTO `sxb_system` VALUES ('13', 'display_thumbh', '缩略图高度', '', '', '0', '0', '300', '0');

INSERT INTO `sxb_system` VALUES ('14', 'email_host', '邮箱服务器主机地址', '', '', '0', '0', 'default', '0');
INSERT INTO `sxb_system` VALUES ('15', 'email_port', '端口号', '', '', '0', '0', '25', '0');
INSERT INTO `sxb_system` VALUES ('16', 'email_username', '邮箱用户名', '', '', '0', '0', 'default', '0');
INSERT INTO `sxb_system` VALUES ('17', 'email_password', '邮箱授权码', '', '', '0', '0', 'default', '0');
INSERT INTO `sxb_system` VALUES ('18', 'email_fromemail', '发件人邮箱', '', '', '0', '0', 'default', '0');
INSERT INTO `sxb_system` VALUES ('19', 'email_fromuser', '发件人用户名', '', '', '0', '0', 'default', '0');
INSERT INTO `sxb_system` VALUES ('20', 'email_debug', '开启调试模式', ' 0 No output  1 Commands 2 Data and commands 3 As 2 plus connection status 4 Low-level data output.', '', '0', '0', '0', '0');


CREATE TABLE `sxb_admin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL DEFAULT '' COMMENT '登录名',
  `password` varchar(32) NOT NULL DEFAULT '' COMMENT '密码',
  `realname` varchar(20) NOT NULL DEFAULT '',
  `email` varchar(100) NOT NULL DEFAULT '',
  `logintime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '登录时间',
  `loginip` varchar(30) NOT NULL DEFAULT '' COMMENT '登录IP',
  `islock` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '锁定状态',
  `createtime` int(10) NOT NULL DEFAULT '0' COMMENT '管理员创建时间',
  PRIMARY KEY (`id`)
)