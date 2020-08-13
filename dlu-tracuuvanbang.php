<?php

/**
 * Plugin Name: Tra Cứu Văn Bằng
 * Plugin URI: http://cict.dlu.edu.vn/
 * Description: Tra cứu văn bằng học viên
 * Version: 1.0 
 * Author: quoctrung163, quocthang0507
 * Author URI: github.com
 * License: GPLv2
 */

require 'includes/hook-action.php';
require 'includes/hook-filter.php';
require 'includes/option-api.php';
require 'includes/admin-menu.php';

register_activation_hook(__FILE__, 'dlu_tracuuvanbang_active');

function dlu_tracuuvanbang_active()
{
  $dlu_tracuuvanbang_version = '1.0';
  add_option('_dlu_tracuuvanbang_version', $dlu_tracuuvanbang_version, '', 'yes');
}

register_deactivation_hook(__FILE__, 'dlu_tracuuvanbang_deactive');

function dlu_tracuuvanbang_deactive()
{
  global $wpdb;
  $table_name = $wpdb->prefix . 'options';
  $wpdb->update(
    $table_name,
    array('autoload' => 'no'),
    array('option_name' => '_dlu_tracuuvanbang_version'),
    array('%s'),
    array('%s')
  );
}

register_uninstall_hook(__FILE__, 'dlu_tracuuvanbang_uninstall');

function dlu_tracuuvanbang_uninstall()
{
  global $wpdb;
  delete_option('_dlu_tracuuvanbang_version'); // delete options
  $table_name = $wpdb->prefix . 'dlu_tracuuvanbang';
  $sql = 'DROP TABLE IF EXISTS ' . $table_name;
  $wpdb->query($sql);
}
