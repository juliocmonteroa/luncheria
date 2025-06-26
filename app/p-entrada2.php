<?php
if(isset($_SESSION['lista'])){
	$arrelgo=(count($_SESSION['lista']));
	$grupo=(encriptacionMD5(rand(0,99999).date("d-m-Y h:i:s A")));
	for($i=0;$i<$arrelgo;$i++){
		$id_array=($_SESSION['lista'][$i][0]);
		$cantidad_array=($_SESSION['lista'][$i][1]);
		$estante_array=($_SESSION['lista'][$i][2]);
		$query=($mysql->query("SELECT * FROM insumos WHERE id='".$id_array."'"));
		$row=(mysqli_fetch_assoc($query));
		$query2=($mysql->query("SELECT * FROM embalaje WHERE id='".$row["tipo"]."'"));
		$row2=(mysqli_fetch_assoc($query2));
		//Existencias
		$query3=($mysql->query("SELECT * FROM existencias WHERE id_insumos='".$id_array."' AND estante='".$estante_array."'"));
		$row3=(mysqli_fetch_assoc($query3));
		if($row3["id"]>0){
			$nueva_cantidad=($cantidad_array+$row3["cantidad"]);
			$mysql->query("UPDATE existencias SET cantidad='".$nueva_cantidad."' WHERE id_insumos='".$id_array."' AND estante='".$estante_array."'");
		}else{
			$mysql->query("INSERT INTO existencias(id_insumos,cantidad,estante) VALUES('".$id_array."','".$cantidad_array."','".$estante_array."')");
		}
		//Entradas
		$mysql->query("INSERT INTO entradas(id_usuarios,
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
													'".$row["codigo"]."',
													'".$row["nombre"]."',
													'".$row2["nombre"]."',
													'".$cantidad_array."',
													'".$estante_array."',
													'".$row["descripcion"]."',
													'".$_POST["nota"]."',
													'".date("Y-m-d")."',now())");
	}
	/*----------------------------------------------------------------------*/
	unset($_SESSION['lista']);
	?>
	<script type="text/javascript">
		window.location.href="index.php?ruta=p-entrada&alert=procesar-entrada";
	</script>
	<?php

}else{
	?>
	<script type="text/javascript">
		window.location.href="index.php?ruta=p-entrada";
	</script>
	<?php
}
?>