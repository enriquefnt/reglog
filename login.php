<?php
	require 'conecta.php';

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
					$errMsg = "User $NomUsuario not found.";
				}
				else {
					if($Contraseña == $data['Contraseña']) {
						$_SESSION['name'] = $data['Ape'];
						$_SESSION['username'] = $data['NomUsuario'];
						$_SESSION['password'] = $data['Contraseña'];
						
						header('Location: webpag.php');
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
<head><title>Login</title></head>
	<style>
	html, body {
		margin: 1px;
		border: 0;
	}
	</style>
<body>
	<div align="center">
		<div style=" border: solid 1px #006D9C; " align="left">
			<?php
				if(isset($errMsg)){
					echo '<div style="color:#FF0000;text-align:center;font-size:17px;">'.$errMsg.'</div>';
				}
			?>
			<div style="background-color:#006D9C; color:#FFFFFF; padding:10px;"><b>Login</b></div>
			<div style="margin: 15px">
				<form action="" method="post">
					<label>Usuario</label>
					<input type="text" name="NomUsuario" value="<?php if(isset($_POST['NomUsuario'])) echo $_POST['NomUsuario'] ?>" autocomplete="off" class="box"/><br /><br />
					<label>Contraseña</label>
					<input type="password" name="Contraseña" value="<?php if(isset($_POST['Contraseña'])) echo $_POST['Contraseña'] ?>" autocomplete="off" class="box" /><br/><br />
					<input type="submit" name='login' value="Login" class='submit'/><br />
				</form>
			</div>
		</div>
	</div>
</body>
</html>
