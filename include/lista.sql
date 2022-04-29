Select NotId AS IdNoti, DATE_FORMAT(NotFecha , "%d/%m/%Y") AS Fecha, ApeNom As Nombre,Etnia, ResiDire, IdNiño,
	 Ao_Nom AS AOP, @tabla:="Notificación" AS Tipo, 
    if(NotFin="SI","Alta","Activo") AS Estado, NotFecha AS Ordena, 
    if(NotMatricula="SIN DATO","NO","SI") AS Medico, Aoresi,NotFin,IdCtrol,NotFin, TIMESTAMPDIFF(DAY, NotFecha, now()) AS dias_transcurridos,
    DATEDIFF( NotFechaSist, NotFecha) as retraso,  CONCAT(Ape,", ",Nom) AS vigilante





    
from NOTIFICACION 
left join NIÑOS on NotNiño=IdNiño
left join SEGUNEVOLUCION on NotEvo = SevoId
left join SEGUNCLINICA on NotClinica = SclinId
left join MOTIVOSNOTI on NotMotivo = MotId
left join AREAS on Aoresi=Ao_Id
left join NOTICONTROL on NotId=IdNoti
inner join NIÑORESIDENCIA on IdNiño =ResiNiño
inner join USUARIOS on NotUsuario = Idusuario
where Aoresi= '9' AND NotFin="NO" AND IdCtrol IS null

UNION
select t.IdNoti, DATE_FORMAT(t.CtrolFecha , "%d/%m/%Y") AS Fecha, ApeNom As Nombre,Etnia, ResiDire, IdNiño,
	 Ao_Nom AS AOP,
	@tabla:="Control" AS Tipo,if(NotFin="SI","Alta","Activo") AS Estado, @ordena:=CtrolFecha,
	if(CtrolMatricula="SIN DATO","NO","SI") AS Medico,Aoresi,NotFin,IdCtrol,NotFin, TIMESTAMPDIFF(DAY, CtrolFecha, now()) AS dias_transcurridos,
	DATEDIFF(CtrolFechapc,CtrolFecha) AS retraso ,  CONCAT(Ape,", ",Nom)  AS vigilante

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
				inner join NIÑORESIDENCIA on IdNiño =ResiNiño
				inner join USUARIOS on CtrolUsuario = Idusuario
								where Aoresi= 9 AND NotFin="NO" 
                                GROUP BY Nombre
                                order by Ordena desc;