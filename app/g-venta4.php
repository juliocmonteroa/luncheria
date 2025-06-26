<?php
if(isset($_POST["grupo"])){
	$contador=(0);
	$query=($mysql->query("SELECT * FROM ventas WHERE grupo='".$_POST["grupo"]."'"));
	while($row=mysqli_fetch_assoc($query)){
		if($row["estado"]!="FACTURADA"){
			$contador+=(1);
			$queryx=($mysql->query("SELECT * FROM productos WHERE id='".$row["id_producto"]."'"));
			$rowx=(mysqli_fetch_assoc($queryx));
			if($rowx["limite"]==0){
				$cantidad=($rowx["cantidad"]-$row["cantidad"]);
				$mysql->query("UPDATE productos SET cantidad='".$cantidad."' WHERE id='".$row["id_producto"]."'");
			}
		}
	}
	if($contador>0){
		$mysql->query("UPDATE ventas SET estado='FACTURADA' 
											WHERE grupo='".$_POST["grupo"]."'");
	}
	include("ver-venta.php");
}else{
	include("g-venta.php");
}
?>