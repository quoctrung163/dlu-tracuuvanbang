<?php
// Hàm bổ sung menu con vào một menu cha
function dlu_tracuuvanbang_admin_menu()
{
  add_submenu_page(
    'dlu-tracuuvanbang', // Menu cha
    'Cập nhật thông tin điểm', // Tiêu đề của menu
    'Cập nhật thông tin điểm', // Tên của menu
    'manage_options', // Vùng truy cập, giá trị này có ý nghĩa chỉ có supper admin và admin đc dùng
    'theme-options', // Slug của menu
    'access_menu_options' // Hàm callback hiển thị nội dung của menu
  );
}

// Hàm xử lý khi click vào menu
function access_menu_options()
{
  require('template/index.php');
}

// Thêm hành động hiển thị menu con vào Action admin_menu Hooks
add_action('admin_menu', 'dlu_tracuuvanbang_admin_menu');
