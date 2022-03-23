
<!DOCTYPE html>
<html>
<head>
	<title>Listados Nominales</title>
<link rel="stylesheet" type="text/css" href="estilo.css">
<link rel="shortcut icon" type="image/x-icon" href="public/favicon.ico">
<script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
   <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>

	<header >
		<h2>Nominales</h2>
		<p>Lista de casos activos nominalizados por área operativa ordenados por fecha (click en el nombre para ver evolución del caso)
		<a href="/reglog/include/webpag.php" class="button">Volver</a></p>
		</header>
	<body>	
	<div>
			
				
			<table id="tbl_exporttable_to_xls">
				
        <tbody>
	<thead>
  <tr>
  	<th>Último registro</th>
    <th>Nombre</th>
   
    <th>Edad </th>
   
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
			
	<?php foreach ($casos as $caso): ?>
  <tr>
    <td><?= htmlspecialchars($caso['Fecha'], ENT_QUOTES, 'UTF-8'); ?></td>
    <td><?= htmlspecialchars($caso['Nombre'], ENT_QUOTES, 'UTF-8'); ?>

        <form target="_blank"  action="controles_caso.php"   method="post">
        <input type="hidden" name="IdNiño" value="<?= htmlspecialchars($caso['IdNiño'], 
          ENT_QUOTES, 'UTF-8'); ?>">
          
        <input type="submit" class="button1" value="...">
        
        </form> 
    </td>

    <td ><?= htmlspecialchars($caso['años'] .'A ' . $caso['meses'] .'M ' . $caso['dias'] .'D ', ENT_QUOTES, 'UTF-8'); ?></td>
    
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
  <button class="button" onclick="ExportToExcel('xlsx')">
   <i class="fas fa-download"></i>
   Descargar xlsx
</button>

  <?php endif; ?>
  </tbody>
</table>
			
	
</div>
<script type="text/javascript" src="descarga.js"></script> 
</body>
</html>




