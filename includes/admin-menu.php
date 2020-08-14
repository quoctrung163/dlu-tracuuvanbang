<?php

/**
 * Thêm menu của plugin vào trang quản trị
 */
function add_admin_menu()
{
  add_menu_page(
    'Quản lý văn bằng học viên',
    'Quản lý văn bằng học viên',
    'manage_options',
    'plugin-options',
    'addXemDanhSachMenu',
    'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/PjxzdmcgaGVpZ2h0PSIzMnB4IiB2ZXJzaW9uPSIxLjEiIHZpZXdCb3g9IjAgMCAzMiAzMiIgd2lkdGg9IjMycHgiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6c2tldGNoPSJodHRwOi8vd3d3LmJvaGVtaWFuY29kaW5nLmNvbS9za2V0Y2gvbnMiIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIj48dGl0bGUvPjxkZXNjLz48ZGVmcy8+PGcgZmlsbD0ibm9uZSIgZmlsbC1ydWxlPSJldmVub2RkIiBpZD0iUGFnZS0xIiBzdHJva2U9Im5vbmUiIHN0cm9rZS13aWR0aD0iMSI+PGcgZmlsbD0iIzkyOTI5MiIgaWQ9Imljb24tMTM4LWNlcnRpZmljYXRlIj48cGF0aCBkPSJNMTMsMTguOTQ5NDkxNCBMMTMsMjIgTDI1Ljk5NTA1MzQsMjIgQzI3LjEwMjM1NDgsMjIgMjgsMjEuMTA5OTQxNiAyOCwxOS45OTk4OTM4IEwyOCw3LjAwMDEwNjE4IEMyOCw1Ljg5NTQ3ODA0IDI3LjEwMjk3MzgsNSAyNS45OTUwNTM0LDUgTDYuMDA0OTQ2NTksNSBDNC44OTc2NDUxNiw1IDQsNS44OTAwNTg0MSA0LDcuMDAwMTA2MTggTDQsMTkuOTk5ODkzOCBDNCwyMS4xMDQ1MjIgNC44OTcwMjYyMywyMiA2LjAwNDk0NjU5LDIyIEw4LDIyIEw4LDE4Ljk0OTQ5MTQgQzcuMzgxNDA2NDgsMTguMzE4MjIyOSA3LDE3LjQ1MzY1MjYgNywxNi41IEM3LDE0LjU2NzAwMzMgOC41NjcwMDMyOCwxMyAxMC41LDEzIEMxMi40MzI5OTY3LDEzIDE0LDE0LjU2NzAwMzMgMTQsMTYuNSBDMTQsMTcuNDUzNjUyNiAxMy42MTg1OTM1LDE4LjMxODIyMjkgMTMsMTguOTQ5NDkxNCBMMTMsMTguOTQ5NDkxNCBMMTMsMTguOTQ5NDkxNCBaIE05LDE5LjY2MzE4NDUgTDksMjQuNTk5OTc1NiBMMTAuNSwyMy4xMDAwMDYxIEwxMiwyNC41OTk5NzU2IEwxMiwxOS42NjMxODQ1IEMxMS41NDUzNzIzLDE5Ljg3OTE1NDUgMTEuMDM2Nzk4NywyMCAxMC41LDIwIEM5Ljk2MzIwMTM0LDIwIDkuNDU0NjI3NjgsMTkuODc5MTU0NSA5LDE5LjY2MzE4NDUgTDksMTkuNjYzMTg0NSBMOSwxOS42NjMxODQ1IFogTTcsMTAgTDcsMTEgTDI1LDExIEwyNSwxMCBMNywxMCBMNywxMCBaIE0xNiwxMyBMMTYsMTQgTDI1LDE0IEwyNSwxMyBMMTYsMTMgTDE2LDEzIFogTTE5LDE2IEwxOSwxNyBMMjUsMTcgTDI1LDE2IEwxOSwxNiBMMTksMTYgWiBNMTAuNSwxOSBDMTEuODgwNzExOSwxOSAxMywxNy44ODA3MTE5IDEzLDE2LjUgQzEzLDE1LjExOTI4ODEgMTEuODgwNzExOSwxNCAxMC41LDE0IEM5LjExOTI4ODA2LDE0IDgsMTUuMTE5Mjg4MSA4LDE2LjUgQzgsMTcuODgwNzExOSA5LjExOTI4ODA2LDE5IDEwLjUsMTkgTDEwLjUsMTkgWiIgaWQ9ImNlcnRpZmljYXRlIi8+PC9nPjwvZz48L3N2Zz4=',
    '2'
  );
  add_submenu_page('plugin-options', 'Xem danh sách', 'Xem danh sách', 'manage_options', 'plugin-options-view-hoso', 'addXemDanhSachMenu');
  add_submenu_page('plugin-options', 'Cập nhật thông tin', 'Cập nhật thông tin', 'manage_options', 'plugin-options-update-hoso', 'addCapNhatDanhSachMenu');
  add_submenu_page('plugin-options', 'Xuất thông tin', 'Xuất thông tin', 'manage_options', 'plugin-options-export-hoso', 'addXuatDanhSachMenu');
  add_submenu_page('plugin-options', 'Xoá thông tin', 'Xoá thông tin', 'manage_options', 'plugin-options-delete-hoso', 'addXoaDanhSachMenu');
  remove_submenu_page('plugin-options', 'plugin-options');
}

/**
 * Thêm nội dung cho menu Cập nhật thông tin văn bằng
 */
function addCapNhatDanhSachMenu()
{
  require('template/menu-update-page.php');
}

/**
 * Thêm nội dung cho menu Xuất thông tin văn bằng
 */
function addXuatDanhSachMenu()
{
  require('template/menu-export-page.php');
}

/**
 * Thêm nội dung cho menu Xem thông tin văn bằng
 */
function addXemDanhSachMenu()
{
  require('template/menu-view-page.php');
}

/**
 * Thêm nội dung cho menu Xoá thông tin văn bằng
 */
function addXoaDanhSachMenu()
{
  require('template/menu-delete-page.php');
}


add_action('admin_menu', 'add_admin_menu');
