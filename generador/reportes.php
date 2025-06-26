<?php
require("../secure/config.php");
config();
conexionDB();
if(!isset($_SESSION['acceso'])){
	?>
	<script type="text/javascript">
		window.location.href="../index.html";
	</script>
	<?php
}
if(!isset($_POST["tipo"])){
	?>
	<script type="text/javascript">
		window.location.href="../index.html";
	</script>
	<?php
}else{
	$query_dolar=($mysql->query("SELECT * FROM configuracion WHERE id='1'"));
	$dolar=(mysqli_fetch_assoc($query_dolar));
	/*====================================================================*/
	if($_POST["tipo"]==0){
		$reporte=("inventario");
		//Columnas
		$thead="<td>Nro.</td>";
		$thead.="<td>Fecha de registro</td>";
		$thead.="<td>Código</td>";
		$thead.="<td>Insumo</td>";
		$thead.="<td>Tipo de embalaje</td>";
		$thead.="<td>Disponible(s)</td>";
		//Filas
		$contador_p=(0);
		$tbody=("");
		$query_p=($mysql->query("SELECT * FROM insumos"));
		while($row_p=(mysqli_fetch_assoc($query_p))){
			$contador_p+=(1);
			$query_e=($mysql->query("SELECT * FROM embalaje WHERE id='".$row_p["tipo"]."'"));
			$row_e=(mysqli_fetch_assoc($query_e));

			$query_ex=($mysql->query("SELECT SUM(cantidad) AS total_cantidad FROM existencias WHERE id_insumos='".$row_p["id"]."'"));
       		$row_ex=(mysqli_fetch_assoc($query_ex));

       		if($row_ex["total_cantidad"]==0){
       			$cantidad=(0); 
       		}else{
       			$cantidad=($row_ex["total_cantidad"]);
       		}

			$tbody.="<tr>";
			$tbody.="<td>".$contador_p."</td>";
			$tbody.="<td>".fechaHora($row_p["fecha"])."</td>";
			$tbody.="<td>".$row_p["codigo"]."</td>";
			$tbody.="<td>".$row_p["nombre"]."</td>";
			$tbody.="<td>".$row_e["nombre"]."</td>";;
			$tbody.="<td>".$cantidad."</td>";
			$tbody.="</tr>";
		}
	}
	/*====================================================================*/
	if($_POST["tipo"]==1){
		$reporte=("insumos existentes");
		//Columnas
		$thead="<td>Nro.</td>";
		$thead.="<td>Código</td>";
		$thead.="<td>Insumo</td>";
		$thead.="<td>Tipo de embalaje</td>";
		$thead.="<td>Disponible(s)</td>";
		$thead.="<td>Estante(s)</td>";
		//Filas
		$contador_p=(0);
		$tbody=("");
		$query_ex=($mysql->query("SELECT * FROM existencias WHERE cantidad>0"));
		while($row_ex=(mysqli_fetch_assoc($query_ex))){
			$contador_p+=(1);
			$query_p=($mysql->query("SELECT * FROM insumos WHERE id='".$row_ex["id_insumos"]."'"));
			$row_p=(mysqli_fetch_assoc($query_p));
			$query_e=($mysql->query("SELECT * FROM embalaje WHERE id='".$row_p["tipo"]."'"));
			$row_e=(mysqli_fetch_assoc($query_e));

			$tbody.="<tr>";
			$tbody.="<td>".$contador_p."</td>";
			$tbody.="<td>".$row_p["codigo"]."</td>";
			$tbody.="<td>".$row_p["nombre"]."</td>";
			$tbody.="<td>".$row_e["nombre"]."</td>";;
			$tbody.="<td>".$row_ex["cantidad"]."</td>";
			$tbody.="<td>".$row_ex["estante"]."</td>";
			$tbody.="</tr>";
		}
	}
	/*====================================================================*/
	if($_POST["tipo"]==2){
		$reporte=("insumo agotados");
		//Columnas
		$thead="<td>Nro.</td>";
		$thead.="<td>Código</td>";
		$thead.="<td>Insumo</td>";
		$thead.="<td>Tipo de embalaje</td>";
		$thead.="<td>Disponible(s)</td>";
		//Filas
		$contador_p=(0);
		$tbody=("");
		$query_ex=($mysql->query("SELECT * FROM existencias WHERE cantidad<=0"));
		while($row_ex=(mysqli_fetch_assoc($query_ex))){
			$contador_p+=(1);
			$query_p=($mysql->query("SELECT * FROM insumos WHERE id='".$row_ex["id_insumos"]."'"));
			$row_p=(mysqli_fetch_assoc($query_p));
			if($row_p["codigo"]!=""){/*insumos vacios no mostrar*/
				$query_e=($mysql->query("SELECT * FROM embalaje WHERE id='".$row_p["tipo"]."'"));
				$row_e=(mysqli_fetch_assoc($query_e));

				$tbody.="<tr>";
				$tbody.="<td>".$contador_p."</td>";
				$tbody.="<td>".$row_p["codigo"]."</td>";
				$tbody.="<td>".$row_p["nombre"]."</td>";
				$tbody.="<td>".$row_e["nombre"]."</td>";;
				$tbody.="<td>".$row_ex["cantidad"]."</td>";
				$tbody.="</tr>";
			}
		}
	}
	/*====================================================================*/
	if($_POST["tipo"]==3){
		$reporte=("entradas de insumos");
		//Columnas
		$thead="<td>Nro.</td>";
		$thead.="<td>Fecha</td>";
		$thead.="<td>Código</td>";
		$thead.="<td>Insumo</td>";
		$thead.="<td>Embalaje</td>";
		$thead.="<td>Cantidad</td>";
		$thead.="<td>Estante</td>";
		$thead.="<td>Nota de entrada</td>";
		//Filas
		$contador_p=(0);
		$tbody=("");
		$query_p=($mysql->query("SELECT * FROM entradas"));
		while($row_p=(mysqli_fetch_assoc($query_p))){
			$contador_p+=(1);

			$tbody.="<tr>";
			$tbody.="<td>".$contador_p."</td>";
			$tbody.="<td>".fecha($row_p["fecha_registro"])."</td>";
			$tbody.="<td>".$row_p["codigo"]."</td>";
			$tbody.="<td>".$row_p["nombre"]."</td>";;
			$tbody.="<td>".$row_p["tipo"]."</td>";
			$tbody.="<td>".$row_p["cantidad"]."</td>";
			$tbody.="<td>".$row_p["estante"]."</td>";
			$tbody.="<td>".$row_p["nota"]."</td>";
			$tbody.="</tr>";
		}
	}
	/*====================================================================*/
	if($_POST["tipo"]==4){
		$reporte=("salidas de insumos");
		//Columnas
		$thead="<td>Nro.</td>";
		$thead.="<td>Fecha</td>";
		$thead.="<td>Código</td>";
		$thead.="<td>Insumo</td>";
		$thead.="<td>Embalaje</td>";
		$thead.="<td>Cantidad</td>";
		$thead.="<td>Estante</td>";
		$thead.="<td>Nota de salida</td>";
		//Filas
		$contador_p=(0);
		$tbody=("");
		$query_p=($mysql->query("SELECT * FROM salidas"));
		while($row_p=(mysqli_fetch_assoc($query_p))){
			$contador_p+=(1);

			$tbody.="<tr>";
			$tbody.="<td>".$contador_p."</td>";
			$tbody.="<td>".fecha($row_p["fecha_registro"])."</td>";
			$tbody.="<td>".$row_p["codigo"]."</td>";
			$tbody.="<td>".$row_p["nombre"]."</td>";;
			$tbody.="<td>".$row_p["tipo"]."</td>";
			$tbody.="<td>".$row_p["cantidad"]."</td>";
			$tbody.="<td>".$row_p["estante"]."</td>";
			$tbody.="<td>".$row_p["nota"]."</td>";
			$tbody.="</tr>";
		}
	}
	/*====================================================================*/
	if($_POST["tipo"]==5){
		$reporte=("usuarios del sistema");
		//Columnas
		$thead="<td>Nro.</td>";
		$thead.="<td>Fecha</td>";
		$thead.="<td>Nombre</td>";
		$thead.="<td>C.I</td>";
		$thead.="<td>E-mail</td>";
		$thead.="<td>Téfono</td>";
		$thead.="<td>Direción</td>";
		$thead.="<td>Rol</td>";
		//Filas
		$contador_u=(0);
		$tbody=("");
		$query_u=($mysql->query("SELECT * FROM usuarios"));
		while($row_u=(mysqli_fetch_assoc($query_u))){
			$contador_u+=(1);

			if($row_u["rol"]==1){
				$rol=("Administrador");
			}else{
				$rol=("Empleado");
			}

			$tbody.="<tr>";
			$tbody.="<td>".$contador_u."</td>";
			$tbody.="<td>".fecha($row_u["fecha"])."</td>";
			$tbody.="<td>".$row_u["nombre"]."</td>";
			$tbody.="<td>".$row_u["nacionalidad"]."-".$row_u["cedula"]."</td>";
			$tbody.="<td>".$row_u["email"]."</td>";
			$tbody.="<td>".$row_u["telefono"]."</td>";
			$tbody.="<td>".$row_u["direccion"]."</td>";
			$tbody.="<td>".$rol."</td>";
			$tbody.="</tr>";
		}
	}
	/*====================================================================*/
	if($_POST["tipo"]==6){
		$reporte=("lista de productos");
		//Columnas
		$thead="<td>Nro.</td>";
		$thead.="<td>Código</td>";
		$thead.="<td>Nombre</td>";
		$thead.="<td>Cantidad</td>";
		$thead.="<td>Precio $ (".SepararMonto($dolar["precio"]).")</td>";
		$thead.="<td>Precio Bs</td>";
		//Filas
		$contador_u=(0);
		$tbody=("");
		$query_u=($mysql->query("SELECT * FROM productos"));
		while($row_u=(mysqli_fetch_assoc($query_u))){
			if($row_u["limite"]==1){
				$cantidad=("∞");
			}else{
				$cantidad=($row_u["cantidad"]);
			}
			$contador_u+=(1);
			$tbody.="<tr>";
			$tbody.="<td>".$contador_u."</td>";
			$tbody.="<td>".$row_u["codigo"]."</td>";
			$tbody.="<td>".$row_u["nombre"]."</td>";
			$tbody.="<td>".$cantidad."</td>";
			$tbody.="<td>".$row_u["precio"]."</td>";
			$tbody.="<td>".SepararMonto($row_u["precio"]*$dolar["precio"])."</td>";
			$tbody.="</tr>";
		}
	}
	/*====================================================================*/
	if($_POST["tipo"]==7){
		$reporte=("ventas generales");
		//Columnas
		$thead="<td>Nro.</td>";
		$thead.="<td>Fecha</td>";
		$thead.="<td>Código</td>";
		$thead.="<td>Nombre</td>";
		$thead.="<td>Cantidad</td>";
		$thead.="<td>Precio / U</td>";
		$thead.="<td>Sub. Total</td>";
		//Filas
		$contador_u=(0);
		$tbody=("");
		$query_u=($mysql->query("SELECT * FROM ventas where estado='FACTURADA' ORDER BY fecha_registro ASC"));
		while($row_u=(mysqli_fetch_assoc($query_u))){
			$contador_u+=(1);

			$tbody.="<tr>";
			$tbody.="<td>".$contador_u."</td>";
			$tbody.="<td>".fecha($row_u["fecha_registro"])."</td>";
			$tbody.="<td>".$row_u["codigo"]."</td>";
			$tbody.="<td>".$row_u["nombre"]."</td>";
			$tbody.="<td>".$row_u["cantidad"]."</td>";
			$tbody.="<td>".SepararMonto($row_u["precio"])."</td>";
			$tbody.="<td>".SepararMonto($row_u["cantidad"]*$row_u["precio"])."</td>";
			$tbody.="</tr>";
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
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
	<style type="text/css" media="screen">
		@media print{
			@page {
				size: landscape;
			}
		}	
	</style>
	<script type="text/javascript">
		function imprimir(){
			window.print();
		}
	</script>
	<!--===============================================================================================-->
	<title>Reporte</title>
</head>
<body onload="imprimir();">
	<center>
		<h2>Reporte de <?php echo($reporte);?></h2><br>
		<table align="center" width="90%" border="1">
			<caption>Fin del reporte</caption>
			<thead align="center" style="font-weight: bold;background-color: #D5D5D5;">
				<tr>
					<?php echo($thead);?>
				</tr>
			</thead>
			<tbody align="center">
				<?php echo($tbody);?>
			</tbody>
		</table>
	</center>
</body>
</html>
<?php
}
?>