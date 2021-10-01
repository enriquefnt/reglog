<?php  
include __DIR__ . '/../include/conecta.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title>Vigilantes</title>

<link rel="stylesheet" type="text/css" href="estilo.css">
<link rel="shortcut icon" type="image/x-icon" href="public/favicon.ico">

</head>

	<header>
		<h2>Actividad de vigilantes</h2>
		<p>Cargas en el sistema por vigilante, area operativa y mes.
		<a href="/reglog/include/webpag.php" class="button">Volver</a>
		</p>
	</header>

	<body>

	<?php
			try {
						
			$sql='SELECT IdNiño, UsuId AS idVigilante, NotAo AS AoCarga, NotFecha AS Fecha ,
if(NotFin="SI","Alta","Activo") AS Estado,
@tabla:="Notificación" AS Tipo


from NOTIFICACION

inner join NIÑOS on NotNiño=IdNiño 

 UNION
 
select IdNiño, CtrolUsuario AS idVigilante, CtrolAo AS AoCarga, CtrolFecha AS Fecha ,
if(NotFin="SI","Alta","Activo") AS Estado,
@tabla:="Control" AS Tipo

from NOTICONTROL
inner join NOTIFICACION on IdNoti=NotId
inner join NIÑOS on NotNiño=IdNiño;



		';
					

				$casos = $connect->query($sql);
			
			
			
				
			
			}

			catch (PDOException $e) {
			$error = 'Error en la base:' . $e->getMessage() . ' en la linea ' .
			$e->getFile() . ':' . $e->getLine();
		}
		?>
<?php if (isset($error)): ?>

			<p>
				<?php echo $error; ?>
			</p>

		<?php else: ?>
		
			
	<?php foreach ($casos as $caso): ?>


	<p><?= $caso['AoCarga']."  ".$caso['Estado']; ?></p>

	<?php endforeach; ?>
	<?php endif; ?>
</body>
</html>
