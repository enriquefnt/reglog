<?php

try {
$connect = new PDO('mysql:host=200.45.111.99;dbname=MSP_NUTRICION;
charset=utf8', 'SiViNSalta', '@#sivin#@salta!%2020&&');
$connect->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

}
catch(PDOException $e) {
	echo $e->getMessage(). 'Re intente en unos momentos';
}

?>
