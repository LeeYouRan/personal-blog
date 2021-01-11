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

 Date: 09/01/2021 08:22:05
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for wp_al_urls_index
-- ----------------------------
DROP TABLE IF EXISTS `wp_al_urls_index`;
CREATE TABLE `wp_al_urls_index`  (
  `al_index_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `al_url_id` mediumint(8) NOT NULL,
  `al_post_id` mediumint(8) NOT NULL,
  `al_comm_id` mediumint(8) NOT NULL DEFAULT 0,
  PRIMARY KEY (`al_index_id`) USING BTREE,
  INDEX `al_url_id`(`al_url_id`) USING BTREE,
  INDEX `al_post_id`(`al_post_id`) USING BTREE,
  INDEX `al_comm_id`(`al_comm_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 143 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of wp_al_urls_index
-- ----------------------------
INSERT INTO `wp_al_urls_index` VALUES (2, 2, 6986, 0);
INSERT INTO `wp_al_urls_index` VALUES (3, 3, 6986, 0);
INSERT INTO `wp_al_urls_index` VALUES (4, 4, 7391, 0);
INSERT INTO `wp_al_urls_index` VALUES (5, 5, 7391, 0);
INSERT INTO `wp_al_urls_index` VALUES (6, 6, 7391, 0);
INSERT INTO `wp_al_urls_index` VALUES (7, 7, 7391, 0);
INSERT INTO `wp_al_urls_index` VALUES (8, 8, 7391, 0);
INSERT INTO `wp_al_urls_index` VALUES (9, 9, 7391, 0);
INSERT INTO `wp_al_urls_index` VALUES (10, 10, 7391, 0);
INSERT INTO `wp_al_urls_index` VALUES (11, 11, 7568, 0);
INSERT INTO `wp_al_urls_index` VALUES (12, 12, 7568, 0);
INSERT INTO `wp_al_urls_index` VALUES (13, 13, 7628, 0);
INSERT INTO `wp_al_urls_index` VALUES (14, 14, 6297, 0);
INSERT INTO `wp_al_urls_index` VALUES (15, 15, 6297, 0);
INSERT INTO `wp_al_urls_index` VALUES (16, 16, 6297, 0);
INSERT INTO `wp_al_urls_index` VALUES (17, 17, 6297, 0);
INSERT INTO `wp_al_urls_index` VALUES (18, 18, 4022, 0);
INSERT INTO `wp_al_urls_index` VALUES (19, 19, 4022, 0);
INSERT INTO `wp_al_urls_index` VALUES (20, 20, 4022, 0);
INSERT INTO `wp_al_urls_index` VALUES (21, 21, 4022, 0);
INSERT INTO `wp_al_urls_index` VALUES (22, 22, 4022, 0);
INSERT INTO `wp_al_urls_index` VALUES (23, 23, 7682, 0);
INSERT INTO `wp_al_urls_index` VALUES (24, 24, 7682, 0);
INSERT INTO `wp_al_urls_index` VALUES (25, 25, 7682, 0);
INSERT INTO `wp_al_urls_index` VALUES (26, 26, 7682, 0);
INSERT INTO `wp_al_urls_index` VALUES (27, 27, 7682, 0);
INSERT INTO `wp_al_urls_index` VALUES (28, 28, 7682, 0);
INSERT INTO `wp_al_urls_index` VALUES (29, 29, 7682, 0);
INSERT INTO `wp_al_urls_index` VALUES (30, 30, 8157, 0);
INSERT INTO `wp_al_urls_index` VALUES (31, 31, 8157, 0);
INSERT INTO `wp_al_urls_index` VALUES (32, 32, 8157, 0);
INSERT INTO `wp_al_urls_index` VALUES (33, 33, 8157, 0);
INSERT INTO `wp_al_urls_index` VALUES (34, 34, 8157, 0);
INSERT INTO `wp_al_urls_index` VALUES (35, 35, 8241, 0);
INSERT INTO `wp_al_urls_index` VALUES (36, 36, 8241, 0);
INSERT INTO `wp_al_urls_index` VALUES (37, 37, 8241, 0);
INSERT INTO `wp_al_urls_index` VALUES (38, 38, 8241, 0);
INSERT INTO `wp_al_urls_index` VALUES (39, 39, 8378, 0);
INSERT INTO `wp_al_urls_index` VALUES (40, 40, 8378, 0);
INSERT INTO `wp_al_urls_index` VALUES (41, 41, 8378, 0);
INSERT INTO `wp_al_urls_index` VALUES (42, 42, 8378, 0);
INSERT INTO `wp_al_urls_index` VALUES (43, 39, 8570, 0);
INSERT INTO `wp_al_urls_index` VALUES (44, 40, 8570, 0);
INSERT INTO `wp_al_urls_index` VALUES (45, 41, 8570, 0);
INSERT INTO `wp_al_urls_index` VALUES (46, 42, 8570, 0);
INSERT INTO `wp_al_urls_index` VALUES (47, 43, 8642, 0);
INSERT INTO `wp_al_urls_index` VALUES (48, 44, 3478, 0);
INSERT INTO `wp_al_urls_index` VALUES (49, 45, 8662, 0);
INSERT INTO `wp_al_urls_index` VALUES (50, 46, 8662, 0);
INSERT INTO `wp_al_urls_index` VALUES (51, 47, 8662, 0);
INSERT INTO `wp_al_urls_index` VALUES (52, 48, 4777, 1);
INSERT INTO `wp_al_urls_index` VALUES (53, 49, 8689, 0);
INSERT INTO `wp_al_urls_index` VALUES (54, 50, 8689, 0);
INSERT INTO `wp_al_urls_index` VALUES (55, 51, 8689, 0);
INSERT INTO `wp_al_urls_index` VALUES (62, 58, 8689, 0);
INSERT INTO `wp_al_urls_index` VALUES (63, 59, 8689, 0);
INSERT INTO `wp_al_urls_index` VALUES (64, 60, 8689, 0);
INSERT INTO `wp_al_urls_index` VALUES (65, 61, 8689, 0);
INSERT INTO `wp_al_urls_index` VALUES (66, 62, 8689, 0);
INSERT INTO `wp_al_urls_index` VALUES (67, 63, 8689, 0);
INSERT INTO `wp_al_urls_index` VALUES (68, 64, 8689, 0);
INSERT INTO `wp_al_urls_index` VALUES (69, 65, 8689, 0);
INSERT INTO `wp_al_urls_index` VALUES (70, 66, 8689, 0);
INSERT INTO `wp_al_urls_index` VALUES (71, 67, 8689, 0);
INSERT INTO `wp_al_urls_index` VALUES (72, 68, 8689, 0);
INSERT INTO `wp_al_urls_index` VALUES (73, 69, 8689, 0);
INSERT INTO `wp_al_urls_index` VALUES (74, 70, 8689, 0);
INSERT INTO `wp_al_urls_index` VALUES (75, 71, 8689, 0);
INSERT INTO `wp_al_urls_index` VALUES (76, 72, 8689, 0);
INSERT INTO `wp_al_urls_index` VALUES (78, 74, 8689, 0);
INSERT INTO `wp_al_urls_index` VALUES (79, 75, 8689, 0);
INSERT INTO `wp_al_urls_index` VALUES (80, 76, 8737, 0);
INSERT INTO `wp_al_urls_index` VALUES (81, 77, 8739, 0);
INSERT INTO `wp_al_urls_index` VALUES (82, 78, 8739, 0);
INSERT INTO `wp_al_urls_index` VALUES (83, 79, 8739, 0);
INSERT INTO `wp_al_urls_index` VALUES (84, 80, 8739, 0);
INSERT INTO `wp_al_urls_index` VALUES (85, 81, 8739, 0);
INSERT INTO `wp_al_urls_index` VALUES (86, 82, 8739, 0);
INSERT INTO `wp_al_urls_index` VALUES (87, 83, 8739, 0);
INSERT INTO `wp_al_urls_index` VALUES (88, 84, 8739, 0);
INSERT INTO `wp_al_urls_index` VALUES (89, 85, 8739, 0);
INSERT INTO `wp_al_urls_index` VALUES (90, 86, 8739, 0);
INSERT INTO `wp_al_urls_index` VALUES (91, 87, 8739, 0);
INSERT INTO `wp_al_urls_index` VALUES (92, 88, 8739, 0);
INSERT INTO `wp_al_urls_index` VALUES (93, 89, 8739, 0);
INSERT INTO `wp_al_urls_index` VALUES (94, 90, 8739, 0);
INSERT INTO `wp_al_urls_index` VALUES (95, 91, 8739, 0);
INSERT INTO `wp_al_urls_index` VALUES (96, 92, 8739, 0);
INSERT INTO `wp_al_urls_index` VALUES (97, 93, 8739, 0);
INSERT INTO `wp_al_urls_index` VALUES (98, 94, 8739, 0);
INSERT INTO `wp_al_urls_index` VALUES (99, 95, 8739, 0);
INSERT INTO `wp_al_urls_index` VALUES (100, 96, 8739, 0);
INSERT INTO `wp_al_urls_index` VALUES (101, 97, 8739, 0);
INSERT INTO `wp_al_urls_index` VALUES (102, 98, 8739, 0);
INSERT INTO `wp_al_urls_index` VALUES (103, 99, 8739, 0);
INSERT INTO `wp_al_urls_index` VALUES (104, 100, 8739, 0);
INSERT INTO `wp_al_urls_index` VALUES (105, 101, 8739, 0);
INSERT INTO `wp_al_urls_index` VALUES (106, 102, 8739, 0);
INSERT INTO `wp_al_urls_index` VALUES (107, 103, 8739, 0);
INSERT INTO `wp_al_urls_index` VALUES (108, 104, 8739, 0);
INSERT INTO `wp_al_urls_index` VALUES (109, 105, 8739, 0);
INSERT INTO `wp_al_urls_index` VALUES (110, 106, 8739, 0);
INSERT INTO `wp_al_urls_index` VALUES (111, 107, 8739, 0);
INSERT INTO `wp_al_urls_index` VALUES (112, 108, 8739, 0);
INSERT INTO `wp_al_urls_index` VALUES (113, 109, 8739, 0);
INSERT INTO `wp_al_urls_index` VALUES (114, 110, 8739, 0);
INSERT INTO `wp_al_urls_index` VALUES (115, 111, 8739, 0);
INSERT INTO `wp_al_urls_index` VALUES (116, 112, 8739, 0);
INSERT INTO `wp_al_urls_index` VALUES (117, 113, 8739, 0);
INSERT INTO `wp_al_urls_index` VALUES (118, 114, 8739, 0);
INSERT INTO `wp_al_urls_index` VALUES (119, 115, 8739, 0);
INSERT INTO `wp_al_urls_index` VALUES (120, 116, 8759, 0);
INSERT INTO `wp_al_urls_index` VALUES (121, 117, 8759, 0);
INSERT INTO `wp_al_urls_index` VALUES (122, 118, 8759, 0);
INSERT INTO `wp_al_urls_index` VALUES (123, 119, 8759, 0);
INSERT INTO `wp_al_urls_index` VALUES (124, 120, 8759, 0);
INSERT INTO `wp_al_urls_index` VALUES (125, 121, 8759, 0);
INSERT INTO `wp_al_urls_index` VALUES (126, 122, 8759, 0);
INSERT INTO `wp_al_urls_index` VALUES (127, 123, 8759, 0);
INSERT INTO `wp_al_urls_index` VALUES (128, 124, 8759, 0);
INSERT INTO `wp_al_urls_index` VALUES (129, 125, 8759, 0);
INSERT INTO `wp_al_urls_index` VALUES (130, 126, 8759, 0);
INSERT INTO `wp_al_urls_index` VALUES (131, 127, 8759, 0);
INSERT INTO `wp_al_urls_index` VALUES (132, 128, 8759, 0);
INSERT INTO `wp_al_urls_index` VALUES (133, 129, 8764, 0);
INSERT INTO `wp_al_urls_index` VALUES (134, 130, 8764, 0);
INSERT INTO `wp_al_urls_index` VALUES (135, 131, 8764, 0);
INSERT INTO `wp_al_urls_index` VALUES (136, 132, 8764, 0);
INSERT INTO `wp_al_urls_index` VALUES (137, 133, 8764, 0);
INSERT INTO `wp_al_urls_index` VALUES (138, 134, 8764, 0);
INSERT INTO `wp_al_urls_index` VALUES (139, 135, 8764, 0);
INSERT INTO `wp_al_urls_index` VALUES (140, 136, 8764, 0);
INSERT INTO `wp_al_urls_index` VALUES (141, 137, 8764, 0);
INSERT INTO `wp_al_urls_index` VALUES (142, 138, 8764, 0);

SET FOREIGN_KEY_CHECKS = 1;
