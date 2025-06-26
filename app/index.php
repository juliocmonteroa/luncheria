<?php
	require("../secure/config.php");
	config();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title><?php echo( $GLOBALS['title']);?></title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--===============================================================================================-->  
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
	<!-- ocultar input con select (a-producto) -->
	<script src="../js/select_jquery.min.js"></script>
	<!--===============================================================================================-->
	<!-- Auto complete 21/02/2020-->
	<script language="JavaScript" src="../js/jquery-1.5.1.min.js"></script>
	<script language="JavaScript" src="../js/jquery-ui-1.8.13.custom.min.js"></script>
	<link type="text/css" href="../css/ui-lightness/jquery-ui-1.8.13.custom.css" rel="stylesheet" />
	<!--===============================================================================================-->
</head>

<body>
	<?php
		conexionDB();
		if(isset($_SESSION['acceso'])){
			//buscar usuario login
			$id_usuario=(desencriptacionBASE64($_SESSION["acceso"]));
			$query_usuario=($mysql->query("SELECT * FROM usuarios  WHERE id='$id_usuario'"));
			$row_usuario=(mysqli_fetch_assoc($query_usuario));
			//Si existe una session: ejecutar rutas y alertas.
			echo('<link rel="stylesheet" type="text/css" href="../css/menu.css">');
			include("../extras/url.php");
			include("../extras/menu.php");
    		//Rutas
			if(isset($_GET["ruta"])){
				if($_GET["ruta"]=="g-venta3" || $_GET["ruta"]=="ver-venta"){
					$grupo=($_GET["grupo"]);
				}
	    		include($_GET["ruta"].".php");
	    		//ALERTAS
				if(isset($_GET["alert"])){
					if($_GET["alert"]=="delete-insumo"){
						?>
						<script type="text/javascript">
							alert("¡Enhorabuena! Insumo eliminado con éxito.");
						</script>
						<?php
					}
					if($_GET["alert"]=="delete-producto"){
						?>
						<script type="text/javascript">
							alert("¡Enhorabuena! Producto eliminado con éxito.");
						</script>
						<?php
					}
					if($_GET["alert"]=="venta-generada"){
						?>
						<script type="text/javascript">
							alert("¡Enhorabuena! Venta generada con éxito.");
						</script>
						<?php
					}
					if($_GET["alert"]=="procesar-entrada"){
						?>
						<script type="text/javascript">
							alert("¡Enhorabuena! Entrada de productos procesada con éxito.");
						</script>
						<?php
					}
					if($_GET["alert"]=="procesar-salida"){
						?>
						<script type="text/javascript">
							alert("¡Enhorabuena! Salida de productos procesada con éxito.");
						</script>
						<?php
					}
					if($_GET["alert"]=="delete-embalaje"){
						?>
						<script type="text/javascript">
							alert("¡Enhorabuena! Tipo de embalaje eliminado con éxito.");
						</script>
						<?php
					}
					if($_GET["alert"]=="delete-presentacion"){
						?>
						<script type="text/javascript">
							alert("¡Enhorabuena! Tipo de presentacion eliminada con éxito.");
						</script>
						<?php
					}
					if($_GET["alert"]=="delete-usuario"){
						?>
						<script type="text/javascript">
							alert("¡Enhorabuena! Usuario del sistema eliminado con éxito.");
						</script>
						<?php
					}
				}
	    	}else{
	    		include("home.php");
	    	}
		}else{
			//Si no existe una session
			header("Location: ../");
		}
	?>
<!--===============================================================================================-->  
  <?php
  if(isset($_GET["ruta"])){
  	if($_GET["ruta"]!="g-venta"){
  		?>
  		<script src="../vendor/jquery/jquery-3.2.1.min.js"></script>
  		<?php
  	}
  }else{
  	?>
  	<script src="../vendor/jquery/jquery-3.2.1.min.js"></script>
  	<?php
  }
  ?>
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