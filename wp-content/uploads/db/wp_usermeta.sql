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

 Date: 09/01/2021 08:23:17
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for wp_usermeta
-- ----------------------------
DROP TABLE IF EXISTS `wp_usermeta`;
CREATE TABLE `wp_usermeta`  (
  `umeta_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `meta_key` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `meta_value` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  PRIMARY KEY (`umeta_id`) USING BTREE,
  INDEX `user_id`(`user_id`) USING BTREE,
  INDEX `meta_key`(`meta_key`(191)) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 33 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of wp_usermeta
-- ----------------------------
INSERT INTO `wp_usermeta` VALUES (1, 1, 'nickname', 'Mr.Lee');
INSERT INTO `wp_usermeta` VALUES (2, 1, 'first_name', 'YouRan');
INSERT INTO `wp_usermeta` VALUES (3, 1, 'last_name', 'Lee');
INSERT INTO `wp_usermeta` VALUES (4, 1, 'description', 'I\'m a PHP developer.');
INSERT INTO `wp_usermeta` VALUES (5, 1, 'rich_editing', 'true');
INSERT INTO `wp_usermeta` VALUES (6, 1, 'comment_shortcuts', 'false');
INSERT INTO `wp_usermeta` VALUES (7, 1, 'admin_color', 'fresh');
INSERT INTO `wp_usermeta` VALUES (8, 1, 'use_ssl', '0');
INSERT INTO `wp_usermeta` VALUES (9, 1, 'show_admin_bar_front', 'true');
INSERT INTO `wp_usermeta` VALUES (10, 1, 'locale', '');
INSERT INTO `wp_usermeta` VALUES (11, 1, 'wp_capabilities', 'a:1:{s:13:\"administrator\";b:1;}');
INSERT INTO `wp_usermeta` VALUES (12, 1, 'wp_user_level', '10');
INSERT INTO `wp_usermeta` VALUES (14, 1, 'show_welcome_panel', '0');
INSERT INTO `wp_usermeta` VALUES (15, 1, 'session_tokens', 'a:1:{s:64:\"c4e80dc70df72bb9516d19b8d7addb39dd8ed20b521715941ecd178e323c7515\";a:4:{s:10:\"expiration\";i:1610241782;s:2:\"ip\";s:13:\"172.69.33.215\";s:2:\"ua\";s:114:\"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36\";s:5:\"login\";i:1610068982;}}');
INSERT INTO `wp_usermeta` VALUES (16, 1, 'wp_dashboard_quick_press_last_post_id', '8773');
INSERT INTO `wp_usermeta` VALUES (17, 1, 'community-events-location', 'a:1:{s:2:\"ip\";s:12:\"222.69.227.0\";}');
INSERT INTO `wp_usermeta` VALUES (18, 1, 'wp_user-settings', 'libraryContent=browse&editor=tinymce&unfold=1&mfold=o');
INSERT INTO `wp_usermeta` VALUES (19, 1, 'wp_user-settings-time', '1567601055');
INSERT INTO `wp_usermeta` VALUES (20, 1, 'nav_menu_recently_edited', '181');
INSERT INTO `wp_usermeta` VALUES (21, 1, 'managenav-menuscolumnshidden', 'a:5:{i:0;s:11:\"link-target\";i:1;s:11:\"css-classes\";i:2;s:3:\"xfn\";i:3;s:11:\"description\";i:4;s:15:\"title-attribute\";}');
INSERT INTO `wp_usermeta` VALUES (22, 1, 'metaboxhidden_nav-menus', 'a:1:{i:0;s:12:\"add-post_tag\";}');
INSERT INTO `wp_usermeta` VALUES (23, 1, 'syntax_highlighting', 'true');
INSERT INTO `wp_usermeta` VALUES (24, 1, 'closedpostboxes_post', 'a:1:{i:0;s:19:\"seraph_pds_add_post\";}');
INSERT INTO `wp_usermeta` VALUES (25, 1, 'metaboxhidden_post', 'a:6:{i:0;s:11:\"postexcerpt\";i:1;s:13:\"trackbacksdiv\";i:2;s:10:\"postcustom\";i:3;s:16:\"commentstatusdiv\";i:4;s:7:\"slugdiv\";i:5;s:9:\"authordiv\";}');
INSERT INTO `wp_usermeta` VALUES (26, 1, 'closedpostboxes_dashboard', 'a:0:{}');
INSERT INTO `wp_usermeta` VALUES (27, 1, 'metaboxhidden_dashboard', 'a:0:{}');
INSERT INTO `wp_usermeta` VALUES (28, 1, 'closedpostboxes_page', 'a:1:{i:0;s:19:\"seraph_pds_add_post\";}');
INSERT INTO `wp_usermeta` VALUES (29, 1, 'metaboxhidden_page', 'a:5:{i:0;s:10:\"postcustom\";i:1;s:16:\"commentstatusdiv\";i:2;s:11:\"commentsdiv\";i:3;s:7:\"slugdiv\";i:4;s:9:\"authordiv\";}');
INSERT INTO `wp_usermeta` VALUES (30, 1, 'dismissed_wp_pointers', 'wp496_privacy,theme_editor_notice');
INSERT INTO `wp_usermeta` VALUES (31, 1, 'wp_media_library_mode', 'list');
INSERT INTO `wp_usermeta` VALUES (32, 1, 'meta-box-order_dashboard', 'a:4:{s:6:\"normal\";s:78:\"dashboard_php_nag,dashboard_site_health,dashboard_right_now,dashboard_activity\";s:4:\"side\";s:39:\"dashboard_quick_press,dashboard_primary\";s:7:\"column3\";s:0:\"\";s:7:\"column4\";s:0:\"\";}');

SET FOREIGN_KEY_CHECKS = 1;
