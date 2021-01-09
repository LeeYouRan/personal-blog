<?php
/*
Plugin Name: Seraphinite Post .DOCX Source
Plugin URI: http://wordpress.org/plugins/seraphinite-post-docx-source
Description: Save your time by automatically converting from .DOCX to content with all WordPress post attributes.
Text Domain: seraphinite-post-docx-source
Domain Path: /languages
Version: 2.10.2
Author: Seraphinite Solutions
Author URI: https://www.s-sols.com
License: GPLv2 or later (if another license is not provided)


*/

include( __DIR__ . '/main.php' );

// #######################################################################

register_activation_hook( __FILE__, 'seraph_pds\\OnActivate' );
register_deactivation_hook( __FILE__, 'seraph_pds\\OnDeactivate' );
//register_uninstall_hook( __FILE__, 'seraph_pds\\OnUninstall' );

// #######################################################################
// #######################################################################
