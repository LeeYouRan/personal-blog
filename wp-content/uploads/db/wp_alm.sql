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

 Date: 09/01/2021 08:22:10
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for wp_alm
-- ----------------------------
DROP TABLE IF EXISTS `wp_alm`;
CREATE TABLE `wp_alm`  (
  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `name` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `repeaterDefault` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `repeaterType` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `pluginVersion` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  UNIQUE INDEX `id`(`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of wp_alm
-- ----------------------------
INSERT INTO `wp_alm` VALUES (1, 'default', '<li <?php if (!has_post_thumbnail()) { ?> class=\"no-img\"<?php } ?>>\n   <?php if ( has_post_thumbnail() ) { the_post_thumbnail(\'alm-thumbnail\'); }?>\n   <h3><a href=\"<?php the_permalink(); ?>\" title=\"<?php the_title(); ?>\"><?php the_title(); ?></a></h3>\n   <p class=\"entry-meta\"><?php the_time(\"F d, Y\"); ?></p>\n   <?php the_excerpt(); ?>\n</li>', 'default', '3.5.0');

SET FOREIGN_KEY_CHECKS = 1;
