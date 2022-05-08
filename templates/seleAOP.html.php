<?php 
if (is_null($_SESSION['nombre'])) {
session_start();
}
?>

<?php
if ($_SESSION['tipo']!= "SI"){

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

 <?php } ;  ?>