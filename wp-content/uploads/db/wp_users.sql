/*
 Navicat Premium Data Transfer

 Source Server         : Bandwagon
 Source Server Type    : MySQL
 Source Server Version : 50173
 Source Host           : 45.62.124.117:3306
 Source Schema         : blog

 Target Server Type    : MySQL
 Target Server Version : 50173
 File Encoding         : 65001

 Date: 09/01/2021 08:23:23
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for wp_users
-- ----------------------------
DROP TABLE IF EXISTS `wp_users`;
CREATE TABLE `wp_users`  (
  `ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_login` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `user_pass` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `user_nicename` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `user_email` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `user_url` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `user_registered` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user_activation_key` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `user_status` int(11) NOT NULL DEFAULT 0,
  `display_name` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`ID`) USING BTREE,
  INDEX `user_login_key`(`user_login`) USING BTREE,
  INDEX `user_nicename`(`user_nicename`) USING BTREE,
  INDEX `user_email`(`user_email`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of wp_users
-- ----------------------------
INSERT INTO `wp_users` VALUES (1, 'root', '$P$BQAhTvlGJP//N0eXHiW.ja.Bl0sGx7.', 'root', 'liyouran@live.com', 'http://www.liyouran.top', '2018-05-17 13:02:48', '1580443640:$P$BvO68VpfghhGCk/ph30efbZuFyQy5A/', 0, 'Mr.Lee');

SET FOREIGN_KEY_CHECKS = 1;
