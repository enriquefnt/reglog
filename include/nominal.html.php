<?php  
include __DIR__ . '/../include/conecta.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title>Listados Nominales</title>
<link rel="stylesheet" type="text/css" href="estilo.css">
<link rel="shortcut icon" type="image/x-icon" href="public/favicon.ico">
</head>

	<header >
		<h2>Nominales</h2>
		<p>Lista de casos activos nominalizados por área operativa ordenados por fecha (click en el nombre para ver evolución del caso)
		<a href="/reglog/include/webpag.php" class="button">Volver</a></p>
		</header>
	<body>	
	<div>
			
				
			<table id="managerTable">
				<tbody>
	<thead>
  <tr>
  	<th>Último registro</th>
    <th>Nombre</th>
    <th>Edad (meses)</th>
   
    <th>Tipo</th>
    <th>Motivo de notificación</th>
    <th>Z Peso/edad</th>
    <th>Z Talla/edad</th>
    <th>Z IMC/edad</th>
    <th>Clasificacion</th>
    <th>Control Médico</th>
    <th>Días sin registros</th>
    <th>Vigilante</th>
    <th>Demora en notificar (Días)</th>
  </tr>
  </thead>
  <tbody>
  <?php if (isset($error)): ?>

			<p>
				<?php echo $error; ?>
			</p>

		<?php else: ?>
		<?echo 'del área operativa de '. $caso['AOP']; ?>	
			<ul>
	<?php foreach ($casos as $caso): ?>
  <tr>
    <td><?= htmlspecialchars($caso['Fecha'], ENT_QUOTES, 'UTF-8'); ?></td>
    <td>
    
    	<form target="_blank"  action="controles_caso.php" 
    	method="post"
		>
		<input type="hidden" name="IdNiño" value="<?= htmlspecialchars($caso['IdNiño'], 
		  ENT_QUOTES, 'UTF-8'); ?>">
		<input type="submit" class="button" value="<?= htmlspecialchars($caso['Nombre'], ENT_QUOTES, 'UTF-8'); ?>">
		</form>	



    </td>
    <td align="center"><?= htmlspecialchars($caso['meses'], ENT_QUOTES, 'UTF-8'); ?></td>
    
    <td><?= htmlspecialchars($caso['Tipo'], ENT_QUOTES, 'UTF-8'); ?></td>
    <td><?= htmlspecialchars($caso['MotNom'], ENT_QUOTES, 'UTF-8'); ?></td>
    <td align="center"><?= htmlspecialchars($caso['ZPesoEdad'], ENT_QUOTES, 'UTF-8'); ?></td>
    <td align="center" ><?= htmlspecialchars($caso['ZTallaEdad'], ENT_QUOTES, 'UTF-8'); ?></td>
    <td align="center"><?= htmlspecialchars($caso['ZIMCEdad'], ENT_QUOTES, 'UTF-8'); ?></td>
    <td><?= htmlspecialchars($caso['Clacificación'], ENT_QUOTES, 'UTF-8'); ?></td>
    <td align="center"><?= htmlspecialchars($caso['Medico'], ENT_QUOTES, 'UTF-8'); ?></td>
  	<td align="center" style= "background-color: #<?= htmlspecialchars($caso['color'], ENT_QUOTES, 'UTF-8'); ?>">
  	  	 	<?= htmlspecialchars($caso['dias_transcurridos'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td align="center"><?= htmlspecialchars($caso['vigilante'], ENT_QUOTES, 'UTF-8'); ?></td>
 	<td align="center"><?= htmlspecialchars($caso['retraso'], ENT_QUOTES, 'UTF-8'); ?></td>
   
   </tr>
  <?php endforeach; ?>
  <h2><?='Area Operativa: '. $caso['AOP'].  ' al día ' . date("d-m-Y "); ?></h2>
  
  <?php endif; ?>
  </tbody>
</table>
			
	
</div>

</body>
</html>




