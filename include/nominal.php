<?php  
include __DIR__ . '/../include/conecta.php';
include __DIR__ . '/../include/funciones.php';

?>
<!DOCTYPE html>
<html>
<head>
	<title>Listados Nominales</title>
<link rel="stylesheet" type="text/css" href="estilo.css">
<link rel="shortcut icon" type="image/x-icon" href="reglog/public/favicon.ico">
</head>

	<header>
		<h2>Nominales</h2>
		<p>Lista de casos activos nominalizados por área operativa ordenados por fecha.
		<a href="/reglog/include/webpag.php" class="button">Volver</a></p>
		</header>
	<body>	
	<?php  
		$result = findAll($connect, 'AREAS');
		
		$AOPS=[];	
		foreach ($result as $AOP) {
			
			$AOPS[] = [
		'num' =>  $AOP['Ao_Id'],
		'Nombre' => $AOP['Ao_Nom'],
	];
	
		}
		
	?>
	<form method="post">
                
          	<select name = "listaAOPS" id ="listaAOPS" > 
             <option value = 0 >SELECCIONE AOP</option>

             <?php foreach ($AOPS as $value ) {
             echo '<option value ='. $value['num'].'>'. $value['Nombre'].'</option>' ;
             }

             ?>   	
             	
				<input type="submit" value="Listar" >
             </select>
             
    </form>
	
		Elegiste <?php echo "" . ' el AO  ' . $_POST['listaAOPS']?>
	<?php




			try {


			
			
			$sql='Select NotId AS IdNoti, DATE_FORMAT(NotFecha , "%d/%m/%Y") AS Fecha, ApeNom As Nombre,
	ROUND(DATEDIFF(NotFecha,FechaNto)/30.44) AS meses, Ao_Nom AS AOP, ROUND(NotPeso,2) AS Peso, 
    NotTalla AS Talla, ROUND(NotZpe,2) AS ZPesoEdad ,ROUND(NotZta,2)  AS ZTallaEdad ,
 	ROUND(NotZimc,2) AS ZIMCEdad , MotNom, SevoNom, SclinNom,@tabla:="Notificación" AS Tipo, 
    if(NotFin="SI","Alta","Activo") AS Estado, NotFecha AS Ordena, 
    if(NotMatricula="SIN DATO","NO","SI") AS Medico, Aoresi,NotFin,IdCtrol,NotFin, TIMESTAMPDIFF(DAY, NotFecha, now()) AS dias_transcurridos,
    DATEDIFF( NotFechaSist, NotFecha) as retraso,
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
 AS Clacificación,
CASE
	WHEN  TIMESTAMPDIFF(DAY, NotFecha, now()) < 30
    THEN "1FFA04"
	WHEN TIMESTAMPDIFF(DAY, NotFecha, now()) >= 30 AND TIMESTAMPDIFF(DAY, NotFecha, now()) <= 60
    THEN "FFFA0A"
	WHEN TIMESTAMPDIFF(DAY, NotFecha, now()) >60
    THEN "FA1804"  
END 
AS color
from NOTIFICACION 
left join NIÑOS on NotNiño=IdNiño
left join SEGUNEVOLUCION on NotEvo = SevoId
left join SEGUNCLINICA on NotClinica = SclinId
left join MOTIVOSNOTI on NotMotivo = MotId
left join AREAS on Aoresi=Ao_Id
left join NOTICONTROL on NotId=IdNoti
where Aoresi= '.$_POST['listaAOPS'].' AND NotFin="NO" AND IdCtrol IS null

UNION
select t.IdNoti, DATE_FORMAT(t.CtrolFecha , "%d/%m/%Y") AS Fecha, ApeNom As Nombre,
	ROUND(DATEDIFF(t.CtrolFecha,FechaNto)/30.44) AS meses, Ao_Nom AS AOP, ROUND(t.CtrolPeso,2) AS Peso,
	CtrolTalla AS Talla, ROUND(t.CtrolZp,2) AS ZPesoEdad ,ROUND(t.CtrolZt,2)  AS ZTallaEdad , 
    ROUND(t.CtrolZimc,2) AS ZIMCEdad , MotNom, SevoNom, SclinNom,
	@tabla:="Control" AS Tipo,if(NotFin="SI","Alta","Activo") AS Estado, @ordena:=CtrolFecha,
	if(CtrolMatricula="SIN DATO","NO","SI") AS Medico,Aoresi,NotFin,IdCtrol,NotFin, TIMESTAMPDIFF(DAY, CtrolFecha, now()) AS dias_transcurridos,
	DATEDIFF(CtrolFechapc,CtrolFecha) AS retraso ,
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
AS Clacificación,
CASE
	WHEN  TIMESTAMPDIFF(DAY,CtrolFecha , now()) < 30
    THEN "1FFA04"
	WHEN TIMESTAMPDIFF(DAY, CtrolFecha, now()) >= 30 AND TIMESTAMPDIFF(DAY, CtrolFecha, now()) <= 60
    THEN "FFFA0A"
	WHEN TIMESTAMPDIFF(DAY, CtrolFecha, now()) >60
    THEN "FA1804"
    
END 
AS color
				from NOTICONTROL t
                inner join NOTIFICACION on IdNoti=NotId
				inner join NIÑOS on NotNiño=IdNiño
                  inner join (select IdNoti, max(CtrolFecha) as MaxdateCtrl
				  from NOTICONTROL
				  group by IdNoti)
                  tm on t.IdNoti= tm.IdNoti and t.CtrolFecha = tm.MaxDateCtrl           
				inner join SEGUNEVOLUCION on NotEvo = SevoId
				inner join SEGUNCLINICA on NotClinica = SclinId
				inner join MOTIVOSNOTI on NotMotivo = MotId
				inner join AREAS on Aoresi=Ao_Id
								where Aoresi= '.$_POST['listaAOPS'].' AND NotFin="NO" 
                                GROUP BY Nombre
                                order by Ordena desc;';			

				
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
    <td><?= htmlspecialchars($caso['Nombre'], ENT_QUOTES, 'UTF-8'); ?></td>
    <td><?= htmlspecialchars($caso['meses'], ENT_QUOTES, 'UTF-8'); ?></td>
    
    <td><?= htmlspecialchars($caso['Tipo'], ENT_QUOTES, 'UTF-8'); ?></td>
    <td><?= htmlspecialchars($caso['MotNom'], ENT_QUOTES, 'UTF-8'); ?></td>
    <td><?= htmlspecialchars($caso['ZPesoEdad'], ENT_QUOTES, 'UTF-8'); ?></td>
    <td><?= htmlspecialchars($caso['ZTallaEdad'], ENT_QUOTES, 'UTF-8'); ?></td>
    <td><?= htmlspecialchars($caso['ZIMCEdad'], ENT_QUOTES, 'UTF-8'); ?></td>
    <td><?= htmlspecialchars($caso['Clacificación'], ENT_QUOTES, 'UTF-8'); ?></td>
    <td><?= htmlspecialchars($caso['Medico'], ENT_QUOTES, 'UTF-8'); ?></td>
  	<td style= "background-color: #<?= htmlspecialchars($caso['color'], ENT_QUOTES, 'UTF-8'); ?>">
  	  	 	<?= htmlspecialchars($caso['dias_transcurridos'], ENT_QUOTES, 'UTF-8'); ?></td>
 	<td><?= htmlspecialchars($caso['retraso'], ENT_QUOTES, 'UTF-8'); ?></td>
   
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>
	<?='del área operativa de '. $caso['AOP'].  ' al día ' . date("d-m-Y "); ?>		
	<?php endif; ?>
</div>

</body>
</html>

<a href=""></a>


