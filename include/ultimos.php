<?php  

include __DIR__ . '/../include/conecta.php';
?>


	<?php
			try {
						
			$sql='
			Select  DATE_FORMAT(NotFecha , "%d/%m/%Y") AS Fecha, ApeNom As Nombre,

		IF (NotFecha <> "31/12/25",floor(DATEDIFF(NotFecha, FechaNto)/365.25),floor(DATEDIFF(CURDATE(), FechaNto)/365.25))  AS años,
		IF (NotFecha <> "31/12/25",floor((DATEDIFF(NotFecha, FechaNto)%365.25)/30.4375),floor((DATEDIFF(CURDATE(), FechaNto)%365.25)/30.4375))  AS meses,
		IF (NotFecha <> "31/12/25",floor(datediff(NotFecha, FechaNto) % 30.4375),floor(datediff(CURDATE(),FechaNto) % 30.4375))  AS dias




			, Ao_Nom AS AOP, NotPeso AS Peso,  NotTalla AS Talla, ROUND(NotZpe,2) AS ZPesoEdad ,ROUND(NotZta,2)  AS ZTallaEdad ,
 				ROUND(NotZimc,2) AS ZIMCEdad , MotNom, SevoNom, SclinNom,
 				@tabla:="Notificación" AS Tipo, if(NotFin="SI","Alta","Activo") AS Estado, NotFecha AS Ordena, if(NotMatricula="SIN DATO","NO","SI") AS Medico,
 				DATEDIFF( NotFechaSist, NotFecha) as retraso, IdNiño,  CONCAT(Ape,", ",Nom)  AS vigilante,
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
    (NotZimc >-3 AND NotZimc <=-2)   
        THEN "Agudo Moderado"
    WHEN 
		NotZpe < -2 AND NotZimc > -2 AND NotZta > -2 
        THEN "Ver curva"
      
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
inner join USUARIOS on NotUsuario = Idusuario
where NotFecha  > now() - INTERVAL 30 day

UNION
select DATE_FORMAT(CtrolFecha , "%d/%m/%Y") AS Fecha, ApeNom As Nombre,

IF (CtrolFecha <> "31/12/25",floor(DATEDIFF(CtrolFecha, FechaNto)/365.25),floor(DATEDIFF(CURDATE(), FechaNto)/365.25))  AS años,
IF (CtrolFecha <> "31/12/25",floor((DATEDIFF(CtrolFecha, FechaNto)%365.25)/30.4375),floor((DATEDIFF(CURDATE(), FechaNto)%365.25)/30.4375))  AS meses,
IF (CtrolFecha <> "31/12/25",floor(datediff(CtrolFecha, FechaNto) % 30.4375),floor(datediff(CURDATE(),FechaNto) % 30.4375))  AS dias



, Ao_Nom AS AOP, CtrolPeso AS Peso,  CtrolTalla AS Talla, ROUND(CtrolZp,2) AS ZPesoEdad ,ROUND(CtrolZt,2)  AS ZTallaEdad , ROUND(CtrolZimc,2) AS ZIMCEdad , MotNom, SevoNom, SclinNom,
	@tabla:="Control" AS Tipo,if(NotFin="SI","Alta","Activo") AS Estado, CtrolFecha AS Ordena,
	if(CtrolMatricula="SIN DATO","NO","SI") AS Medico,
	DATEDIFF(CtrolFechapc,CtrolFecha) AS retraso , IdNiño, CONCAT(Ape,", ",Nom)  AS vigilante,
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
    	(CtrolZimc >-3 AND CtrolZimc <=-2)   
        THEN "Agudo Moderado"
    WHEN 
  		CtrolZp < -2 AND CtrolZimc > -2 AND CtrolZt > -2 
        THEN "Ver curva"
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
				inner join USUARIOS on CtrolUsuario = Idusuario
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
<?php  

include __DIR__ . '/../templates/ultimos.html.php';
?>
	
	