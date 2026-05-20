<?php
// public/index.php

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

define('ROOT_PATH', dirname(__DIR__));
define('APP_PATH', ROOT_PATH . '/app');
define('BASE_URL', '/PMNM_6BPM34_QLSV/public/'); // Sửa tên thư mục của bạn

require_once APP_PATH . '/core/App.php';

$app = new App();
?>