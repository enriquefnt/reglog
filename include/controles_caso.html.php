<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Caso</title>
	<link rel="stylesheet" type="text/css" href="estilo.css">
</head>
<body>
	

		<div>

			<table class="table">
				<tbody>
	<thead>
  <tr>
  	<th>Fecha</th> 
    <th>Edad (meses)</th> 
     <th>Peso</th> 
      <th>Talla</th> 
    <th>Z Peso/edad</th>
    <th>Z Talla/edad</th>
    <th>Z IMC/edad</th>
     <th>Clasificación</th>
    <th>Control Médico</th>
    <th>Vigilante</th>
  </tr>
  </thead>
  <tbody>
  <?php if (isset($error)): ?>

			<p>
				<?php echo $error; ?>
			</p>

		<?php else: ?>
		
			
	<?php foreach ($controles as $control): ?>
  <tr>
    <td align="center"><?= htmlspecialchars($control['Fecha'], ENT_QUOTES, 'UTF-8'); ?></td>
    
    <td align="center"><?= htmlspecialchars($control['meses'], ENT_QUOTES, 'UTF-8'); ?></td>
       <td align="center"><?= htmlspecialchars($control['Peso'], ENT_QUOTES, 'UTF-8'); ?></td>
       <td align="center"><?= htmlspecialchars($control['Talla'], ENT_QUOTES, 'UTF-8'); ?></td>
    <td align="center"><?= htmlspecialchars($control['ZPesoEdad'], ENT_QUOTES, 'UTF-8'); ?></td>
    <td align="center"><?= htmlspecialchars($control['ZTallaEdad'], ENT_QUOTES, 'UTF-8'); ?></td>
    <td align="center"><?= htmlspecialchars($control['ZIMCEdad'], ENT_QUOTES, 'UTF-8'); ?></td>
     <td align="center"><?= htmlspecialchars($control['Clasificacion'], ENT_QUOTES, 'UTF-8'); ?></td>
     <td align="center"><?= htmlspecialchars($control['Médico'], ENT_QUOTES, 'UTF-8'); ?></td>
  	<td align="center"><?= htmlspecialchars($control['vigilante'], ENT_QUOTES, 'UTF-8'); ?></td>
 
   
    </tr>
  <?php endforeach; ?>
  <h2>Historial de controles de: <?= htmlspecialchars($control['Nombre'], ENT_QUOTES, 'UTF-8'); ?> </h2>
  
  <?php endif; ?>
  </tbody>
</table>
	
	
</div>
		
	
<footer>
  
  <Input type = "button" class="button" value = "Volver al listado" onclick = "window.close ()">
  
 </footer>
</body>
</html>
 