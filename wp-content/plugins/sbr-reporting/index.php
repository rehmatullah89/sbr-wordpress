<?php
 
/*
 
Plugin Name: Sbr Reporting
 
Plugin URI: https:smilebrilliant.com
 
Description: Developed for custom Sales Reports
 
Version: 1.0
 
Author: MindBlaze Technologies
 
Author URI: https://www.mindblaze.net/
 
License: Later
 
Text Domain: sbr
 
*/
require_once('inc/search-functions-1.php');
require_once('inc/search-functions-2.php');
require_once('inc/sbr-report-cron.php');
require_once('inc/core-functions.php');
function admin_menu_reporting_sbr_mbt() {
    add_menu_page(
        __( 'Custom Reporting', 'sbr' ),
        'Custom Reporting',
        'manage_options',
        'sbr-reporting/report-functions.php',
        '',
        plugins_url( 'sbr-reporting/assets/images/icon.png' ),
        6
    );
    add_menu_page(
           
        __('Download Reports', 'sbr' ),
        'Download Reports',
        'manage_options',
        'sbr-reporting/report-download.php',
        '',
        plugins_url( 'sbr-reporting/assets/images/icon.png' ),
        6
    );
}
add_action( 'admin_menu', 'admin_menu_reporting_sbr_mbt' );

add_action('admin_enqueue_scripts', 'sb_reports_admin_scripts', 11);

function sb_reports_admin_scripts() {
    global $post_type;
    $version = time();

    wp_enqueue_style('sbr-reports', plugins_url('sbr-reporting/assets/') . 'sbr-reports.css?v=' . $version, false);
    wp_enqueue_script('sbr-reports', plugins_url('sbr-reporting/assets/') . 'sbr-reports.js?v=' . $version, '1.0.0', true);
}