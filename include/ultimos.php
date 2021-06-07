<?php  

include __DIR__ . '/../include/conecta.php';
include __DIR__ . '/../include/funciones.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title>Últimos Casos</title>

<link rel="stylesheet" type="text/css" href="estilo.css">
<link rel="shortcut icon" type="image/x-icon" href="reglog/public/favicon.ico">
</head>

	<header>
		<h2>Últimos movimientos</h2>
		<p>Lista de los últimos 15 movimientos en el sistema
	<a href="/reglog/include/webpag.php" class="button">  Volver</a>
	
		</p>
	</header>

	<body>

	<?php
			try {
						
			$sql='
			Select  DATE_FORMAT(NotFecha , "%d/%m/%Y") AS Fecha, ApeNom As Nombre,ROUND(DATEDIFF(NotFecha,FechaNto)/30.44) AS meses, Ao_Nom AS AOP, NotPeso AS Peso,  NotTalla AS Talla, ROUND(NotZpe,2) AS ZPesoEdad ,ROUND(NotZta,2)  AS ZTallaEdad ,
 				ROUND(NotZimc,2) AS ZIMCEdad , MotNom, SevoNom, SclinNom,
 				@tabla:="Notificación" AS Tipo, if(NotFin="SI","Alta","Activo") AS Estado, NotFecha AS Ordena, if(NotMatricula="SIN DATO","NO","SI") AS Medico,
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
 AS Clacificación

from NOTIFICACION 
inner join NIÑOS on NotNiño=IdNiño
inner join SEGUNEVOLUCION on NotEvo = SevoId
inner join SEGUNCLINICA on NotClinica = SclinId
inner join MOTIVOSNOTI on NotMotivo = MotId
inner join AREAS on Aoresi=Ao_Id
where NotFecha  > now() - INTERVAL 30 day

UNION
select DATE_FORMAT(CtrolFecha , "%d/%m/%Y") AS Fecha, ApeNom As Nombre,ROUND(DATEDIFF(CtrolFecha,FechaNto)/30.44) AS meses, Ao_Nom AS AOP, CtrolPeso AS Peso,  CtrolTalla AS Talla, ROUND(CtrolZp,2) AS ZPesoEdad ,ROUND(CtrolZt,2)  AS ZTallaEdad , ROUND(CtrolZimc,2) AS ZIMCEdad , MotNom, SevoNom, SclinNom,
	@tabla:="Control" AS Tipo,if(NotFin="SI","Alta","Activo") AS Estado, CtrolFecha AS Ordena,
	if(CtrolMatricula="SIN DATO","NO","SI") AS Medico,
				 CASE
				    WHEN  
    CtrolZp > 7 OR CtrolZimc > 7 OR CtrolZt > 7 OR
			CtrolZp < -7 OR CtrolZimc < -7 OR CtrolZt < -7
        THEN "Medida erronea"  
	WHEN CtrolZimc <-3  AND CtrolZt <= -2 AND CtrolClinica <> 2
        THEN "Cronico Agudizado Severo"  
		
	WHEN (CtrolZimc >-3 AND CtrolZimc <=-2)   AND CtrolZt <= -2 AND CtrolClinica <> 2
        THEN "Cronico Agudizado Moderado"  		
    WHEN 
    CtrolZimc <-3 OR  CtrolClinica = 2
        THEN "Agudo Severo"
    WHEN 
    (CtrolZimc >-3 AND CtrolZimc <=-2)  OR (CtrolZp < -2 AND CtrolZt > -2)
        THEN "Agudo Moderado"
    WHEN (CtrolZimc >-2  OR NotEvo = 2 )  AND CtrolZt <= -2 
        THEN "Cronico"
	WHEN  NotMotivo = 2 
        THEN "Curva anormal"
	WHEN  CtrolZp > -2 AND CtrolZimc >-2 AND CtrolZt >-2
        THEN "Sin deficit"
     
        
END 
AS Clacificación
				 from NOTICONTROL 
				inner join NOTIFICACION on IdNoti=NotId
				inner join NIÑOS on NotNiño=IdNiño
				inner join SEGUNEVOLUCION on NotEvo = SevoId
				inner join SEGUNCLINICA on NotClinica = SclinId
				inner join MOTIVOSNOTI on NotMotivo = MotId
				inner join AREAS on Aoresi=Ao_Id
				where CtrolFecha  > now() - INTERVAL 30 day 
				order by Ordena desc limit 15
				';
					

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
    <th>Tipo</th>
    <th>Motivo de notificación</th>
    <th>Z Peso/edad</th>
    <th>Z Talla/edad</th>
    <th>Z IMC/edad</th>
    <th>Clasificacion</th>
    <th>Control Médico</th>
    <th>Estado</th>
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
    <td><?=  htmlspecialchars($caso['Nombre'], ENT_QUOTES, 'UTF-8'); ?></td>
    <td><?=  htmlspecialchars($caso['meses'], ENT_QUOTES, 'UTF-8'); ?></td>
    <td><?= htmlspecialchars($caso['AOP'], ENT_QUOTES, 'UTF-8'); ?></td>
    <td><?= htmlspecialchars($caso['Tipo'], ENT_QUOTES, 'UTF-8'); ?></td>
    <td><?= htmlspecialchars($caso['MotNom'], ENT_QUOTES, 'UTF-8'); ?></td>
    <td><?= htmlspecialchars($caso['ZPesoEdad'], ENT_QUOTES, 'UTF-8'); ?></td>
    <td><?= htmlspecialchars($caso['ZTallaEdad'], ENT_QUOTES, 'UTF-8'); ?></td>
    <td><?= htmlspecialchars($caso['ZIMCEdad'], ENT_QUOTES, 'UTF-8'); ?></td>
    <td><?= htmlspecialchars($caso['Clacificación'], ENT_QUOTES, 'UTF-8'); ?></td>
    <td><?= htmlspecialchars($caso['Medico'], ENT_QUOTES, 'UTF-8'); ?></td>
    <td><?= htmlspecialchars($caso['Estado'], ENT_QUOTES, 'UTF-8'); ?></td>
  </tr>
  <?php endforeach; ?>
  </tbody>
</table>
			
	<?php endif; ?>
</div>
</body>
</html>
