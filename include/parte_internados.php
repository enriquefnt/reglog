<?php
include __DIR__ . '/conecta.php';
include __DIR__ . '/funciones.php';
//session_start();


   try {
      if (isset($_POST['AOP'])){

      $sql='call MSP_NUTRICION.Parte_internados('.$_POST['Fecha'].','.$_POST['AOP'].');';

      $internados = $connect->query($sql);


}
$result = findAll($connect, 'AREAS','Ao_Nom');

$title = 'Internación';

ob_start();
include __DIR__ . '/../templates/parte_internados.html.php';
$output = ob_get_clean() ;

}
  
catch (PDOException $e) {
      $error = 'Error en la base:' . $e->getMessage() . ' en la linea ' .
      $e->getFile() . ':' . $e->getLine();
    }
   

include  __DIR__ . '/../templates/layout.html.php';
?>

