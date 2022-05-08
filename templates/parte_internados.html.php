<?php 
if (is_null($_SESSION['nombre'])) {
session_start();
}
?>

<?php
if ($_SESSION['tipo']== 1){

?>

<form action="" method="post">



  <label for="AOP">Seleccione el área operativa:</label>
 
   <select name="AOP" required="required" id="AOPe">
<option value=0>Seleccione AOP</option>
<?php
$aop = [];
  foreach ($result as $aop) {
 echo '<option value=' .  $aop['idaop'].'>' . $aop['areaoperativa'] .'</option>';
  }
?>
</select>
  
  <input type="submit"  value="Seleccionar">

</form>
<?php  } ?>
<div class="w3-responsive">
  <table class="w3-table-all w3-tiny">
<?php 

if (isset($_POST['AOP'])||isset($_SESSION['tipo'])) { ?>

			<thead>
			<tr class="w3-grey">
				<th>Nombre</th>
				<th>Edad (AMD)</th>
				<th>Fecha Último Control</th>
				<th>Peso (kg)</th>
				<th>Talla (cm)</th>
				<th>Z Peso/Edad</th>
				<th>Z Talla/Edad</th>
				<th>Z IMC/Edad</th>
				<th>Editar</th>
				<th>Ver controles</th>
			</tr>
		</thead>

	<?php } ?>



<?php 

if (isset($_POST['AOP'] )&& $_SESSION['tipo']==1) {
	$aop= $_POST['AOP'];
}

else {$aop=$_SESSION['AOP'];}

foreach ($casos as $caso): ?>
   <?php if  ($caso['idaop']==$aop) {?>

	<tbody>
		<tr class="w3-hover-pale-green">
	   		<td><?= htmlspecialchars($caso['Nombre'], ENT_QUOTES, 'UTF-8'); ?></td>
		    <td align="right"><?= htmlspecialchars($caso['años'] .'A ' . $caso['meses'] .'M ' . $caso['dias'] .'D ', ENT_QUOTES, 'UTF-8'); ?></td>
			<td><?= htmlspecialchars($caso['FechaCtrl'], ENT_QUOTES, 'UTF-8'); ?></td>
			<td align="center"><?= htmlspecialchars($caso['Peso'], ENT_QUOTES, 'UTF-8').' ('.$caso['ClaPe'].')'; ?></td>
			<td><?= htmlspecialchars($caso['Talla'], ENT_QUOTES, 'UTF-8').' ('.$caso['ClaTa'].')'; ?></td>
			<td><?= htmlspecialchars($caso['ZPE'], ENT_QUOTES, 'UTF-8'); ?></td>
			<td><?= htmlspecialchars($caso['ZTE'], ENT_QUOTES, 'UTF-8'); ?></td>
			<td><?= htmlspecialchars($caso['ZIMC'], ENT_QUOTES, 'UTF-8'); ?></td>
			<td><a href="editaDatos.php?id=<?=$caso['idPersona']; ?>"><i class="fas fa-user-edit fa-lg"></i></a></td>
		
			
	<td>
<?php 
		if ($caso['FechaCtrl'] != null) {
	?>
   <form   action="lista_controles.php"   method="post">
   <input type="hidden" name="idPersona" value="<?= htmlspecialchars($caso['idPersona'], 
          ENT_QUOTES, 'UTF-8'); ?>">
   <input type="hidden" name="Nombre" value="<?= htmlspecialchars($caso['Nombre'], 
          ENT_QUOTES, 'UTF-8'); ?>">
   <input type="hidden" name="idcontrol" value="<?= htmlspecialchars($caso['idcontrol'], 
          ENT_QUOTES, 'UTF-8'); ?>">       
<!--  <input type="submit" class="search" value="&#xf06e"> -->
    
   <div>
                        <button class="btn btn-default" type="submit"><i class="far fa-eye  fa-lg"></i></button>
                    </div>






    </form> 
    <?php } ;  ?>
    </td>	 	
					
				<?php $areaOP =$caso['areaoperativa'] ; ?>

			</tr>
			<?php } ?>
  <?php endforeach; ?>

<?php 

if (isset($_POST['AOP']) || isset($_SESSION['AOP'])) { ?>
	<h4><?='Area Operativa: '. $areaOP .  ' al día ' . date("d-m-Y "); ?></h4>

<?php } ?>

	
		</tbody>
	</table>
</div>




