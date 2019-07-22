/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50726
Source Host           : localhost:3306
Source Database       : store

Target Server Type    : MYSQL
Target Server Version : 50726
File Encoding         : 65001

Date: 2019-07-21 22:55:23
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `base_admin`
-- ----------------------------
DROP TABLE IF EXISTS `base_admin`;
CREATE TABLE `base_admin` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(60) DEFAULT NULL COMMENT '名称',
  `account` varchar(60) DEFAULT ' ' COMMENT '账号',
  `password` varchar(60) DEFAULT ' ' COMMENT '账号',
  `email` varchar(60) DEFAULT ' ' COMMENT '邮箱',
  `status` tinyint(1) DEFAULT '0' COMMENT '0启用  1禁用',
  `role_id` int(11) DEFAULT '0' COMMENT '角色id',
  `create_time` datetime DEFAULT NULL COMMENT '添加时间',
  `update_time` datetime DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=58 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of base_admin
-- ----------------------------
INSERT INTO `base_admin` VALUES ('1', 'admin', 'admin', 'e10adc3949ba59abbe56e057f20f883e', '1160121683@qq.com', '0', '0', '2019-07-20 20:13:20', '2019-07-20 20:13:24');
INSERT INTO `base_admin` VALUES ('46', 'test', 'test', 'e10adc3949ba59abbe56e057f20f883e', ' 1160121683@qq.com', '0', '57', '2019-07-20 20:13:15', '2019-07-20 20:13:18');
INSERT INTO `base_admin` VALUES ('50', null, '55', 'b53b3a3d6ab90ce0268229151c9bde11', '55@qq.com', '0', '57', '2019-07-20 23:01:08', '2019-07-20 23:01:08');
INSERT INTO `base_admin` VALUES ('51', null, '66', '3295c76acbf4caaed33c36b1b5fc2cb1', '66@qq.com', '0', '57', '2019-07-20 23:01:30', '2019-07-20 23:01:30');
INSERT INTO `base_admin` VALUES ('52', null, '66', 'fae0b27c451c728867a567e8c1bb4e53', '666@qq.com', '0', '57', '2019-07-20 23:02:45', '2019-07-20 23:02:45');
INSERT INTO `base_admin` VALUES ('53', null, '55555', 'b53b3a3d6ab90ce0268229151c9bde11', '5@qq.com', '0', '57', '2019-07-20 23:03:39', '2019-07-20 23:03:39');
INSERT INTO `base_admin` VALUES ('54', null, '333', '182be0c5cdcd5072bb1864cdee4d3d6e', '33@qq.com', '0', '57', '2019-07-20 23:07:38', '2019-07-20 23:07:38');
INSERT INTO `base_admin` VALUES ('55', null, '33', '182be0c5cdcd5072bb1864cdee4d3d6e', '33@qq.com', '0', '57', '2019-07-20 23:14:08', '2019-07-20 23:14:08');
INSERT INTO `base_admin` VALUES ('56', null, '44', 'b53b3a3d6ab90ce0268229151c9bde11', '33@qq.com', '0', '57', '2019-07-20 23:18:17', '2019-07-20 23:18:17');
INSERT INTO `base_admin` VALUES ('57', null, '66', '3295c76acbf4caaed33c36b1b5fc2cb1', '66@qq.com', '0', '57', '2019-07-20 23:19:12', '2019-07-20 23:19:12');

-- ----------------------------
-- Table structure for `base_auth`
-- ----------------------------
DROP TABLE IF EXISTS `base_auth`;
CREATE TABLE `base_auth` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(60) CHARACTER SET utf8mb4 NOT NULL COMMENT '权限名称',
  `icon` varchar(60) CHARACTER SET utf8mb4 NOT NULL COMMENT '图标',
  `path` varchar(60) CHARACTER SET utf8mb4 NOT NULL COMMENT '权限路径',
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '父id',
  `level` tinyint(1) NOT NULL DEFAULT '0' COMMENT '等级',
  `create_time` datetime DEFAULT NULL COMMENT '添加时间',
  `update_time` datetime DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of base_auth
-- ----------------------------
INSERT INTO `base_auth` VALUES ('2', '管理员列表', ' ', 'admin/admin/index', '1', '1', '2019-07-18 21:03:20', '2019-07-18 21:03:23');
INSERT INTO `base_auth` VALUES ('3', '添加管理员', ' fa-address-card', 'admin/admin/add', '2', '2', '2019-07-18 21:04:15', '2019-07-18 21:04:21');
INSERT INTO `base_auth` VALUES ('4', '编辑管理员', ' 1', 'admin/admin/edit', '2', '2', '2019-07-18 21:04:54', '2019-07-18 21:04:59');
INSERT INTO `base_auth` VALUES ('5', '删除管理员', ' ', 'admin/admin/delete', '2', '2', '2019-07-18 21:05:32', '2019-07-18 21:05:39');
INSERT INTO `base_auth` VALUES ('1', '权限管理', ' ', ' ', '0', '0', '2019-07-18 21:08:50', '2019-07-18 21:08:53');
INSERT INTO `base_auth` VALUES ('9', '权限列表', ' ', 'admin/auth/index', '1', '1', '2019-07-19 10:33:14', '2019-07-19 10:33:18');
INSERT INTO `base_auth` VALUES ('10', '添加权限', ' ', 'admin/auth/add', '9', '2', '2019-07-19 10:34:29', '2019-07-19 10:34:31');
INSERT INTO `base_auth` VALUES ('11', '编辑权限', ' ', 'admin/auth/edit', '9', '2', '2019-07-19 10:35:28', '2019-07-19 10:35:32');
INSERT INTO `base_auth` VALUES ('12', '删除权限', ' ', 'admin/auth/delete', '9', '2', '2019-07-19 10:36:00', '2019-07-19 10:36:03');
INSERT INTO `base_auth` VALUES ('13', '角色列表', ' ', 'admin/role/index', '1', '1', '2019-07-19 10:36:52', '2019-07-19 10:36:55');
INSERT INTO `base_auth` VALUES ('14', '添加角色', ' ', 'admin/role/add', '13', '2', '2019-07-19 10:37:29', '2019-07-19 10:37:32');
INSERT INTO `base_auth` VALUES ('15', '编辑角色', ' ', 'admin/role/edit', '13', '2', '2019-07-19 10:37:59', '2019-07-19 10:38:02');
INSERT INTO `base_auth` VALUES ('16', '删除角色', ' ', 'admin/role/delete', '13', '2', '2019-07-19 10:38:34', '2019-07-19 10:38:36');
INSERT INTO `base_auth` VALUES ('21', '系统管理', 'e', 'admin/base/index', '0', '0', null, null);
INSERT INTO `base_auth` VALUES ('22', '测试', '2', 'admin/base/index', '21', '1', null, null);
INSERT INTO `base_auth` VALUES ('23', '查看管理员', '', 'admin/admin/data', '2', '2', '2019-07-20 21:11:26', '2019-07-20 21:11:26');

-- ----------------------------
-- Table structure for `base_role`
-- ----------------------------
DROP TABLE IF EXISTS `base_role`;
CREATE TABLE `base_role` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `name` varchar(60) CHARACTER SET utf8mb4 NOT NULL COMMENT '角色名称',
  `create_time` datetime DEFAULT NULL COMMENT '添加时间',
  `update_time` datetime DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=58 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of base_role
-- ----------------------------
INSERT INTO `base_role` VALUES ('57', '管理员', null, null);

-- ----------------------------
-- Table structure for `base_role_admin`
-- ----------------------------
DROP TABLE IF EXISTS `base_role_admin`;
CREATE TABLE `base_role_admin` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `admin_id` int(11) NOT NULL DEFAULT '0' COMMENT '管理员id',
  `role_id` int(11) NOT NULL DEFAULT '0' COMMENT '角色id',
  `create_time` datetime NOT NULL COMMENT '添加时间',
  `update_time` datetime NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of base_role_admin
-- ----------------------------

-- ----------------------------
-- Table structure for `base_role_auth`
-- ----------------------------
DROP TABLE IF EXISTS `base_role_auth`;
CREATE TABLE `base_role_auth` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `auth_id` int(11) NOT NULL DEFAULT '0' COMMENT '权限id',
  `role_id` int(11) NOT NULL DEFAULT '0' COMMENT '角色id',
  `create_time` datetime DEFAULT NULL COMMENT '添加时间',
  `update_time` datetime DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=485 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of base_role_auth
-- ----------------------------
INSERT INTO `base_role_auth` VALUES ('484', '16', '57', '2019-07-20 21:12:08', '2019-07-20 21:12:08');
INSERT INTO `base_role_auth` VALUES ('483', '15', '57', '2019-07-20 21:12:08', '2019-07-20 21:12:08');
INSERT INTO `base_role_auth` VALUES ('482', '14', '57', '2019-07-20 21:12:08', '2019-07-20 21:12:08');
INSERT INTO `base_role_auth` VALUES ('481', '13', '57', '2019-07-20 21:12:08', '2019-07-20 21:12:08');
INSERT INTO `base_role_auth` VALUES ('480', '23', '57', '2019-07-20 21:12:08', '2019-07-20 21:12:08');
INSERT INTO `base_role_auth` VALUES ('479', '4', '57', '2019-07-20 21:12:08', '2019-07-20 21:12:08');
INSERT INTO `base_role_auth` VALUES ('478', '2', '57', '2019-07-20 21:12:08', '2019-07-20 21:12:08');
INSERT INTO `base_role_auth` VALUES ('477', '1', '57', '2019-07-20 21:12:08', '2019-07-20 21:12:08');
