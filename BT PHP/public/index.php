<?php
// public/index.php

error_reporting(E_ALL);
ini_set('display_errors', 1);

define('ROOT_PATH', dirname(__DIR__));
define('APP_PATH', ROOT_PATH . '/app');
define('BASE_URL', '/BT_PHP/public/');  // Điều chỉnh theo tên thư mục

// Đường dẫn đến App.php trong thư mục core
require_once APP_PATH . '/core/App.php';

$app = new App();
?>