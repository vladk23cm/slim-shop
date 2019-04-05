<?php
session_start();

function dd($data){
	echo '<pre>';
	print_r($data);
	echo '</pre>';
	die;
}
define('ROOT', __DIR__);
require 'bootsrap/app.php';