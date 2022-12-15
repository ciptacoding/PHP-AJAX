<?php
define('SITE_NAME', 'PHP-AJAX');
define('APP_ROOT', realpath(dirname(__FILE__)));
define('URL_ROOT', 'http://10-ajax-html.test/');
$conn = mysqli_connect('localhost', 'root', '', 'basic') or die(mysqli_connect_error());
