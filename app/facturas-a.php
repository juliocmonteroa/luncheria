<?php
$query_dolar=($mysql->query("SELECT * FROM configuracion WHERE id='1'"));
$dolar=(mysqli_fetch_assoc($query_dolar));
$query=($mysql->query("SELECT DISTINCT grupo FROM ventas WHERE estado='ACTIVA' ORDER BY id ASC"));
$query2=($mysql->query("SELECT * FROM ventas WHERE estado='ACTIVA' ORDER BY id DESC LIMIT 1"));
$grupo=(mysqli_fetch_assoc($query2));
if(isset($_POST["buscar"])){
	$factura_nro=($_POST["buscar"]);
	$queryxx=($mysql->query("SELECT * FROM ventas WHERE id='".$factura_nro."'"));
	$previa=(mysqli_fetch_assoc($queryxx));
	$grupox=($previa["grupo"]);
}else{
	$factura_nro=($grupo["id"]);
	$grupox=($grupo["grupo"]);
	
}
$query3=($mysql->query("SELECT * FROM ventas WHERE grupo='".$grupox."'"));
?>
<script type="text/javascript">
  function imprimir(ventas){
    var contenido= document.getElementById(ventas).innerHTML;
     var contenidoOriginal= document.body.innerHTML;

     document.body.innerHTML = contenido;

     window.print();

     document.body.innerHTML = contenidoOriginal;
  }
</script>
<div class="limiter">
  <div class="container-login1000">
    <div class="wrap-login1000">
      	<br>
      	<form action="" method="post">
      		<select name="buscar" onchange="this.form.submit()">
      			<option value="0" onfocus="">Seleccione una factura para buscar.</option>
      			<?php 
      			while($row=(mysqli_fetch_assoc($query))){
      				$queryx=($mysql->query("SELECT * FROM ventas WHERE grupo='".$row["grupo"]."'"));
					$rowx=(mysqli_fetch_assoc($queryx));
      			?>
      			<option value="<?php echo($rowx['id']);?>">Fecha: <?php echo(fechaHora($rowx["fecha"]));?> || Factura nro: <?php echo($rowx['id']);?> || Notas: <?php echo($rowx['nota']);?></option>
      			<?php }?>
      		</select>
      	</form>
      	<br>
		<center>
			<input type="button" name="imprimir" value="Imprimir" onclick="imprimir('ventas');">
		</center>
		<br>
		<div id="ventas">
			<h2 align="center" style="padding-bottom: 10px;"><span style="color: blue;">FACTURA (ACTIVA) #<?php echo($factura_nro);?></span></h2>

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
					while($row=(mysqli_fetch_assoc($query3))){
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
		<form action="index.php?ruta=g-venta4" method="post" name="procesar_formulario">
			<input type="hidden" name="grupo" value="<?php echo($grupox);?>">

		</form>
		<script type="text/javascript">
			function procesar(){
				document.procesar_formulario.submit();
				if(confirm('¿Esta seguro de confirmar esta venta?')){
                    document.procesar_formulario.submit();
                }
			}
		</script>
		<center>
				<input type="button" name="facturar" value="Pagar factura" onclick="procesar();">
		</center>
    </div>
  </div>
</div>