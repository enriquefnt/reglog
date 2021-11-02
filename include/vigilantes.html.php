
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
		<form action="" method="post">
      <label for="AopZ">Zona:</label><br>
      <select   name="Aopz" id="Aopz" >
        <option value="">-- Seleccione Zona --</option>
        <option value="1">Centro</option>
        <option value="2">Norte</option>
        <option value="3">Oeste</option>
        <option value="4">Sur</option>
      </select><br><br>
     
      <select name="Anio" id="Anio">
   <option value="">-- Seleccione el año --</option>      
  <label for="Anio">Año:</label><br>
  <option value="2015">2015</option>
  <option value="2016">2016</option>
  <option value="2017">2017</option>
  <option value="2018">2018</option>
  <option value="2019">2019</option>
  <option value="2020">2020</option>
  <option value="2021">2021</option>
  <option value="2022">2022</option>
  </select><br>
    <input type="submit"  class="button"  name="Listar">
    </form>
    </header>
    <main>
	<?php 
 
    
  
  $Zona = $_POST['Aopz'];
  $Año = $_POST['Anio'];
  


  $Zonas ;

switch ($Zona) {
  case "1":
    $Zonas="Centro";
    break;
  case "2":
    $Zonas="Norte";
    break;
  case "3":
        $Zonas="Oeste";
    break;
    case "4":
        $Zonas="Sur";
    break;
  default:
    $Zonas="No seleccionada";
}
?>
 
	<div>

				
			<table id="tbl_exporttable_to_xls">
				
        <tbody>
	<thead>
  <tr>
  	<th>Area Operativa</th>
    <th>Nombre</th>
    <th>Mes</th>
    
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
   <?php if($caso['Anio']==$Año AND  $caso['Ao_Zna']==$Zona){?>
  <tr class="trclear">
    <td><?= htmlspecialchars($caso['Ao_Nom'], ENT_QUOTES, 'UTF-8'); ?></td>
    <td><?= htmlspecialchars($caso['Nombre'], ENT_QUOTES, 'UTF-8'); ?>
    <td><?= htmlspecialchars($caso['mes'], ENT_QUOTES, 'UTF-8'); ?></td>
    
    <td align="center"><?= htmlspecialchars($caso['Notificaciones'], ENT_QUOTES, 'UTF-8'); ?></td>
        <td><?= htmlspecialchars($caso['Controles'], ENT_QUOTES, 'UTF-8'); ?></td>
    <td><?= htmlspecialchars($caso['Altas'], ENT_QUOTES, 'UTF-8'); ?></td>
    <td align="center"><?= htmlspecialchars($caso['Total'], ENT_QUOTES, 'UTF-8'); ?></td>
        
   </tr>
   <?php } ?>
  <?php endforeach; ?>
  <h2><?=' Del Año: '. $Año .' De Zona: '.$Zonas .' Al día: ' . date("d-m-Y "); ?></h2>
  <button class="button" onclick="ExportToExcel('xlsx')">
   <i class="fas fa-download"></i>
   Descargar xlsx
</button>

  <?php endif; ?>

  </tbody>
</table>
			
	
</div>
  </main>
<script type="text/javascript" src="descarga.js"></script> 



<script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous"></script>
    <script src="mergeTable.js"></script>
    <script>
        $('#tbl_exporttable_to_xls').margetable({
            colindex:[{
               index:0
          },{
             index:1,
              dependent:[0]
          },{
              index:2,
             dependent:[0,1]
          }]
       });
        $('#textTable').margetable({
            type: 2,
            colindex: [0, 1, 3]
        });
    </script>
</body>

</html>