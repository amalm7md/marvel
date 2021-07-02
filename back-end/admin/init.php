<?php

	include 'connect.php';

	//Routes

	$tpl = 'includes/templates/';
	$lang = 'includes/languages/';
	$func = 'includes/functions/';
	$css = 'layout/css/';
	$js = 'layout/js/';
	


	//include important files

	include $func . 'functions.php';
	include $lang . 'english.php';
	include $tpl . 'header.php'; 
	
	// include navbar on All pages except the one with noNavbar variable (login page (index))
	if(!isset($noNavbar)) { include $tpl . 'navbar.php'; }
	?>

