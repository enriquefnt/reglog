<?php
session_start();
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
<label for="Fecha">Fecha:</label><br>
  <input type="date" id="Fcha" name="Fecha" min="2015-01-01" max="<?=date('Y-m-d');?>" value=""><br><br>
  
  <input type="submit"  value="Seleccionar">

</form>





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

if (isset($_POST['AOP'] )&& $_SESSION['tipo']=="SI") {
  $aop= $_POST['AOP'];
}

else {$aop=$_SESSION['AOPe'];}

foreach ($internados as $internado): ?>
   <?php if  ($caso['IntAo']==$aop) {?>

  <tbody>
    <tr class="w3-hover-pale-green">
        
      
      <td><?= htmlspecialchars($internado['ApeNom'], ENT_QUOTES, 'UTF-8'); ?></td>
      <td><?= htmlspecialchars($internado['Ingreso'], ENT_QUOTES, 'UTF-8'); ?></td>
      <td><?= htmlspecialchars($internado['Alta'], ENT_QUOTES, 'UTF-8'); ?></td>
      <td><?= htmlspecialchars($internado['Estado'], ENT_QUOTES, 'UTF-8'); ?></td>


      
    
      
 
          
        <?php $areaOP =$caso['Ao_Nom'] ; ?>

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








