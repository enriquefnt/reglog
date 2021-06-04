<?php
	require 'conecta.php';
	session_destroy();

	header('Location: login.php');
?>
