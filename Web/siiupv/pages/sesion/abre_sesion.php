<?php
	session_start();
	if (!isset($_SESSION['usuario'])) {
		header('Location: http://eldelmomo.me/Web/siiupv/login.php');
		exit;
	}
 ?>
