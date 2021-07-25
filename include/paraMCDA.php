<?php  
include __DIR__ . '/../include/conecta.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title>Para MCDA</title>

<link rel="stylesheet" type="text/css" href="estilo.css">
<link rel="shortcut icon" type="image/x-icon" href="public/favicon.ico">

</head>

	<header>
		<h2>Para MCDA</h2>
		<p>Notificaciones de casos clasificados como "Agudos" notificados en los últimos 60 días para evaluar MCDA
		<a href="/reglog/include/webpag.php" class="button">Volver</a>
		</p>
	</header>

	<body>

	<?php
			try {
						
			$sql='
			Select  DATE_FORMAT(NotFecha , "%d/%m/%Y") AS Fecha, ApeNom As Nombre,ROUND(DATEDIFF(NotFecha,FechaNto)/30.44) AS meses, FechaNto, SUBSTRING(Sexo,1,1) AS Sex, Ao_Nom AS AOP, NotPeso AS Peso,  NotTalla AS Talla, ROUND(NotZpe,2) AS ZPesoEdad ,ROUND(NotZta,2)  AS ZTallaEdad ,
 ROUND(NotZimc,2) AS ZIMCEdad , MotNom, SevoNom, SclinNom,  if(NotFin="SI","Alta","Activo") AS Estado, 
 if(NotMatricula="SIN DATO","NO","SI") AS Medico, NotFecha AS Ordena,
    CASE
    WHEN  
    (NotZpe > 7 OR NotZimc > 7 OR NotZta > 7 OR 
			NotZpe < -7 OR NotZimc < -7 OR NotZta < -7) 
        THEN "Medida erronea"  
	WHEN NotZimc <-3  AND NotZta <= -2 AND (NotClinica <> 2  OR MotId <> 3)
        THEN "Cronico Agudizado Severo"  
		
	WHEN (NotZimc >-3 AND NotZimc <=-2)   AND NotZta <= -2 AND (NotClinica <> 2  OR MotId <> 3)
        THEN "Cronico Agudizado Moderado"  		
    WHEN 
    NotZimc <=-3 OR NotClinica= 2  OR MotId = 3 
        THEN "Agudo Severo"
    WHEN 
    (NotZimc >-3 AND NotZimc <=-2)   OR (NotZpe < -2 AND NotZta > -2) 
        THEN "Agudo Moderado"
      
    WHEN (NotZimc >-2  OR NotEvo = 2 )  AND NotZta <= -2 
        THEN "Cronico"
	WHEN  NotMotivo = 2 AND  NotZpe > -2 
        THEN "Curva anormal"
	WHEN  NotZpe > -2 AND NotZimc >-2 AND NotZta >-2
        THEN "Sin deficit"
     
            
END
 AS Clasificacion 
 

from NOTIFICACION 
inner join NIÑOS on NotNiño=IdNiño
inner join SEGUNEVOLUCION on NotEvo = SevoId
inner join SEGUNCLINICA on NotClinica = SclinId
inner join MOTIVOSNOTI on NotMotivo = MotId
inner join AREAS on Aoresi=Ao_Id
where NotFecha  > now() - INTERVAL 60 day 
AND (NotZimc < -2 OR MotId = 3)
AND NotFin = "NO" 
AND (DATEDIFF(NotFecha,FechaNto)/30.44) > 6
order by  ordena desc ;';
					

				$casos = $connect->query($sql);
			
			
			
				
			
			}

			catch (PDOException $e) {
			$error = 'Error en la base:' . $e->getMessage() . ' en la linea ' .
			$e->getFile() . ':' . $e->getLine();
		}
		?>

	
	<div>
			<table >
				<tbody>
	<thead>
  <tr>
  	<th>Fecha</th>
    <th>Nombre</th>
    <th>Edad (meses)</th>
    <th>Area</th>
    <th>Motivo de notificación</th>
    <th>Peso</th>
    <th>Talla</th>
    <th>Z Peso/edad</th>
    <th>Z Talla/edad</th>
    <th>Z IMC/edad</th>
    <th>Clasificacion</th>
    <th>Control Médico</th>
    
  </tr>
  </thead>
  <tbody>
  <?php if (isset($error)): ?>

			<p>
				<?php echo $error; ?>
			</p>

		<?php else: ?>
		
			<ul>
	<?php foreach ($casos as $caso): ?>
  <tr>
    <td><?= htmlspecialchars($caso['Fecha'], ENT_QUOTES, 'UTF-8'); ?></td>
    <td class="button"><?=  htmlspecialchars($caso['Nombre'], ENT_QUOTES, 'UTF-8'); ?></td>
    <td align="center"><?=  htmlspecialchars($caso['meses'], ENT_QUOTES, 'UTF-8'); ?></td>
    <td><?= htmlspecialchars($caso['AOP'], ENT_QUOTES, 'UTF-8'); ?></td>
    
    <td><?= htmlspecialchars($caso['MotNom'], ENT_QUOTES, 'UTF-8'); ?></td>

    <td align="center"><?= htmlspecialchars($caso['Peso'], ENT_QUOTES, 'UTF-8'); ?></td>
	<td align="center"><?= htmlspecialchars($caso['Talla'], ENT_QUOTES, 'UTF-8'); ?></td>

    <td align="center"><?= htmlspecialchars($caso['ZPesoEdad'], ENT_QUOTES, 'UTF-8'); ?></td>
    <td align="center"><?= htmlspecialchars($caso['ZTallaEdad'], ENT_QUOTES, 'UTF-8'); ?></td>
    <td align="center"><?= htmlspecialchars($caso['ZIMCEdad'], ENT_QUOTES, 'UTF-8'); ?></td>
    <td><?= htmlspecialchars($caso['Clasificacion'], ENT_QUOTES, 'UTF-8'); ?></td>
    <td align="center"><?= htmlspecialchars($caso['Medico'], ENT_QUOTES, 'UTF-8'); ?></td>
    
  </tr>
  <?php endforeach; ?>
  </tbody>
</table>
			
	<?php endif; ?>
</div>
</body>
</html>
