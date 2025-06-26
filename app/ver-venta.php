<?php
if(!isset($_POST["grupo"])){
	include("g-venta.php");
}else{
$query_dolar=($mysql->query("SELECT * FROM configuracion WHERE id='1'"));
$dolar=(mysqli_fetch_assoc($query_dolar));
$query=($mysql->query("SELECT * FROM ventas WHERE grupo='".$_POST["grupo"]."'"));
?>

<div class="limiter">
  <div class="container-login1000">
    <div class="wrap-login1000">
      <h2 align="center" style="padding-bottom: 10px;">Factura <span style="color: blue;">FACTURADA</span></h2>
		<table width="100%" border="1">
			<caption>Fin factura</caption>
			<thead>
				<tr align="center" style="font-weight: bold;">
					<td>Nro</td>
					<td>Nombre</td>
					<td>Cantidad</td>
					<td>Precio unitario</td>
					<td>Sub. Total</td>
				</tr>
			</thead>
			<tbody>
				<?php
				$contador=(0);
				$total=(0);
				while($row=(mysqli_fetch_assoc($query))){
					$contador+=1;
					$total+=($row["precio"]*$row["cantidad"]);
				?>
				<tr align="center">
					<td><?php echo($contador);?></td>
					<td><?php echo($row["nombre"]);?></td>
					<td><?php echo($row["cantidad"]);?></td>
					<td><?php echo(SepararMonto($row["precio"]));?></td>
					<td align="right"><?php echo(SepararMonto($row["precio"]*$row["cantidad"]));?></td>
				</tr>
				<?php }?>
				<tr>
					<td colspan="4" align="right"><strong>TOTAL:</strong></td>
					<td align="right"><strong><?php echo(SepararMonto($total));?></strong></td>
				</tr>
			</tbody>
		</table>
    </div>
  </div>
</div>
<?php
}
?>