<?php
	include __DIR__ . '/../include/conecta.php';
	if(isset($_POST['login'])) {
		$errMsg = '';

		// tomar datos del formulario
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
<?php 
include __DIR__ . '/../public/index.html.php';
 ?>