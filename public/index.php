<?php
	include __DIR__ . '/../include/conecta.php';
	if(isset($_POST['login'])) {
		$errMsg = '';

		// Get data from FORM
		$NomUsuario = $_POST['NomUsuario'];
		$Contraseña = $_POST['Contraseña'];

		if($NomUsuario == '')
			$errMsg = 'Enter NomUsuario';
		if($Contraseña == '')
			$errMsg = 'Enter Contraseña';

		if($errMsg == '') {
			try {
				$stmt = $connect->prepare('SELECT Idusuario, Ape , NomUsuario,Contraseña FROM USUARIOS WHERE NomUsuario = :NomUsuario');
				$stmt->execute(array(
					':NomUsuario' => $NomUsuario
					));
				$data = $stmt->fetch(PDO::FETCH_ASSOC);

				if($data == false){
					$errMsg = "El usuario $NomUsuario no existe.";
				}
				else {
					if($Contraseña == $data['Contraseña']) {
						$_SESSION['name'] = $data['Ape'];
						$_SESSION['username'] = $data['NomUsuario'];
						$_SESSION['password'] = $data['Contraseña'];
						
						header('Location: /reglog/include/webpag.php');
						exit;
					}
					else
						$errMsg = 'Contraseña erronea';
				}
			}
			catch(PDOException $e) {
				$errMsg = $e->getMessage();
			}
		}
	}
?>

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