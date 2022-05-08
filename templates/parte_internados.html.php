<?php 
if (is_null($_SESSION['nombre'])) {
session_start();
}
?>

<?php
if ($_SESSION['tipo']== "SI"){

?>

<form action="" method="post">



  <label for="AOP">Seleccione el área operativa:</label>
 
   <select name="AOP" required="required" id="AOPe">
<option value=0>Seleccione AOP</option>
<?php
$aop = [];
  foreach ($result as $aop) {
 echo '<option value=' .  $aop['Ao_Id'].'>' . $aop['Ao_Nom'] .'</option>';
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
				<th>Ingreso</th>
				<th>Egreso</th>
				<th>Estado</th>
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
	   		<td><?= htmlspecialchars($internados['ApeNom'], ENT_QUOTES, 'UTF-8'); ?></td>
		    <td><?= htmlspecialchars($internados['FechaCtrl'], ENT_QUOTES, 'UTF-8'); ?></td>
			<td><?= htmlspecialchars($internados['Talla'], ENT_QUOTES, 'UTF-8').' ('.$caso['ClaTa'].')'; ?></td>
			<td><?= htmlspecialchars($internados['ZPE'], ENT_QUOTES, 'UTF-8'); ?></td>
		
		 
    <?php } ;  ?>
    

<?php 

if (isset($_POST['AOP']) || isset($_SESSION['AOP'])) { ?>
	<h4><?='Area Operativa: '. $areaOP .  ' al día ' . date("d-m-Y "); ?></h4>

<?php } ?>

	
		</tbody>
	</table>
</div>




