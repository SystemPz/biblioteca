<?php

	session_start();
	
	if (!isset($_SESSION['user_session'])) {
		header("Location: index.php");
	} else if(isset($_SESSION['user_session'])!="") {
		header("Location: inicio.php");
	}
	
	if (isset($_GET['logout'])) {
		unset($_SESSION['user_session']);
		session_unset();
		session_destroy();
		header("Location: index.php");
		exit;
	}