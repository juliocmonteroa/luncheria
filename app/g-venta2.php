<?php
if(isset($_SESSION['lista'])){
	$arrelgo=(count($_SESSION['lista']));
	$grupo=(encriptacionMD5(rand(0,99999).date("d-m-Y h:i:s A")));
	$query_dolar=($mysql->query("SELECT * FROM configuracion WHERE id='1'"));
	$dolar=(mysqli_fetch_assoc($query_dolar));
	for($i=0;$i<$arrelgo;$i++){
		$id_array=($_SESSION['lista'][$i][0]);

		$query=($mysql->query("SELECT * FROM productos WHERE id='".$id_array."'"));
		$row=(mysqli_fetch_assoc($query));

		$query2=($mysql->query("SELECT * FROM presentacion WHERE id='".$row["presentacion"]."'"));
		$row2=(mysqli_fetch_assoc($query2));
		if($_POST["cantidad_".$i]<=0){
			$cantidad_producto=(1);
		}else{
			$cantidad_producto=$_POST["cantidad_".$i];
		}

		$nueva_cantidad=($row["cantidad"]-$cantidad_producto);
		$precio=($row["precio"]*$dolar["precio"]);
		//Ventas
		$mysql->query("INSERT INTO ventas(id_usuarios,
										id_producto,
										grupo,
										codigo,
										nombre,
										presentacion,
										descripcion,
										cantidad,
										nota,
										precio,
										estado,
										fecha_registro,
										fecha) VALUES('".desencriptacionBASE64($_SESSION["acceso"])."',
													'".$id_array."',
													'".$grupo."',
													'".$row["codigo"]."',
													'".$row["nombre"]."',
													'".$row2["nombre"]."',
													'".$row["descripcion"]."',
													'".$cantidad_producto."',
													'".$_POST["nota"]."',
													'".$precio."',
													'ACTIVA',
													'".date("Y-m-d")."',now())");
		/*if($row["limite"]==0){
			$mysql->query("UPDATE productos SET cantidad='".$nueva_cantidad."' 
													WHERE id='".$id_array."'");
		}*/
	}
	/*----------------------------------------------------------------------*/
	unset($_SESSION['lista']);
	$urlx=("index.php?ruta=g-venta3&grupo=".$grupo);
	?>
	<script type="text/javascript">
		window.location.href="<?php echo($urlx);?>";
		//window.location.href="index.php?ruta=g-venta&alert=venta-generada";
	</script>
	<?php

}else{
	?>
	<script type="text/javascript">
		window.location.href="index.php?ruta=g-venta";
	</script>
	<?php
}
?>