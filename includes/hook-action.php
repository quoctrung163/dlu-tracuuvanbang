<?php

function dlu_load_plugin_css()
{
  wp_enqueue_style('style1', plugins_url('../css/style.css', __FILE__));
  wp_enqueue_style('style2', 'https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css');
}

add_action('admin_enqueue_scripts', 'dlu_load_plugin_css');



// function callback_for_setting_up_scripts()
// {
//   wp_register_style('style', 'https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css');
//   wp_enqueue_style('style1', '../css/style.css');
//   wp_enqueue_script('script', 'https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js');
//   wp_enqueue_script('script', 'https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js');
// }

// add_action('wp_enqueue_scripts', 'callback_for_setting_up_scripts');
