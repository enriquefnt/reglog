<html>
<head>
	<title>Login</title>
	<link rel="stylesheet" type="text/css" href="/reglog/include/estilo.css">
	<link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
</head>
<header class="login-header">
Ingreso a listados
</header>

<body>
		
<div class="login">
  <div class="login-triangle"></div>
  
  <h2 class="login-header">Ingresar Usuario y contraseña</h2>

  <form class="login-container" action="" method="post">
    <p><input type="text" name="NomUsuario" value="<?php if(isset($_POST['NomUsuario'])) echo $_POST['NomUsuario'] ?>"placeholder="Usuario" autocomplete="on"></p>
    <p><input type="password" name="Contraseña" value="<?php if(isset($_POST['Contraseña'])) echo $_POST['Contraseña'] ?>" placeholder="Contraseña"></p>
    <p><input type="submit" name='login' value="Ingreso"></p>
  </form>


</div>
<?php
				if(isset($errMsg)){
					echo '<div class="error-msg">'.$errMsg.'</div>';
				}
			?>

</body>
</html>