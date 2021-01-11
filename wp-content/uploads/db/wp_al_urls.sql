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

 Date: 09/01/2021 08:21:58
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for wp_al_urls
-- ----------------------------
DROP TABLE IF EXISTS `wp_al_urls`;
CREATE TABLE `wp_al_urls`  (
  `al_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `al_slug` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `al_crtime` datetime NOT NULL,
  `al_origURL` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `al_count` mediumint(8) NOT NULL DEFAULT 0,
  `al_isAuto` tinyint(1) NULL DEFAULT 1,
  PRIMARY KEY (`al_id`) USING BTREE,
  INDEX `al_count`(`al_count`) USING BTREE,
  INDEX `al_slug`(`al_slug`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 139 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of wp_al_urls
-- ----------------------------
INSERT INTO `wp_al_urls` VALUES (1, 'akys', '2018-05-22 20:30:18', 'http://lib.csdn.net/base/php', 0, 1);
INSERT INTO `wp_al_urls` VALUES (2, 'qgat', '2018-05-23 22:17:54', 'http://laravist.com', 0, 1);
INSERT INTO `wp_al_urls` VALUES (3, 'u2om', '2018-05-23 22:17:54', 'http://www.sina.com.cn/abc/de/fg.php?id=1', 0, 1);
INSERT INTO `wp_al_urls` VALUES (4, 'rc3y', '2018-06-09 08:41:26', 'http://www.thinkphp.cn/down.html', 0, 1);
INSERT INTO `wp_al_urls` VALUES (5, 'sbfh', '2018-06-09 08:41:26', 'http://域名/index.php/模块/控制器/方法名/参数1/值1/参数2/值2/', 0, 1);
INSERT INTO `wp_al_urls` VALUES (6, 'ghx2', '2018-06-09 08:41:26', 'http://网址/index.php/分组/控制器名称/操作方法名称', 0, 1);
INSERT INTO `wp_al_urls` VALUES (7, '98sz', '2018-06-09 08:41:26', 'http://域名/模块/控制器名/方法名/参数名/参数值/参数名/参数值...', 0, 1);
INSERT INTO `wp_al_urls` VALUES (8, 'dzl6', '2018-06-09 08:41:26', 'http://servername/index.php/login', 0, 1);
INSERT INTO `wp_al_urls` VALUES (9, '5h9l', '2018-06-09 08:41:26', 'http://servername/index.php/home/User/login', 0, 1);
INSERT INTO `wp_al_urls` VALUES (10, '8icy', '2018-06-09 08:41:26', 'http://网址/分组/路由/操作方法/参数/值/参数/值', 0, 1);
INSERT INTO `wp_al_urls` VALUES (11, 'poxn', '2018-06-09 08:53:59', 'https://getcomposer.org/download/', 0, 1);
INSERT INTO `wp_al_urls` VALUES (12, '8fls', '2018-06-09 08:53:59', 'https://packagist.org/packages/topthink/think-captcha', 0, 1);
INSERT INTO `wp_al_urls` VALUES (13, '6kfy', '2018-06-09 08:59:37', 'https://www.jianshu.com/p/e1d5f0dc2f5d', 0, 1);
INSERT INTO `wp_al_urls` VALUES (14, 'w8q1', '2018-06-09 09:11:30', 'http://www.yiiframework.com', 0, 1);
INSERT INTO `wp_al_urls` VALUES (15, 'g3cr', '2018-06-09 09:11:30', 'http://www.yiichina.com', 0, 1);
INSERT INTO `wp_al_urls` VALUES (16, '7a3e', '2018-06-09 09:11:30', 'http://l.com/yii2/frontend/web/index.php?r=test/index', 0, 1);
INSERT INTO `wp_al_urls` VALUES (17, 'cbx3', '2018-06-09 09:11:30', 'http://blog.csdn.net/ww_smile7/article/details/53410166', 0, 1);
INSERT INTO `wp_al_urls` VALUES (18, 'hl2v', '2018-06-09 09:14:00', 'http://www.thinkphp.cn/', 0, 1);
INSERT INTO `wp_al_urls` VALUES (19, 'hd8t', '2018-06-09 09:14:00', 'http://域名/入口文件?m=模块名称&amp;c=控制器名称&amp;a=方法名称(操作)', 0, 1);
INSERT INTO `wp_al_urls` VALUES (20, 'zx7y', '2018-06-09 09:14:00', 'http://tp.com/index.php?m=Home&amp;c=Index&amp;a=test2', 0, 1);
INSERT INTO `wp_al_urls` VALUES (21, 'itit', '2018-06-09 09:14:00', 'http://tp.com/index.php/Home/Index/test2', 0, 1);
INSERT INTO `wp_al_urls` VALUES (22, 'dc8y', '2018-06-09 09:14:00', 'http://tp.com/index.php?s=Home/Index/test2', 0, 1);
INSERT INTO `wp_al_urls` VALUES (23, 'c9pa', '2018-06-10 18:51:08', 'http://www.ecshop.com/', 0, 1);
INSERT INTO `wp_al_urls` VALUES (24, 'zptp', '2018-06-10 18:51:08', 'http://www.shopex.cn/', 0, 1);
INSERT INTO `wp_al_urls` VALUES (25, 'ajli', '2018-06-10 18:51:08', 'http://www.shopnc.net/', 0, 1);
INSERT INTO `wp_al_urls` VALUES (26, 'ubug', '2018-06-10 18:51:08', 'http://b2b2c.shopnctest.com/dema/shop/index.php', 0, 1);
INSERT INTO `wp_al_urls` VALUES (27, 'z1k0', '2018-06-10 18:51:08', 'http://vendor.shop.com/', 0, 1);
INSERT INTO `wp_al_urls` VALUES (28, '1knx', '2018-06-10 18:51:08', 'http://vendor.shop.com/admin/', 0, 1);
INSERT INTO `wp_al_urls` VALUES (29, 'x9uh', '2018-06-10 18:51:08', 'http://www.php15shop.com', 0, 1);
INSERT INTO `wp_al_urls` VALUES (30, 'htjc', '2018-06-16 18:36:51', 'http://域名/模块名/这样会报错。', 0, 1);
INSERT INTO `wp_al_urls` VALUES (31, 'ozwd', '2018-06-16 18:36:51', 'https://mail.sina.com.cn/register/regmail.php', 0, 1);
INSERT INTO `wp_al_urls` VALUES (32, '4d4z', '2018-06-16 18:36:51', 'http://www.yuntongxun.com/', 0, 1);
INSERT INTO `wp_al_urls` VALUES (33, 'thuu', '2018-06-16 18:36:51', 'http://www.106jiekou.com/', 0, 1);
INSERT INTO `wp_al_urls` VALUES (34, '30gu', '2018-06-16 18:36:51', 'http://www.yuntongxun.com/user/reg/init', 0, 1);
INSERT INTO `wp_al_urls` VALUES (35, 'wto7', '2018-06-17 16:02:47', 'http://www.php15shop.com/home/public/updpassword/member_id/2/time/1529202630/hash/50730d397f3b07e62e52e4c5b5e1cf47', 0, 1);
INSERT INTO `wp_al_urls` VALUES (36, 'efjr', '2018-06-17 16:02:47', 'http://open.qq.com/', 0, 1);
INSERT INTO `wp_al_urls` VALUES (37, 'p1rq', '2018-06-17 16:02:47', 'https://connect.qq.com/manage.html#/', 0, 1);
INSERT INTO `wp_al_urls` VALUES (38, 'il7d', '2018-06-17 16:02:47', 'http://wiki.connect.qq.com/', 0, 1);
INSERT INTO `wp_al_urls` VALUES (39, 'pv02', '2018-06-20 19:27:32', 'https://b.alipay.com/', 0, 1);
INSERT INTO `wp_al_urls` VALUES (40, 'kris', '2018-06-20 19:27:32', 'https://openhome.alipay.com/platform/developerIndex.htm', 0, 1);
INSERT INTO `wp_al_urls` VALUES (41, '9m2k', '2018-06-20 19:27:32', 'https://docs.open.alipay.com/270/106291', 0, 1);
INSERT INTO `wp_al_urls` VALUES (42, '56zy', '2018-06-20 19:27:32', 'https://openapi.alipaydev.com/gateway.do', 0, 1);
INSERT INTO `wp_al_urls` VALUES (43, 'ckwc', '2018-06-23 18:37:48', 'http://www.kuaidi100.com/applyurl?key=%7b$key%7d&amp;com=%7b$com%7d&amp;nu=%7b$nu%7d&amp;show=0', 0, 1);
INSERT INTO `wp_al_urls` VALUES (44, '3up3', '2018-06-23 18:45:06', 'https://www.git-scm.com/download/win', 0, 1);
INSERT INTO `wp_al_urls` VALUES (45, '4rks', '2018-06-23 18:51:04', 'https://github.com/ww24kobe/test_project.git', 0, 1);
INSERT INTO `wp_al_urls` VALUES (46, 'f8cf', '2018-06-23 18:51:04', 'https://www.jianshu.com/p/e79ea05d9b61', 0, 1);
INSERT INTO `wp_al_urls` VALUES (47, '5dav', '2018-06-23 18:53:00', 'https://link.jianshu.com?t=https%3A%2F%2Fgit-scm.com%2Fdownload%2Fwin', 0, 1);
INSERT INTO `wp_al_urls` VALUES (48, 'cz1q', '2019-07-03 09:24:46', 'https://www.deepsea887.com/', 0, 1);
INSERT INTO `wp_al_urls` VALUES (49, 'i8j3', '2019-09-04 20:05:37', 'https://github.com/jimuyouyou/node-interview-questions#%E8%B5%B7%E6%BA%90', 0, 1);
INSERT INTO `wp_al_urls` VALUES (50, 'ww2r', '2019-09-04 20:05:37', 'https://github.com/jimuyouyou/node-interview-questions#%E7%9B%AE%E6%A0%87%E4%B8%8E%E5%8E%9F%E5%88%99', 0, 1);
INSERT INTO `wp_al_urls` VALUES (51, 'hogw', '2019-09-04 20:05:37', 'https://github.com/jimuyouyou/node-interview-questions#%E5%86%85%E5%AE%B9%E5%A4%A7%E7%BA%B2', 0, 1);
INSERT INTO `wp_al_urls` VALUES (52, '2h9t', '2019-09-04 20:05:37', 'https://github.com/jimuyouyou/node-interview-questions#jsAdvanced', 0, 1);
INSERT INTO `wp_al_urls` VALUES (53, 'wmep', '2019-09-04 20:05:37', 'https://github.com/jimuyouyou/node-interview-questions#nodeCore', 0, 1);
INSERT INTO `wp_al_urls` VALUES (54, 'ird6', '2019-09-04 20:05:37', 'https://github.com/jimuyouyou/node-interview-questions#nodeAdvanced', 0, 1);
INSERT INTO `wp_al_urls` VALUES (55, 'f8dx', '2019-09-04 20:05:37', 'https://github.com/jimuyouyou/node-interview-questions#node3rd', 0, 1);
INSERT INTO `wp_al_urls` VALUES (56, 'x3vi', '2019-09-04 20:05:37', 'https://github.com/jimuyouyou/node-interview-questions#otherBackend', 0, 1);
INSERT INTO `wp_al_urls` VALUES (57, '7f4t', '2019-09-04 20:05:37', 'https://github.com/jimuyouyou/node-interview-questions#otherFrontEnd', 0, 1);
INSERT INTO `wp_al_urls` VALUES (58, 'gaiy', '2019-09-04 20:05:37', 'https://github.com/jimuyouyou/node-interview-questions#javascript%E9%AB%98%E7%BA%A7%E8%AF%9D%E9%A2%98%E9%9D%A2%E5%90%91%E5%AF%B9%E8%B1%A1%E4%BD%9C%E7%94%A8%E5%9F%9F%E9%97%AD%E5%8C%85%E8%AE%BE%E8%AE%A1%E6%A8%A1%E5%BC%8F%E7%AD%89', 0, 1);
INSERT INTO `wp_al_urls` VALUES (59, '143g', '2019-09-04 20:05:37', 'https://github.com/jimuyouyou/node-interview-questions#node%E6%A0%B8%E5%BF%83%E5%86%85%E7%BD%AE%E7%B1%BB%E5%BA%93%E4%BA%8B%E4%BB%B6%E6%B5%81%E6%96%87%E4%BB%B6%E7%BD%91%E7%BB%9C%E7%AD%89', 0, 1);
INSERT INTO `wp_al_urls` VALUES (60, 'guxb', '2019-09-04 20:05:37', 'https://github.com/jimuyouyou/node-interview-questions#node%E6%A6%82%E8%A7%88', 0, 1);
INSERT INTO `wp_al_urls` VALUES (61, 'x4ix', '2019-09-04 20:05:37', 'https://camo.githubusercontent.com/233315761d49d4c75fe7969e36bda22ecf5bbc0f/687474703a2f2f6a6f616f7073696c76612e6769746875622e696f2f74616c6b732f456e642d746f2d456e642d4a6176615363726970742d776974682d7468652d4d45414e2d537461636b2f696d672f6e6f64656a732d617263682d7070742e706e67', 0, 1);
INSERT INTO `wp_al_urls` VALUES (62, 'x7hg', '2019-09-04 20:05:37', 'https://github.com/jimuyouyou/node-interview-questions#node%E5%85%A8%E5%B1%80%E5%AF%B9%E8%B1%A1', 0, 1);
INSERT INTO `wp_al_urls` VALUES (63, '9iwd', '2019-09-04 20:05:37', 'https://github.com/jimuyouyou/node-interview-questions#eventemitter', 0, 1);
INSERT INTO `wp_al_urls` VALUES (64, 'irdg', '2019-09-04 20:05:37', 'https://github.com/jimuyouyou/node-interview-questions#stream', 0, 1);
INSERT INTO `wp_al_urls` VALUES (65, 'pu7z', '2019-09-04 20:05:37', 'https://github.com/jimuyouyou/node-interview-questions#%E6%96%87%E4%BB%B6%E7%B3%BB%E7%BB%9F', 0, 1);
INSERT INTO `wp_al_urls` VALUES (66, 'ybcr', '2019-09-04 20:05:37', 'https://github.com/jimuyouyou/node-interview-questions#%E7%BD%91%E7%BB%9C', 0, 1);
INSERT INTO `wp_al_urls` VALUES (67, 'obuo', '2019-09-04 20:05:37', 'https://github.com/jimuyouyou/node-interview-questions#child-process', 0, 1);
INSERT INTO `wp_al_urls` VALUES (68, '4f8b', '2019-09-04 20:05:37', 'https://github.com/jimuyouyou/node-interview-questions#node%E9%AB%98%E7%BA%A7%E8%AF%9D%E9%A2%98%E5%BC%82%E6%AD%A5%E9%83%A8%E7%BD%B2%E6%80%A7%E8%83%BD%E8%B0%83%E4%BC%98%E5%BC%82%E5%B8%B8%E8%B0%83%E8%AF%95%E7%AD%89', 0, 1);
INSERT INTO `wp_al_urls` VALUES (69, 'f3xe', '2019-09-04 20:05:37', 'https://github.com/jimuyouyou/node-interview-questions#%E5%B8%B8%E7%94%A8%E7%9F%A5%E5%90%8D%E7%AC%AC%E4%B8%89%E6%96%B9%E7%B1%BB%E5%BA%93async-express%E7%AD%89', 0, 1);
INSERT INTO `wp_al_urls` VALUES (70, 'wzxv', '2019-09-04 20:05:37', 'https://github.com/jimuyouyou/node-interview-questions#%E5%85%B6%E5%AE%83%E7%9B%B8%E5%85%B3%E5%90%8E%E7%AB%AF%E5%B8%B8%E7%94%A8%E6%8A%80%E6%9C%AFmongodb-redis-apache-nginx%E7%AD%89', 0, 1);
INSERT INTO `wp_al_urls` VALUES (71, 'syd6', '2019-09-04 20:05:37', 'https://github.com/jimuyouyou/node-interview-questions#%E5%B8%B8%E7%94%A8%E5%89%8D%E7%AB%AF%E6%8A%80%E6%9C%AFhtml5-css3-jquery%E7%AD%89', 0, 1);
INSERT INTO `wp_al_urls` VALUES (72, 'o8pw', '2019-09-04 20:11:52', 'https://github.com/BreakWaIl/node-interview-questions#nodejs-%E8%AE%BE%E8%AE%A1%E6%A8%A1%E5%BC%8F', 0, 1);
INSERT INTO `wp_al_urls` VALUES (73, '942q', '2019-09-04 20:11:52', 'https://github.com/jimuyouyou/HeadFirstDesignPatternInJavascript', 0, 1);
INSERT INTO `wp_al_urls` VALUES (74, 'scp8', '2019-09-04 20:20:29', 'http://eslint.org/', 0, 1);
INSERT INTO `wp_al_urls` VALUES (75, 'temy', '2019-09-04 20:20:29', 'https://standardjs.com/', 0, 1);
INSERT INTO `wp_al_urls` VALUES (76, '5xtt', '2019-09-04 20:44:18', 'https://github.com/BreakWaIl/PingAnIMG', 0, 1);
INSERT INTO `wp_al_urls` VALUES (77, 'mgpy', '2020-02-02 00:00:21', 'https://lnmp.org/install.html#offline', 0, 1);
INSERT INTO `wp_al_urls` VALUES (78, '536t', '2020-02-02 00:00:21', 'https://www.vpser.net/go/aliyun', 0, 1);
INSERT INTO `wp_al_urls` VALUES (79, 'wgcm', '2020-02-02 00:00:21', 'https://www.vpser.net/go/vultr', 0, 1);
INSERT INTO `wp_al_urls` VALUES (80, 'r40i', '2020-02-02 00:00:21', 'https://www.vpser.net/go/aoyohost', 0, 1);
INSERT INTO `wp_al_urls` VALUES (81, 'lg11', '2020-02-02 00:00:21', 'https://www.vpser.net/go/bwg', 0, 1);
INSERT INTO `wp_al_urls` VALUES (82, 'ftn1', '2020-02-02 00:00:21', 'https://www.vpser.net/go/locvps', 0, 1);
INSERT INTO `wp_al_urls` VALUES (83, '63m3', '2020-02-02 00:00:21', 'https://www.vpser.net/go/linode', 0, 1);
INSERT INTO `wp_al_urls` VALUES (84, '930c', '2020-02-02 00:00:21', 'https://www.vpser.net/go/vps2ez', 0, 1);
INSERT INTO `wp_al_urls` VALUES (85, '1c1m', '2020-02-02 00:00:21', 'https://www.vpser.net/go/diahosting', 0, 1);
INSERT INTO `wp_al_urls` VALUES (86, 'vhcf', '2020-02-02 00:00:21', 'https://www.vpser.net/go/digitalocean', 0, 1);
INSERT INTO `wp_al_urls` VALUES (87, 'kfx2', '2020-02-02 00:00:21', 'https://www.vpser.net/go/kvmla', 0, 1);
INSERT INTO `wp_al_urls` VALUES (88, 'lq8m', '2020-02-02 00:00:21', 'https://www.vpser.net/go/jwdns', 0, 1);
INSERT INTO `wp_al_urls` VALUES (89, 'z9b2', '2020-02-02 00:00:21', 'https://www.vpser.net/go/buyvm', 0, 1);
INSERT INTO `wp_al_urls` VALUES (90, 'jeak', '2020-02-02 00:00:21', 'https://www.vpser.net/go/kiiyi', 0, 1);
INSERT INTO `wp_al_urls` VALUES (91, 'niwm', '2020-02-02 00:00:21', 'https://www.vpser.net/go/80vps', 0, 1);
INSERT INTO `wp_al_urls` VALUES (92, 'x89h', '2020-02-02 00:00:21', 'https://www.vpser.net/go/qcloud', 0, 1);
INSERT INTO `wp_al_urls` VALUES (93, 'dsf0', '2020-02-02 00:00:21', 'https://www.vpser.net/other/putty-ssh-linux-vps.html', 0, 1);
INSERT INTO `wp_al_urls` VALUES (94, 'a8vt', '2020-02-02 00:00:21', 'https://www.vpser.net/manage/run-screen-lnmp.html', 0, 1);
INSERT INTO `wp_al_urls` VALUES (95, '2oyi', '2020-02-02 00:00:21', 'https://lnmp.org/download.html', 0, 1);
INSERT INTO `wp_al_urls` VALUES (96, 'pk6m', '2020-02-02 00:00:21', 'https://lnmp.org/auto.html', 0, 1);
INSERT INTO `wp_al_urls` VALUES (97, 'qkmb', '2020-02-02 00:00:21', 'https://lnmp.org/faq/v1-5-auto-install.html', 0, 1);
INSERT INTO `wp_al_urls` VALUES (98, 'ysgl', '2020-02-02 00:00:21', 'https://lnmp.org/faq/lnmp-software-list.html#lnmp.conf', 0, 1);
INSERT INTO `wp_al_urls` VALUES (99, '0mak', '2020-02-02 00:00:21', 'https://lnmp.org/faq/lnmp-download-source.html', 0, 1);
INSERT INTO `wp_al_urls` VALUES (100, 'qa97', '2020-02-02 00:00:21', 'https://lnmp.org/faq/lnmp-vhost-add-howto.html', 0, 1);
INSERT INTO `wp_al_urls` VALUES (101, 'aj5n', '2020-02-02 00:00:21', 'https://lnmp.org/faq/sftp.html', 0, 1);
INSERT INTO `wp_al_urls` VALUES (102, '8uv2', '2020-02-02 00:00:21', 'https://lnmp.org/faq/ftpserver.html', 0, 1);
INSERT INTO `wp_al_urls` VALUES (103, 'cl24', '2020-02-02 00:00:21', 'http://www.vpser.net/manage/winscp.html', 0, 1);
INSERT INTO `wp_al_urls` VALUES (104, 'tgnw', '2020-02-02 00:00:21', 'http://bbs.vpser.net/forum-25-1.html', 0, 1);
INSERT INTO `wp_al_urls` VALUES (105, '7wl7', '2020-02-02 00:00:21', 'https://lnmp.org/faq/addons.html', 0, 1);
INSERT INTO `wp_al_urls` VALUES (106, 'dad9', '2020-02-02 00:00:21', 'https://lnmp.org/faq/lnmp-software-list.html', 0, 1);
INSERT INTO `wp_al_urls` VALUES (107, 'igko', '2020-02-02 00:00:21', 'https://lnmp.org/faq/lnmp-status-manager.html', 0, 1);
INSERT INTO `wp_al_urls` VALUES (108, 'jk9l', '2020-02-02 00:00:21', 'https://www.vpser.net/manage/centos-iso-local-yum-repository.html', 0, 1);
INSERT INTO `wp_al_urls` VALUES (109, 'ljby', '2020-02-02 00:00:21', 'https://lnmp.org/install.html', 0, 1);
INSERT INTO `wp_al_urls` VALUES (110, '9e25', '2020-02-02 00:00:21', 'http://www.vpser.net/manage/vi.html', 0, 1);
INSERT INTO `wp_al_urls` VALUES (111, 'wlq3', '2020-02-02 00:00:21', 'http://www.vpser.net/manage/nano.html', 0, 1);
INSERT INTO `wp_al_urls` VALUES (112, 'dgm4', '2020-02-02 00:00:21', 'https://segmentfault.com/a/1190000016119293?utm_source=tag-newest', 0, 1);
INSERT INTO `wp_al_urls` VALUES (113, 'qrt3', '2020-02-02 00:00:21', 'https://www.22vd.com/3979.html', 0, 1);
INSERT INTO `wp_al_urls` VALUES (114, 'ggib', '2020-02-02 00:00:21', 'https://blog.csdn.net/qintaiwu/article/details/77994917', 0, 1);
INSERT INTO `wp_al_urls` VALUES (115, 'sb47', '2020-02-02 00:07:05', 'https://zhuanlan.zhihu.com/p/50803437', 0, 1);
INSERT INTO `wp_al_urls` VALUES (116, 'gj5i', '2020-09-25 08:49:51', 'https://blog.csdn.net/u012628581/article/details/102512197#in_array_1', 0, 1);
INSERT INTO `wp_al_urls` VALUES (117, '4z6j', '2020-09-25 08:49:51', 'https://blog.csdn.net/u012628581/article/details/102512197#array_search_19', 0, 1);
INSERT INTO `wp_al_urls` VALUES (118, 'gr6p', '2020-09-25 08:49:51', 'https://blog.csdn.net/u012628581/article/details/102512197#array_key_exists_39', 0, 1);
INSERT INTO `wp_al_urls` VALUES (119, 'jc2u', '2020-09-25 08:49:51', 'https://blog.csdn.net/u012628581/article/details/102512197#array_values_62', 0, 1);
INSERT INTO `wp_al_urls` VALUES (120, 'cmtw', '2020-09-25 08:49:51', 'https://blog.csdn.net/u012628581/article/details/102512197#array_filter_85', 0, 1);
INSERT INTO `wp_al_urls` VALUES (121, 'oqni', '2020-09-25 08:49:51', 'https://blog.csdn.net/u012628581/article/details/102512197#array_column_135', 0, 1);
INSERT INTO `wp_al_urls` VALUES (122, '0b4r', '2020-09-25 08:49:51', 'https://blog.csdn.net/u012628581/article/details/102512197#array_merge_176', 0, 1);
INSERT INTO `wp_al_urls` VALUES (123, 'x47w', '2020-09-25 08:49:51', 'https://blog.csdn.net/u012628581/article/details/102512197#array_pop_200', 0, 1);
INSERT INTO `wp_al_urls` VALUES (124, 'fzu3', '2020-09-25 08:49:51', 'https://blog.csdn.net/u012628581/article/details/102512197#list_223', 0, 1);
INSERT INTO `wp_al_urls` VALUES (125, 'x2dh', '2020-09-25 08:49:51', 'https://blog.csdn.net/u012628581/article/details/102512197#ksort_241', 0, 1);
INSERT INTO `wp_al_urls` VALUES (126, 'fcvc', '2020-09-25 08:49:51', 'http://www.example.com/do.php', 0, 1);
INSERT INTO `wp_al_urls` VALUES (127, 's8vl', '2020-09-25 08:49:51', 'https://www.cnblogs.com/xk920/p/11132038.html', 0, 1);
INSERT INTO `wp_al_urls` VALUES (128, 'mnte', '2020-09-25 08:49:51', 'https://www.cnblogs.com/sunxun/p/4233720.html', 0, 1);
INSERT INTO `wp_al_urls` VALUES (129, 'cohf', '2020-09-25 17:48:14', 'https://www.cnblogs.com/dazzler/p/3817677.html', 0, 1);
INSERT INTO `wp_al_urls` VALUES (130, 'aurs', '2020-09-25 17:48:14', 'https://blog.csdn.net/v_july_v/article/details/7382693', 0, 1);
INSERT INTO `wp_al_urls` VALUES (131, 'uwj5', '2020-09-25 17:48:14', 'https://blog.csdn.net/twlkyao/article/details/12037073', 0, 1);
INSERT INTO `wp_al_urls` VALUES (132, 'w0vt', '2020-09-25 17:48:14', 'https://blog.csdn.net/tiankong_/article/details/77239501', 0, 1);
INSERT INTO `wp_al_urls` VALUES (133, 'f0yr', '2020-09-25 17:48:14', 'https://www.cnblogs.com/chenshengqun/p/8875512.html', 0, 1);
INSERT INTO `wp_al_urls` VALUES (134, '9baq', '2020-09-25 17:48:14', 'https://www.cnblogs.com/middleware/articles/9052394.html', 0, 1);
INSERT INTO `wp_al_urls` VALUES (135, 'rmib', '2020-09-25 17:48:14', 'https://blog.csdn.net/chang384915878/article/details/86748083', 0, 1);
INSERT INTO `wp_al_urls` VALUES (136, 'psj6', '2020-09-25 17:48:14', 'http://www.tecmint.com/35-practical-examples-of-linux-find-command/', 0, 1);
INSERT INTO `wp_al_urls` VALUES (137, 'd1co', '2020-09-25 17:48:14', 'http://www.tecmint.com/how-to-check-disk-space-in-linux/', 0, 1);
INSERT INTO `wp_al_urls` VALUES (138, 'jcde', '2020-09-25 17:48:14', 'http://www.tecmint.com/check-linux-disk-usage-of-files-and-directories/', 0, 1);

SET FOREIGN_KEY_CHECKS = 1;
