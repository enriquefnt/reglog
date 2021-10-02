
<!DOCTYPE html>
<html>
<head>
	<title>Actividad Vigilantes</title>
<link rel="stylesheet" type="text/css" href="estilo.css">
<link rel="shortcut icon" type="image/x-icon" href="public/favicon.ico">
<script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
   <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body>  
	<header >
		<h2>Vigilantes</h2>
		<p>Actividad de registro en el sistema de los Vigilantes por áreas operativas</p>
		<a href="/reglog/include/webpag.php" class="button">Volver</a></p>
		</header>
	
	<div>
			
				
			<table id="tbl_exporttable_to_xls">
				
        <tbody>
	<thead>
  <tr>
  	<th>Area Operativa</th>
    <th>Año</th>
    <th>Mes</th>
    <th>Nombre</th>
    <th>Notificaciones</th>
    <th>Controles</th>
    <th>Egresos</th>
    <th>Total</th>
  </tr>
  </thead>
  <tbody>
  
 <?php if (isset($error)): ?>

      <p>
        <?php echo $error; ?>
      </p>

    <?php else: ?>
    
  
  <?php foreach ($casos as $caso): ?>
   <?php if($caso['Anio']==2016){?>
  <tr>
    <td><?= htmlspecialchars($caso['Ao_Nom'], ENT_QUOTES, 'UTF-8'); ?></td>
    <td><?= htmlspecialchars($caso['Anio'], ENT_QUOTES, 'UTF-8'); ?></td>
    <td><?= htmlspecialchars($caso['mes'], ENT_QUOTES, 'UTF-8'); ?></td>
    <td><?= htmlspecialchars($caso['Nombre'], ENT_QUOTES, 'UTF-8'); ?>
    <td align="center"><?= htmlspecialchars($caso['Notificaciones'], ENT_QUOTES, 'UTF-8'); ?></td>
        <td><?= htmlspecialchars($caso['Controles'], ENT_QUOTES, 'UTF-8'); ?></td>
    <td><?= htmlspecialchars($caso['Altas'], ENT_QUOTES, 'UTF-8'); ?></td>
    <td align="center"><?= htmlspecialchars($caso['Total'], ENT_QUOTES, 'UTF-8'); ?></td>
        
   </tr>
   <?php } ?>
  <?php endforeach; ?>
  <h2><?='Al día ' . date("d-m-Y "); ?></h2>
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




