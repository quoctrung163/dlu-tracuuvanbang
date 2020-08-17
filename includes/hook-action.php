<?php

function dlu_load_plugin_css()
{
	// wp_register_style('style1', 'https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css', __FILE__);
	// wp_register_style('style1', 'https://cdn.metroui.org.ua/v4/css/metro-all.min.css', __FILE__);
	wp_register_style('style2', plugins_url('dlu-tracuuvanbang/css/style.css'), __FILE__);
	// wp_enqueue_style('style1');
	wp_enqueue_style('style2');
}

add_action('admin_enqueue_scripts', 'dlu_load_plugin_css');

function dlu_load_plugin_js()
{
	// wp_enqueue_script('script', 'https://cdn.metroui.org.ua/v4/js/metro.min.js');
	// wp_enqueue_script('script', 'https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js');
	// wp_enqueue_script('script2', 'https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js');
}

add_action('admin_enqueue_scripts', 'dlu_load_plugin_js');
