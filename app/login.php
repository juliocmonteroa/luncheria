<?php
require("../secure/config.php");
config();
if(isset($_SESSION["acceso"])){header("Location: index.php");}
if(isset($_POST["email"])){
	conexionDB();
	$email=($_POST["email"]);
	$clave=(encriptacionBASE64($_POST["password"]));
	$query=($mysql->query("SELECT * FROM usuarios  WHERE email='$email' and clave='$clave'"));
	$row=(mysqli_fetch_assoc($query));
	if($row["id"]>0){
		$_SESSION["acceso"]=(encriptacionBASE64($row["id"]));
		$_SESSION["rol"]=(encriptacionBASE64($row["rol"]));
		header("Location: index.php");
	}else{
		?>
			<script type="text/javascript">
				alert('!Ups¡ Correo electrónico / Contraseña inválida.');
			</script>
		<?php
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login V1</title>
	<meta charset="UTF-8">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />	
	<link rel="icon" type="image/png" href="../images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="../vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../css/util.css">
	<link rel="stylesheet" type="text/css" href="../css/main.css">
<!--===============================================================================================-->
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-pic js-tilt" data-tilt>
					<img src="../images/img-01.png" alt="IMG">
				</div>

				<form class="login100-form validate-form" method="post" action="">
					<span class="login100-form-title">
						Inicio de sesión
					</span>

					<div class="wrap-input100 validate-input" data-validate = "Requiere un correo electronico válido: ejemplo@abc.xyz">
						<input class="input100" type="text" name="email" placeholder="Correo electrónico" autocomplete="off" required>
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Requiere una contraseña">
						<input class="input100" type="password" name="password" placeholder="Contraseña" autocomplete="off" required>
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>
					
					<div class="container-login100-form-btn">
						<button class="login100-form-btn">
							Entrar
						</button>
					</div>
				<!--
					<div class="text-center p-t-12">
						<span class="txt1">
							Forgot
						</span>
						<a class="txt2" href="#">
							Username / Password?
						</a>
					</div>

					<div class="text-center p-t-136">
						<a class="txt2" href="#">
							Create your Account
							<i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
						</a>
					</div>
				-->
				</form>
				<div class="text-center p-t-10">
					<span class="txt3" href="#!Secure">
						<br>
						<?php echo($GLOBALS['copyright']);?>
					</span>
				</div>
				<br><br>
			</div>
		</div>
	</div>
	
	

	
<!--===============================================================================================-->	
	<script src="../vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="../vendor/bootstrap/js/popper.js"></script>
	<script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="../vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="../vendor/tilt/tilt.jquery.min.js"></script>
	<script >
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>
<!--===============================================================================================-->
	<script src="../js/main.js"></script>

</body>
</html>