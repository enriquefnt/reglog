<?php  

include __DIR__ . '/../include/conecta.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title>Últimos Casos</title>

<link rel="stylesheet" type="text/css" href="estilo.css">
<link rel="shortcut icon" type="image/x-icon" href="public/favicon.ico">
</head>

	<header>
		<h2>Últimos movimientos</h2>
		<p>Lista de los últimos 15 movimientos en el sistema
	<a href="/reglog/include/webpag.php" class="button">  Volver</a>
	
		</p>
	</header>

	<body>

	
	<div>
			<table id="managerTable">
				<tbody>
	<thead>
  <tr>
  	<th>Fecha</th>
    <th>Nombre</th>
    <th>Edad (meses)</th>
    <th>Area</th>
    <th>Tipo</th>
    <th>Motivo de notificación</th>
    <th>Z Peso/edad</th>
    <th>Z Talla/edad</th>
    <th>Z IMC/edad</th>
    <th>Clasificacion</th>
    <th>Control Médico</th>
    <th>Estado</th>
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
		
	
	<?php foreach ($casos as $caso): ?>
  <tr>
    <td><?= htmlspecialchars($caso['Fecha'], ENT_QUOTES, 'UTF-8'); ?></td>
    <td>
    	
		<form target="_blank"  action="controles_caso.php" 	method="post">
			<input type="hidden" name="IdNiño" value="<?= htmlspecialchars($caso['IdNiño'], 
			  ENT_QUOTES, 'UTF-8'); ?>">
			<input type="submit" class="button" value="<?= htmlspecialchars($caso['Nombre'], ENT_QUOTES, 'UTF-8'); ?>">
		</form>	






    </td>
    <td align="center"><?=  htmlspecialchars($caso['meses'], ENT_QUOTES, 'UTF-8'); ?></td>
    <td><?= htmlspecialchars($caso['AOP'], ENT_QUOTES, 'UTF-8'); ?></td>
    <td><?= htmlspecialchars($caso['Tipo'], ENT_QUOTES, 'UTF-8'); ?></td>
    <td><?= htmlspecialchars($caso['MotNom'], ENT_QUOTES, 'UTF-8'); ?></td>
    <td align="center"><?= htmlspecialchars($caso['ZPesoEdad'], ENT_QUOTES, 'UTF-8'); ?></td>
    <td align="center"><?= htmlspecialchars($caso['ZTallaEdad'], ENT_QUOTES, 'UTF-8'); ?></td>
    <td align="center"><?= htmlspecialchars($caso['ZIMCEdad'], ENT_QUOTES, 'UTF-8'); ?></td>
    <td><?= htmlspecialchars($caso['Clacificación'], ENT_QUOTES, 'UTF-8'); ?></td>
    <td align="center"><?= htmlspecialchars($caso['Medico'], ENT_QUOTES, 'UTF-8'); ?></td>
    <td><?= htmlspecialchars($caso['Estado'], ENT_QUOTES, 'UTF-8'); ?></td>
    <td><?= htmlspecialchars($caso['vigilante'], ENT_QUOTES, 'UTF-8'); ?></td>
    <td align="center"><?= htmlspecialchars($caso['retraso'], ENT_QUOTES, 'UTF-8'); ?></td>
  </tr>
  <?php endforeach; ?>
  </tbody>
</table>
			
	<?php endif; ?>
</div>
</body>
</html>
