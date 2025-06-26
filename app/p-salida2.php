<?php
if(isset($_SESSION['lista'])){
	$arrelgo=(count($_SESSION['lista']));
	$grupo=(encriptacionMD5(rand(0,99999).date("d-m-Y h:i:s A")));
	for($i=0;$i<$arrelgo;$i++){
		$id_array=($_SESSION['lista'][$i][0]);
		//Existencias
		$query=($mysql->query("SELECT * FROM existencias WHERE id='".$id_array."'"));
		$row=(mysqli_fetch_assoc($query));

		$query1=($mysql->query("SELECT * FROM insumos WHERE id='".$row["id_insumos"]."'"));
		$row1=(mysqli_fetch_assoc($query1));

		$query2=($mysql->query("SELECT * FROM embalaje WHERE id='".$row1["tipo"]."'"));
		$row2=(mysqli_fetch_assoc($query2));

		$nueva_cantidad=($row["cantidad"]-$_POST["cantidad_".$i]);
		$mysql->query("UPDATE existencias SET cantidad='".$nueva_cantidad."' WHERE id='".$id_array."'");
		//Salidas
		$mysql->query("INSERT INTO salidas(id_usuarios,
										grupo,
										codigo,
										nombre,
										tipo,
										cantidad,
										estante,
										descripcion,
										nota,
										fecha_registro,
										fecha) VALUES('".desencriptacionBASE64($_SESSION["acceso"])."',
													'".$grupo."',
													'".$row1["codigo"]."',
													'".$row1["nombre"]."',
													'".$row2["nombre"]."',
													'".$_POST["cantidad_".$i]."',
													'".$row["estante"]."',
													'".$row1["descripcion"]."',
													'".$_POST["nota"]."',
													'".date("Y-m-d")."',now())");
	}
	/*----------------------------------------------------------------------*/
	unset($_SESSION['lista']);
	?>
	<script type="text/javascript">
		window.location.href="index.php?ruta=p-salida&alert=procesar-salida";
	</script>
	<?php

}else{
	?>
	<script type="text/javascript">
		window.location.href="index.php?ruta=p-salida";
	</script>
	<?php
}
?>