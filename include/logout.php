<?php
	require 'conecta.php';
	session_destroy();

	header('Location: /reglog/public/index.php');
?>
