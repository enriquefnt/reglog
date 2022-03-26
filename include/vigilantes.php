<?php  
include __DIR__ . '/../include/conecta.php';
?>

	<?php




			try {

			
			
			$sql='call Actividad;';			

				
				$casos = $connect->query($sql);
			
			
				
			
			}

			catch (PDOException $e) {
			$error = 'Error en la base:' . $e->getMessage() . ' en la linea ' .
			$e->getFile() . ':' . $e->getLine();
		}
		?>
		
	<?php  

include __DIR__ . '/../include/vigilantes.html.php';

	?>
	