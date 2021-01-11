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

 Date: 09/01/2021 08:22:25
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for wp_iqblock_logging
-- ----------------------------
DROP TABLE IF EXISTS `wp_iqblock_logging`;
CREATE TABLE `wp_iqblock_logging`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `datetime` datetime NOT NULL,
  `ipaddress` tinytext CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `country` tinytext CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `url` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '/',
  `banned` enum('F','B','A','T') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  UNIQUE INDEX `id`(`id`) USING BTREE,
  INDEX `datetime`(`datetime`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 679 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of wp_iqblock_logging
-- ----------------------------
INSERT INTO `wp_iqblock_logging` VALUES (462, '2020-08-24 07:54:22', '39.99.160.90', 'CN', '/data/admin/allowurl.txt', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (463, '2020-08-24 10:59:03', '1.202.147.138', 'CN', '/favicon.ico', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (464, '2020-08-24 10:59:07', '1.202.147.138', 'CN', '/php7/', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (465, '2020-08-24 14:01:45', '61.148.16.170', 'CN', '/favicon.ico', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (466, '2020-08-24 14:01:51', '180.163.220.4', 'CN', '/', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (467, '2020-08-24 14:01:58', '42.236.10.117', 'CN', '/tp-3-2-%EF%BC%88%E4%B8%80%EF%BC%89%E9%85%8D%E7%BD%AE%E3%80%81%E8%B7%AF%E7%94%B1%E3%80%81%E6%A8%A1%E5%9E%8B%E3%80%81%E8%A7%86%E5%9B%BE%E3%80%81%E6%8E%A7%E5%88%B6%E5%99%A8%E3%80%81%E5%95%86%E5%9F%8E', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (468, '2020-08-24 14:02:47', '42.236.10.125', 'CN', '/', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (469, '2020-08-24 14:02:50', '42.236.10.125', 'CN', '/', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (470, '2020-08-24 21:34:27', '175.5.238.253', 'CN', '/favicon.ico', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (471, '2020-08-25 00:36:18', '47.101.72.24', 'CN', '/favicon.ico', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (472, '2020-08-25 10:45:15', '164.52.24.162', 'CN', '/', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (473, '2020-08-25 10:45:19', '164.52.24.162', 'CN', '/', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (474, '2020-08-25 12:29:40', '106.75.106.221', 'CN', '/', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (475, '2020-08-25 12:30:24', '106.75.85.103', 'CN', '/', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (476, '2020-08-25 19:09:06', '124.160.43.82', 'CN', '/favicon.ico', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (477, '2020-08-25 19:09:11', '124.160.43.82', 'CN', '/favicon.ico', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (478, '2020-08-25 19:09:16', '124.160.43.82', 'CN', '/favicon.ico', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (479, '2020-08-25 19:09:19', '124.160.43.82', 'CN', '/%E7%BD%91%E7%AB%99%E4%BC%98%E5%8C%96%EF%BC%88%E4%BA%8C%EF%BC%89mysql-%E4%BC%98%E5%8C%96-%E5%8D%83%E4%B8%87%E7%BA%A7%E6%95%B0%E6%8D%AE%E3%80%81%E7%B4%A2%E5%BC%95%E3%80%81%E5%AD%98%E5%82%A8%E8%BF%87/', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (480, '2020-08-25 23:28:00', '47.103.87.199', 'CN', '/favicon.ico', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (481, '2020-08-26 10:59:16', '47.240.116.135', 'HK', '/favicon.ico', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (482, '2020-08-26 10:59:18', '47.240.116.135', 'HK', '/%E7%94%B5%E5%95%86%E9%A1%B9%E7%9B%AE%E9%9D%A2%E8%AF%95%E6%80%BB%E7%BB%93/', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (483, '2020-08-26 22:00:59', '112.96.173.53', 'CN', '/favicon.ico', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (484, '2020-08-26 22:01:03', '112.96.173.53', 'CN', '/tp5-%E5%95%86%E5%9F%8E%EF%BC%88%E4%BA%8C%EF%BC%89rbac%E3%80%81%E6%9D%83%E9%99%90%E5%A2%9E%E5%88%A0%E6%94%B9%E6%9F%A5%E3%80%81%E8%A7%92%E8%89%B2%E5%A2%9E%E5%88%A0%E6%94%B9%E6%9F%A5%E3%80%81%E4%B8%8D/', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (485, '2020-08-27 09:04:14', '116.179.32.171', 'CN', '/', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (486, '2020-08-27 14:50:24', '222.92.146.110', 'CN', '/favicon.ico', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (487, '2020-08-27 14:50:27', '222.92.146.110', 'CN', '/?p=4921', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (488, '2020-08-27 14:50:57', '42.236.10.125', 'CN', '/', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (489, '2020-08-28 04:07:43', '39.99.160.90', 'CN', '/robots.txt', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (490, '2020-08-28 04:52:52', '39.101.65.235', 'CN', '/robots.txt', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (491, '2020-08-28 05:35:55', '42.236.10.117', 'CN', '/', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (492, '2020-08-28 09:32:52', '42.236.10.78', 'CN', '/', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (493, '2020-08-28 10:30:55', '119.123.77.196', 'CN', '/favicon.ico', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (494, '2020-08-28 10:30:59', '119.123.77.196', 'CN', '/%E7%94%B5%E5%95%86%E9%A1%B9%E7%9B%AE%E9%9D%A2%E8%AF%95%E6%80%BB%E7%BB%93/', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (495, '2020-08-28 11:43:41', '175.5.239.80', 'CN', '/favicon.ico', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (496, '2020-08-28 14:26:41', '43.242.140.69', 'HK', '/favicon.ico', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (497, '2020-08-29 16:40:28', '116.179.32.19', 'CN', '/', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (498, '2020-08-29 18:44:50', '39.101.65.235', 'CN', '/xxsssseee', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (499, '2020-08-29 18:48:52', '39.101.1.61', 'CN', '/data/admin/allowurl.txt', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (500, '2020-08-29 19:49:02', '116.179.32.222', 'CN', '/', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (501, '2020-08-29 22:34:47', '36.148.84.236', 'CN', '/favicon.ico', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (502, '2020-08-29 22:34:51', '36.148.84.236', 'CN', '/classify/%E5%90%8E%E5%8F%B0%E6%A1%86%E6%9E%B6/laravel/laravel%E5%9C%A8%E7%BA%BF%E6%95%99%E8%82%B2%E5%B9%B3%E5%8F%B0/', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (503, '2020-08-30 01:07:56', '116.179.32.87', 'CN', '/', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (504, '2020-08-30 03:04:39', '106.38.241.106', 'CN', '/tp5-%E5%95%86%E5%9F%8E%EF%BC%88%E4%B8%89%EF%BC%89%E8%B4%A6%E6%88%B7%E7%8A%B6%E6%80%81%E6%9D%83%E9%99%90%E6%8E%A7%E5%88%B6%E3%80%81%E5%95%86%E5%93%81%E7%B1%BB%E5%9E%8B-curd%E3%80%81%E5%95%86%E5%93%81/', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (505, '2020-08-30 17:49:24', '115.60.63.255', 'CN', '/favicon.ico', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (506, '2020-08-30 17:49:28', '115.60.63.255', 'CN', '/?p=3437', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (507, '2020-08-30 23:19:04', '110.191.241.223', 'CN', '/favicon.ico', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (508, '2020-08-30 23:19:07', '110.191.241.223', 'CN', '/%E6%89%8B%E6%9C%BA%E7%9B%B4%E6%92%AD-%E6%90%AD%E5%BB%BA%E6%9C%8D%E5%8A%A1%E5%99%A8%E3%80%81%E6%8E%A8%E6%B5%81%E7%AE%A1%E7%90%86%E3%80%81%E5%AE%9E%E7%8E%B0%E7%9B%B4%E6%92%AD%E3%80%81%E5%88%9B%E5%BB%BA/', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (509, '2020-08-31 10:10:47', '117.143.58.42', 'CN', '/favicon.ico', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (510, '2020-08-31 10:10:51', '117.143.58.42', 'CN', '/tp5%E5%95%86%E5%9F%8E%EF%BC%88%E5%85%AB%EF%BC%89%E8%B4%AD%E7%89%A9%E8%BD%A6%E5%95%86%E5%93%81%E5%88%97%E8%A1%A8%E5%B1%95%E7%A4%BA%E3%80%81ajax%E5%88%A0%E9%99%A4%E3%80%81%E6%B8%85%E7%A9%BA%E3%80%81/', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (511, '2020-08-31 15:33:26', '140.240.20.248', 'CN', '/favicon.ico', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (512, '2020-08-31 16:32:01', '113.66.216.13', 'CN', '/favicon.ico', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (513, '2020-08-31 16:32:05', '113.66.216.13', 'CN', '/favicon.ico', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (514, '2020-08-31 16:32:12', '113.66.216.13', 'CN', '/favicon.ico', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (515, '2020-08-31 17:22:32', '42.3.19.163', 'HK', '/favicon.ico', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (516, '2020-08-31 17:22:36', '42.3.19.163', 'HK', '/%E7%94%B5%E5%95%86%E9%A1%B9%E7%9B%AE%E9%9D%A2%E8%AF%95%E6%80%BB%E7%BB%93/', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (517, '2020-08-31 17:22:46', '42.3.19.163', 'HK', '/%E7%94%B5%E5%95%86%E9%A1%B9%E7%9B%AE%E9%9D%A2%E8%AF%95%E6%80%BB%E7%BB%93/', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (518, '2020-08-31 17:22:48', '42.3.19.163', 'HK', '/%E7%94%B5%E5%95%86%E9%A1%B9%E7%9B%AE%E9%9D%A2%E8%AF%95%E6%80%BB%E7%BB%93/', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (519, '2020-08-31 21:18:42', '114.231.110.223', 'CN', '/favicon.ico', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (520, '2020-08-31 21:18:45', '114.231.110.223', 'CN', '/yaf%E6%A1%86%E6%9E%B6/', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (521, '2020-08-31 21:25:20', '219.140.112.32', 'CN', '/favicon.ico', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (522, '2020-09-01 02:08:29', '42.236.10.117', 'CN', '/', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (523, '2020-09-01 11:51:36', '183.56.165.203', 'CN', '/cgi-bin/login.cgi?requestname=2&amp;cmd=0', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (524, '2020-09-01 13:20:51', '220.181.108.92', 'CN', '/', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (525, '2020-09-01 13:54:11', '116.179.32.160', 'CN', '/', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (526, '2020-09-01 17:41:01', '180.168.121.252', 'CN', '/favicon.ico', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (527, '2020-09-01 17:41:05', '180.168.121.252', 'CN', '/%E7%94%B5%E5%95%86%E9%A1%B9%E7%9B%AE%E9%9D%A2%E8%AF%95%E6%80%BB%E7%BB%93/', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (528, '2020-09-01 20:37:02', '144.123.93.119', 'CN', '/favicon.ico', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (529, '2020-09-02 00:11:26', '42.236.10.84', 'CN', '/yaf%BF%F2%BC%DC', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (530, '2020-09-02 07:03:06', '42.236.10.114', 'CN', '/', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (531, '2020-09-02 07:04:00', '42.236.10.75', 'CN', '/', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (532, '2020-09-02 19:27:03', '119.118.10.113', 'CN', '/', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (533, '2020-09-03 03:19:47', '52.80.152.21', 'CN', '/', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (534, '2020-09-03 03:19:49', '52.80.152.21', 'CN', '/favicon.ico', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (535, '2020-09-03 04:50:35', '114.67.87.60', 'CN', '/', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (536, '2020-09-03 15:03:34', '42.236.10.84', 'CN', '/', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (537, '2020-09-03 15:07:36', '42.236.10.117', 'CN', '/tp5-%E5%95%86%E5%9F%8E%EF%BC%88%E4%B8%80%EF%BC%89%E7%8E%AF%E5%A2%83%E9%83%A8%E7%BD%B2%E3%80%81%E6%95%B0%E6%8D%AE%E8%A1%A8%E3%80%81%E5%90%8E%E5%8F%B0%E9%A6%96%E9%A1%B5%E3%80%81%E7%94%A8%E6%88%B7-curd', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (538, '2020-09-03 15:08:27', '180.163.220.4', 'CN', '/', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (539, '2020-09-03 22:50:07', '113.31.115.156', 'CN', '/', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (540, '2020-09-03 22:50:07', '113.31.115.156', 'CN', '/', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (541, '2020-09-03 22:50:11', '113.31.115.156', 'CN', '/', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (542, '2020-09-03 22:50:14', '113.31.115.156', 'CN', '/', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (543, '2020-09-03 23:10:20', '42.3.109.154', 'HK', '/favicon.ico', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (544, '2020-09-03 23:10:25', '42.3.109.154', 'HK', '/favicon.ico', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (545, '2020-09-03 23:10:29', '42.3.109.154', 'HK', '/yaf%E6%A1%86%E6%9E%B6/', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (546, '2020-09-04 13:43:15', '175.5.243.139', 'CN', '/favicon.ico', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (547, '2020-09-04 15:42:49', '103.37.140.36', 'CN', '/favicon.ico', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (548, '2020-09-04 15:42:53', '103.37.140.36', 'CN', '/js%E9%AB%98%E7%BA%A7%EF%BC%88%E4%B8%80%EF%BC%89%E6%AD%A3%E5%88%99%E3%80%81%E5%88%86%E7%BB%84%E3%80%81%E6%8D%95%E8%8E%B7%E3%80%81%E5%8F%8D%E5%90%91%E5%BC%95%E7%94%A8%E3%80%81%E5%8C%B9%E9%85%8D%E3%80%81/', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (549, '2020-09-04 17:55:47', '101.95.128.162', 'CN', '/favicon.ico', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (550, '2020-09-04 17:55:51', '101.95.128.162', 'CN', '/js%E9%AB%98%E7%BA%A7%EF%BC%88%E4%B8%80%EF%BC%89%E6%AD%A3%E5%88%99%E3%80%81%E5%88%86%E7%BB%84%E3%80%81%E6%8D%95%E8%8E%B7%E3%80%81%E5%8F%8D%E5%90%91%E5%BC%95%E7%94%A8%E3%80%81%E5%8C%B9%E9%85%8D%E3%80%81/', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (551, '2020-09-05 03:28:04', '164.52.24.162', 'CN', '/', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (552, '2020-09-05 03:28:08', '164.52.24.162', 'CN', '/', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (553, '2020-09-05 08:13:01', '114.88.195.155', 'CN', '/favicon.ico', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (554, '2020-09-05 08:13:07', '114.88.195.155', 'CN', '/favicon.ico', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (555, '2020-09-05 08:13:28', '114.88.195.155', 'CN', '/', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (556, '2020-09-05 09:03:59', '39.101.65.235', 'CN', '/index.php?m=admin&amp;c=index&amp;a=login&amp;dosubmit=1', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (557, '2020-09-05 11:04:58', '36.32.3.151', 'CN', '/', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (558, '2020-09-05 23:57:01', '220.181.51.112', 'CN', '/robots.txt', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (559, '2020-09-05 23:58:25', '116.179.32.88', 'CN', '/', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (560, '2020-09-06 09:54:25', '116.179.32.26', 'CN', '/', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (561, '2020-09-06 16:16:18', '113.31.115.156', 'CN', '/', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (562, '2020-09-06 16:16:18', '113.31.115.156', 'CN', '/', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (563, '2020-09-06 16:16:20', '113.31.115.156', 'CN', '/', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (564, '2020-09-06 16:16:21', '113.31.115.156', 'CN', '/', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (565, '2020-09-06 20:55:52', '183.56.165.203', 'CN', '/cgi-bin/login.cgi?requestname=2&amp;cmd=0', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (566, '2020-09-08 07:01:10', '42.236.10.84', 'CN', '/', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (567, '2020-09-08 11:55:46', '27.46.106.151', 'CN', '/favicon.ico', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (568, '2020-09-08 11:55:50', '27.46.106.151', 'CN', '/%E7%94%B5%E5%95%86%E9%A1%B9%E7%9B%AE%E9%9D%A2%E8%AF%95%E6%80%BB%E7%BB%93/', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (569, '2020-09-08 17:25:29', '116.179.32.29', 'CN', '/', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (570, '2020-09-08 17:25:43', '118.112.72.251', 'CN', '/favicon.ico', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (571, '2020-09-08 17:25:48', '118.112.72.251', 'CN', '/favicon.ico', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (572, '2020-09-08 17:25:54', '118.112.72.251', 'CN', '/favicon.ico', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (573, '2020-09-08 17:26:06', '180.163.220.4', 'CN', '/', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (574, '2020-09-08 17:26:09', '42.236.10.114', 'CN', '/yaf%E6%A1%86%E6%9E%B6', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (575, '2020-09-08 17:26:12', '42.236.10.114', 'CN', '/yaf%E6%A1%86%E6%9E%B6', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (576, '2020-09-08 17:26:47', '42.236.10.78', 'CN', '/', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (577, '2020-09-08 17:27:37', '42.236.10.78', 'CN', '/', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (578, '2020-09-08 20:34:14', '116.179.32.156', 'CN', '/', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (579, '2020-09-08 21:27:53', '114.84.166.4', 'CN', '/favicon.ico', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (580, '2020-09-08 21:28:01', '114.84.166.4', 'CN', '/favicon.ico', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (581, '2020-09-08 21:28:12', '114.84.166.4', 'CN', '/favicon.ico', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (582, '2020-09-08 21:28:36', '114.84.166.4', 'CN', '/', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (583, '2020-09-08 21:28:37', '114.84.166.4', 'CN', '/images/wordpress-logo.svg?ver=20131107', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (584, '2020-09-09 09:20:53', '39.101.67.145', 'CN', '/robots.txt', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (585, '2020-09-09 12:24:00', '119.187.113.226', 'CN', '/favicon.ico', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (586, '2020-09-09 22:43:07', '180.163.220.5', 'CN', '/yaf%E6%A1%86%E6%9E%B6', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (587, '2020-09-10 11:16:10', '164.52.24.162', 'CN', '/', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (588, '2020-09-10 11:16:14', '164.52.24.162', 'CN', '/', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (589, '2020-09-10 14:12:46', '103.223.121.4', 'CN', '/favicon.ico', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (590, '2020-09-10 14:13:08', '103.223.121.4', 'CN', '/tp5-%e5%95%86%e5%9f%8e%ef%bc%88%e4%ba%8c%ef%bc%89rbac%e3%80%81%e6%9d%83%e9%99%90%e5%a2%9e%e5%88%a0%e6%94%b9%e6%9f%a5%e3%80%81%e8%a7%92%e8%89%b2%e5%a2%9e%e5%88%a0%e6%94%b9%e6%9f%a5%e3%80%81%e4%b8%8d/', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (591, '2020-09-10 14:13:19', '103.223.121.4', 'CN', '/tp5-%e5%95%86%e5%9f%8e%ef%bc%88%e4%ba%8c%ef%bc%89rbac%e3%80%81%e6%9d%83%e9%99%90%e5%a2%9e%e5%88%a0%e6%94%b9%e6%9f%a5%e3%80%81%e8%a7%92%e8%89%b2%e5%a2%9e%e5%88%a0%e6%94%b9%e6%9f%a5%e3%80%81%e4%b8%8d/', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (592, '2020-09-10 14:13:32', '103.223.121.4', 'CN', '/tp5-%e5%95%86%e5%9f%8e%ef%bc%88%e4%ba%8c%ef%bc%89rbac%e3%80%81%e6%9d%83%e9%99%90%e5%a2%9e%e5%88%a0%e6%94%b9%e6%9f%a5%e3%80%81%e8%a7%92%e8%89%b2%e5%a2%9e%e5%88%a0%e6%94%b9%e6%9f%a5%e3%80%81%e4%b8%8d/', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (593, '2020-09-10 19:26:43', '39.101.67.145', 'CN', '/data/admin/allowurl.txt', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (594, '2020-09-10 21:03:24', '222.209.208.66', 'CN', '/favicon.ico', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (595, '2020-09-10 21:03:30', '222.209.208.66', 'CN', '/favicon.ico', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (596, '2020-09-10 21:03:42', '222.209.208.66', 'CN', '/favicon.ico', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (597, '2020-09-10 21:03:49', '222.209.208.66', 'CN', '/favicon.ico', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (598, '2020-09-11 02:30:07', '39.101.67.145', 'CN', '/xxxss', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (599, '2020-09-11 09:44:11', '47.103.129.217', 'CN', '/favicon.ico', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (600, '2020-09-11 09:47:17', '47.101.11.180', 'CN', '/favicon.ico', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (601, '2020-09-11 09:53:59', '59.41.4.93', 'CN', '/favicon.ico', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (602, '2020-09-11 09:54:05', '59.41.4.93', 'CN', '/php-%E6%A0%B8%E5%BF%83%E7%BC%96%E7%A8%8B%EF%BC%88%E4%BA%94%EF%BC%89gd-%E5%BA%93%E3%80%81-%E5%9B%BE%E7%89%87%E9%A2%9C%E8%89%B2%E5%A1%AB%E5%85%85%E3%80%81-%E6%B0%B4%E5%8D%B0%E3%80%81-%E7%BC%A9%E7%95%A5/', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (603, '2020-09-11 10:54:10', '119.123.199.136', 'CN', '/favicon.ico', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (604, '2020-09-11 10:54:14', '119.123.199.136', 'CN', '/%E6%89%8B%E6%9C%BA%E7%9B%B4%E6%92%AD-%E6%90%AD%E5%BB%BA%E6%9C%8D%E5%8A%A1%E5%99%A8%E3%80%81%E6%8E%A8%E6%B5%81%E7%AE%A1%E7%90%86%E3%80%81%E5%AE%9E%E7%8E%B0%E7%9B%B4%E6%92%AD%E3%80%81%E5%88%9B%E5%BB%BA/', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (605, '2020-09-12 11:06:55', '220.181.108.96', 'CN', '/', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (606, '2020-09-12 13:51:54', '116.233.197.12', 'CN', '/favicon.ico', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (607, '2020-09-12 14:46:22', '116.233.197.12', 'CN', '/favicon.ico', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (608, '2020-09-12 14:46:26', '116.233.197.12', 'CN', '/favicon.ico', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (609, '2020-09-12 14:46:30', '116.233.197.12', 'CN', '/', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (610, '2020-09-12 14:46:49', '116.233.197.12', 'CN', '/images/wordpress-logo.svg?ver=20131107', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (611, '2020-09-13 00:52:37', '39.101.67.145', 'CN', '/data/admin/allowurl.txt', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (612, '2020-09-13 02:27:30', '175.5.242.102', 'CN', '/favicon.ico', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (613, '2020-09-13 02:37:21', '111.30.33.149', 'CN', '/', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (614, '2020-09-13 08:09:18', '116.179.32.202', 'CN', '/', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (615, '2020-09-13 16:12:34', '39.101.67.145', 'CN', '/xxxss', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (616, '2020-09-14 14:08:27', '171.113.151.233', 'CN', '/favicon.ico', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (617, '2020-09-14 19:31:56', '103.218.218.113', 'CN', '/favicon.ico', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (618, '2020-09-14 23:09:07', '113.31.115.156', 'CN', '/', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (619, '2020-09-14 23:09:10', '113.31.115.156', 'CN', '/', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (620, '2020-09-14 23:09:38', '113.31.115.156', 'CN', '/', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (621, '2020-09-15 11:51:48', '218.68.220.252', 'CN', '/favicon.ico', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (622, '2020-09-15 11:51:54', '218.68.220.252', 'CN', '/favicon.ico', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (623, '2020-09-15 12:54:03', '39.101.65.35', 'CN', '/data/admin/allowurl.txt', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (624, '2020-09-15 18:15:52', '164.52.24.162', 'CN', '/', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (625, '2020-09-15 18:15:56', '164.52.24.162', 'CN', '/', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (626, '2020-09-15 19:44:28', '116.179.32.105', 'CN', '/', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (627, '2020-09-16 08:56:57', '103.114.158.1', 'CN', '/favicon.ico', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (628, '2020-09-16 08:57:02', '103.114.158.1', 'CN', '/yaf%E6%A1%86%E6%9E%B6/', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (629, '2020-09-16 12:47:45', '106.38.241.181', 'CN', '/robots.txt', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (630, '2020-09-16 14:45:22', '116.199.28.234', 'CN', '/favicon.ico', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (631, '2020-09-16 14:45:26', '116.199.28.234', 'CN', '/favicon.ico', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (632, '2020-09-16 14:45:26', '116.199.28.234', 'CN', '/%E7%94%B5%E5%95%86%E9%A1%B9%E7%9B%AE%E9%9D%A2%E8%AF%95%E6%80%BB%E7%BB%93/', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (633, '2020-09-16 14:56:09', '114.244.143.202', 'CN', '/favicon.ico', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (634, '2020-09-16 14:56:12', '114.244.143.202', 'CN', '/tp%E5%95%86%E5%9F%8E%EF%BC%88%E4%B8%83%EF%BC%89%E5%95%86%E5%93%81%E8%AF%A6%E6%83%85%E9%A1%B5%E3%80%81%E5%95%86%E5%93%81%E5%9F%BA%E6%9C%AC%E6%95%B0%E6%8D%AE%E3%80%81%E9%9D%A2%E5%8C%85%E5%B1%91%E5%AF%BC/', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (635, '2020-09-16 14:56:19', '114.244.143.202', 'CN', '/tp%E5%95%86%E5%9F%8E%EF%BC%88%E4%B8%83%EF%BC%89%E5%95%86%E5%93%81%E8%AF%A6%E6%83%85%E9%A1%B5%E3%80%81%E5%95%86%E5%93%81%E5%9F%BA%E6%9C%AC%E6%95%B0%E6%8D%AE%E3%80%81%E9%9D%A2%E5%8C%85%E5%B1%91%E5%AF%BC/', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (636, '2020-09-17 09:17:03', '240e:b5:4828:90e6:c59d:2689:b5cf:181', 'CN', '/favicon.ico', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (637, '2020-09-17 09:17:10', '240e:b5:4828:90e6:c59d:2689:b5cf:181', 'CN', '/favicon.ico', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (638, '2020-09-17 09:17:14', '240e:b5:4828:90e6:c59d:2689:b5cf:181', 'CN', '/%E7%94%B5%E5%95%86%E9%A1%B9%E7%9B%AE%E9%9D%A2%E8%AF%95%E6%80%BB%E7%BB%93/', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (639, '2020-09-17 15:36:26', '114.239.124.232', 'CN', '/favicon.ico', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (640, '2020-09-17 23:13:36', '116.179.32.136', 'CN', '/', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (641, '2020-09-17 23:26:51', '39.101.1.61', 'CN', '/robots.txt', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (642, '2020-09-18 00:13:34', '101.133.239.207', 'CN', '/favicon.ico', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (643, '2020-09-18 09:43:57', '101.133.235.11', 'CN', '/favicon.ico', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (644, '2020-09-18 14:36:12', '39.101.1.61', 'CN', '/xxxss', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (645, '2020-09-18 20:51:53', '112.23.84.216', 'CN', '/favicon.ico', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (646, '2020-09-18 20:52:15', '112.23.84.216', 'CN', '/favicon.ico', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (647, '2020-09-19 17:16:59', '115.198.169.54', 'CN', '/favicon.ico', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (648, '2020-09-19 17:17:03', '115.198.169.54', 'CN', '/%E7%94%B5%E5%95%86%E9%A1%B9%E7%9B%AE%E9%9D%A2%E8%AF%95%E6%80%BB%E7%BB%93/', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (649, '2020-09-20 02:04:28', '58.242.194.173', 'CN', '/', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (650, '2020-09-20 04:18:31', '220.181.108.96', 'CN', '/', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (651, '2020-09-20 20:08:24', '220.181.108.157', 'CN', '/', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (652, '2020-09-21 01:16:02', '164.52.24.162', 'CN', '/', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (653, '2020-09-21 01:16:06', '164.52.24.162', 'CN', '/', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (654, '2020-09-21 04:59:45', '113.31.115.156', 'CN', '/', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (655, '2020-09-21 04:59:45', '113.31.115.156', 'CN', '/', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (656, '2020-09-21 05:02:40', '113.31.115.156', 'CN', '/', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (657, '2020-09-21 05:02:40', '113.31.115.156', 'CN', '/', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (658, '2020-09-21 10:59:26', '121.61.17.245', 'CN', '/favicon.ico', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (659, '2020-09-21 10:59:31', '121.61.17.245', 'CN', '/favicon.ico', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (660, '2020-09-21 10:59:33', '121.61.17.245', 'CN', '/favicon.ico', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (661, '2020-09-21 10:59:37', '121.61.17.245', 'CN', '/laravel%E5%9C%A8%E7%BA%BF%E6%95%99%E8%82%B2%E5%B9%B3%E5%8F%B0%EF%BC%88%E5%9B%9B%EF%BC%89%E7%9B%B4%E6%92%AD%E3%80%81%E4%B8%83%E7%89%9B%E4%BA%91%E3%80%81obs%E3%80%81%E7%9B%B4%E6%92%AD%E6%B5%81%E7%AE%A1/', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (662, '2020-09-21 11:22:15', '58.242.194.173', 'CN', '/', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (663, '2020-09-21 18:27:15', '39.101.1.61', 'CN', '/data/admin/allowurl.txt', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (664, '2020-09-21 23:45:45', '210.3.145.194', 'HK', '/favicon.ico', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (665, '2020-09-21 23:45:51', '210.3.145.194', 'HK', '/favicon.ico', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (666, '2020-09-21 23:45:54', '180.163.220.66', 'CN', '/', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (667, '2020-09-21 23:45:55', '180.163.220.66', 'CN', '/laravel%E5%9C%A8%E7%BA%BF%E6%95%99%E8%82%B2%E5%B9%B3%E5%8F%B0%EF%BC%88%E5%85%AD%EF%BC%89%E6%95%B0%E6%8D%AE%E5%AD%97%E5%85%B8%E3%80%81%E6%95%B0%E6%8D%AE%E8%BF%81%E7%A7%BB%E3%80%81%E5%90%8E%E5%8F%B0', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (668, '2020-09-21 23:46:08', '180.163.220.66', 'CN', '/laravel%E5%9C%A8%E7%BA%BF%E6%95%99%E8%82%B2%E5%B9%B3%E5%8F%B0%EF%BC%88%E5%85%AD%EF%BC%89%E6%95%B0%E6%8D%AE%E5%AD%97%E5%85%B8%E3%80%81%E6%95%B0%E6%8D%AE%E8%BF%81%E7%A7%BB%E3%80%81%E5%90%8E%E5%8F%B0', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (669, '2020-09-21 23:46:25', '210.3.145.194', 'HK', '/laravel%E5%9C%A8%E7%BA%BF%E6%95%99%E8%82%B2%E5%B9%B3%E5%8F%B0%EF%BC%88%E5%85%AD%EF%BC%89%E6%95%B0%E6%8D%AE%E5%AD%97%E5%85%B8%E3%80%81%E6%95%B0%E6%8D%AE%E8%BF%81%E7%A7%BB%E3%80%81%E5%90%8E%E5%8F%B0/', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (670, '2020-09-21 23:46:33', '210.3.145.194', 'HK', '/laravel%E5%9C%A8%E7%BA%BF%E6%95%99%E8%82%B2%E5%B9%B3%E5%8F%B0%EF%BC%88%E5%85%AD%EF%BC%89%E6%95%B0%E6%8D%AE%E5%AD%97%E5%85%B8%E3%80%81%E6%95%B0%E6%8D%AE%E8%BF%81%E7%A7%BB%E3%80%81%E5%90%8E%E5%8F%B0/', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (671, '2020-09-21 23:46:40', '210.3.145.194', 'HK', '/laravel%E5%9C%A8%E7%BA%BF%E6%95%99%E8%82%B2%E5%B9%B3%E5%8F%B0%EF%BC%88%E5%85%AD%EF%BC%89%E6%95%B0%E6%8D%AE%E5%AD%97%E5%85%B8%E3%80%81%E6%95%B0%E6%8D%AE%E8%BF%81%E7%A7%BB%E3%80%81%E5%90%8E%E5%8F%B0/', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (672, '2020-09-22 11:07:18', '58.242.194.173', 'CN', '/', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (673, '2020-09-22 13:56:37', '202.82.252.206', 'HK', '/favicon.ico', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (674, '2020-09-22 13:56:40', '202.82.252.206', 'HK', '/js%E9%AB%98%E7%BA%A7%EF%BC%88%E4%B8%80%EF%BC%89%E6%AD%A3%E5%88%99%E3%80%81%E5%88%86%E7%BB%84%E3%80%81%E6%8D%95%E8%8E%B7%E3%80%81%E5%8F%8D%E5%90%91%E5%BC%95%E7%94%A8%E3%80%81%E5%8C%B9%E9%85%8D%E3%80%81/', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (675, '2020-09-22 13:57:17', '202.82.252.206', 'HK', '/js%E9%AB%98%E7%BA%A7%EF%BC%88%E4%B8%80%EF%BC%89%E6%AD%A3%E5%88%99%E3%80%81%E5%88%86%E7%BB%84%E3%80%81%E6%8D%95%E8%8E%B7%E3%80%81%E5%8F%8D%E5%90%91%E5%BC%95%E7%94%A8%E3%80%81%E5%8C%B9%E9%85%8D%E3%80%81/', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (676, '2020-09-22 16:28:04', '116.23.114.7', 'CN', '/favicon.ico', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (677, '2020-09-22 17:17:00', '116.179.32.223', 'CN', '/', 'F');
INSERT INTO `wp_iqblock_logging` VALUES (678, '2020-09-22 18:58:02', '39.101.65.235', 'CN', '/robots.txt', 'F');

SET FOREIGN_KEY_CHECKS = 1;
