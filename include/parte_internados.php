<?php
include __DIR__ . '/conecta.php';
include __DIR__ . '/funciones.php';
session_start();


   try {

$result = findAll($connect, 'AREAS','Ao_Nom');


$sql='call MSP_NUTRICION.Parte_internados("2022-05-07", 8);';

$internados = $connect->query($sql);

$title = 'Internación';

ob_start();


include __DIR__ . '/../templates/parte_internados.html.php';

//include __DIR__ . '/../templates/seleAOP.html.php';//}

$output = ob_get_clean() ;

}
  
catch (PDOException $e) {
      $error = 'Error en la base:' . $e->getMessage() . ' en la linea ' .
      $e->getFile() . ':' . $e->getLine();
    }
   

include  __DIR__ . '/../templates/layout.html.php';
?>

