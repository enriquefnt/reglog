<?php
	include __DIR__ . '/../include/conecta.php';

	session_start();

	if(isset($_POST['login'])) {
		$errMsg = '';

		// Get data from FORM
		$NomUsuario = $_POST['NomUsuario'];
		$Contraseña = $_POST['Contraseña'];

		if($NomUsuario == '')
			$errMsg = 'Ingrese nombre de usuario';
		if($Contraseña == '')
			$errMsg = 'Ingrese la Contraseña';

		if($errMsg == '') {
			try {
				$stmt = $connect->prepare('SELECT Idusuario, Ape , NomUsuario,Contraseña, concat(Nom, " ",Ape) AS Usuario, IdAo, if (IdAo < 1,"Auditor",Ao_Nom) AS nomAOP, Auditor FROM USUARIOS 

					left join AREAS on IdAo= Ao_Id 
					WHERE NomUsuario = :NomUsuario');
				$stmt->execute(array(
					':NomUsuario' => $NomUsuario
					));
				$data = $stmt->fetch(PDO::FETCH_ASSOC);

				if($data == false){
					$errMsg = "El usuario $NomUsuario no existe.";
				}
				else {
					if($Contraseña == $data['Contraseña']) {
						$_SESSION['name'] = $data['Usuario'];
						$_SESSION['username'] = $data['NomUsuario'];
						$_SESSION['password'] = $data['Contraseña'];
						$_SESSION['tipo'] = $data['Auditor'];
						$_SESSION['nomAOPe'] = $data['nomAOP'];
						$_SESSION['AOPe'] = $data['IdAo'];

						
						
						header('Location: /reglog/templates/layout.html.php');
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
	<link rel="stylesheet" type="text/css" href="../estilos/estilo_login.css">
<link rel="shortcut icon" type="image/x-icon" href="../public/favicon.ico">
</head>
<header class="login-header">
Ingreso a listados - SiViNSalta
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