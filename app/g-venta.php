<?php
$reset=(true);
if(isset($_POST["producto"])){
	$reset=(false);
	if($_POST["producto2"]!=""){
		$query_ok=($mysql->query("SELECT * FROM productos WHERE nombre='".$_POST["producto2"]."'"));
		$row_ok=(mysqli_fetch_assoc($query_ok));
		$id=($row_ok["id"]);
	}
	else{
		$id=($_POST["producto"]);
	}
	if($id!=""){
		if(isset($_SESSION["lista"])){
		//Si el array ya tiene elementos, le agrego otro elemento
		$cantidad_array=(count($_SESSION['lista']));
		$duplicado=(false);
		for($i=0;$i<$cantidad_array;$i++){
			$id_array=($_SESSION['lista'][$i][0]);
			if($id_array == $id){
				$duplicado=(true);
			}
		}
		if($duplicado==false){
			$producto_tmp=(array(array("$id")));
		    $producto=(array_merge($_SESSION['lista'], $producto_tmp));
			$_SESSION['lista']=($producto);
		}
	}else{
		//Si no existe el arreglo
		$producto=(array(array("$id")));
		$_SESSION['lista']=($producto);
	}
	}
}
/*--------------------------------------------------------------------------------*/
//Remover lista / Reset lista vacia
if(isset($_POST["remover"])){
	$reset=(false);
	$cantidad_array=(count($_SESSION['lista']));
	for($i=0;$i<$cantidad_array;$i++){
		if($i == $_POST["remover"]){
			unset($_SESSION['lista'][$i]);
		}
	}
	$nuevoArray=array_values($_SESSION['lista']);
	unset($_SESSION['lista']);
	$_SESSION['lista']=($nuevoArray);
	$cantidad_array=(count($_SESSION['lista']));
	if($cantidad_array <=0){
		unset($_SESSION['lista']);
	}
}
if($reset==true){
	unset($_SESSION['lista']);
}
$query_dolar=($mysql->query("SELECT * FROM configuracion WHERE id='1'"));
$dolar=(mysqli_fetch_assoc($query_dolar));
/*-------------------------------------------------------------------------------*/
?>
<script type="text/javascript">
	function agregar(){
		document.formulario_agregar.submit();
		/*var cantidad=document.getElementsByName("producto")[0].value;
		if(cantidad>0){
			document.formulario_agregar.submit();
		}else{
			alert("No hay productos disponibles.");
		}*/
	}
</script>
<!-- AUTOCOMPLETE 21/02/2020 INCLUYE ARCHIVOS EN APP/INDEX.PHP-->
<script type="text/javascript">
	$(function() {
		<?php
			$query_productos=($mysql->query("SELECT * FROM productos"));
			while($productos = mysqli_fetch_assoc($query_productos)){
				if($productos["precio_soloenBS"]==true){
					$precio_producto=SepararMonto(($productos["precio"]));
				}else{
					$precio_producto=SepararMonto(($productos["precio"]*$dolar["precio"]));
				}
				if($productos["limite"]==1){
					$cantidad_producto=("∞");
				}else{
					$cantidad_producto=($productos["cantidad"]);
				}
				$elementos[]= '"'.$productos['nombre'].'"';
			}
			$arreglo= implode(", ", $elementos);
			?>	
		var availableTags=new Array(<?php echo $arreglo; ?>);
		$("#tags").autocomplete({
			source: availableTags
		});
		$("#xd").autocomplete({
			source: availableTags
		});
	});
</script>

<!-- FIN AUTOCOMPLETE -->
<div class="limiter">
  <div class="container-login1000">
    <div class="wrap-login1000">
      <h2 align="center" style="padding-bottom: 10px;">Generar venta</h2>
		<table width="100%" border="1">
			<thead align="center" style="font-weight: bold;background-color: #D5D5D5;">
				<tr>
					<td colspan="6">Seleccionar producto</td>
					<td>Agregar</td>
				</tr>
			</thead>
			<form action="index.php?ruta=g-venta" method="post" name="formulario_agregar">
				<tbody align="center">
					<tr>
						<td colspan="6">
							<input id="tags" type="text" name="producto2" placeholder="Busqueda rapida">
							<select name="producto">
								<?php
								$query=($mysql->query("SELECT * FROM productos WHERE limite='1' OR cantidad>0"));
								$contador+=(0);
								while($row=(mysqli_fetch_assoc($query))){
									if($row["precio_soloenBS"]==true){
										$precio=SepararMonto(($row["precio"]));
									}else{
										$precio=SepararMonto(($row["precio"]*$dolar["precio"]));
									}
									$contador+=(1);
									if($row["limite"]==1){
										$cantidad=("∞");
									}else{
										$cantidad=($row["cantidad"]);
									}
								?>
								<option value="<?php echo($row['id']);?>">
									Código: <?php echo($row['codigo']);?> | Nombre: <?php echo($row['nombre']);?>	| Disponible: <?php echo($cantidad);?> | Precio: <?php echo($precio);?>
								</option>
								<?php }
								if($contador<=0){
									?>
									<option value="0"> No hay productos disponibles. </option>
									<?php
								}
								?>
							</select>
						</td>
						<td>
							<a href="#!Secure" onclick="agregar();">
								<img src="../images/mas.png" alt="Editar" width="50px">
							</a>
						</td>
					</tr>
				</tbody>
			</form>
			<?php
			if(isset($_SESSION['lista'])){
			?>

			<thead align="center" style="font-weight: bold;background-color: #FAFAFA;">
				<tr align="center">
					<td colspan="7">
						<h4 style="padding-top: 10px;padding-bottom: 10px;">
							Productos en lista:
						</h4>
						<em>Nota: Recuerde colocar la nota de venta y seleccionar la cantidad despues de terminar de agregar todos los poductos.</em>
					</td>
				</tr>
				<tr style="font-weight: bold;background-color: #F6CEF5 ;">
					<td width="100px">Código</td>
					<td>Nombre</td>
					<td>Presentación</td>
					<td colspan="2">Precio / U</td>
					<td>Cantidad</td>
					<td>Quitar</td>
				</tr>
			</thead>
			<script type="text/javascript">
				function procesar(){
					document.procesar_formulario.submit();
					/*if(confirm('¿Confirma la venta de estos productos?\n\n'+complemento)){
                        document.procesar_formulario.submit();
                    }*/
				}
			</script>
			<form action="index.php?ruta=g-venta2" method="post" name="procesar_formulario">
				<?php
				$cantidad_lista=(count($_SESSION['lista']));
				$contador=(0);
				for($i=0;$i<$cantidad_lista;$i++){
					$contador+=(1);
					$id=($_SESSION['lista'][$i][0]);
					$query2=$mysql->query("SELECT * FROM productos WHERE id='".$id."'");
					$row2=(mysqli_fetch_assoc($query2));
					//tipo de presentacion
					$query3=($mysql->query("SELECT * FROM presentacion WHERE id='".($row2["presentacion"])."'"));
	                $row3=(mysqli_fetch_assoc($query3));
	                if($row2["precio_soloenBS"]==true){
	                	$precio=(SepararMonto($row2["precio"]));
	                }else{
	                	$precio=(SepararMonto($row2["precio"]*$dolar["precio"]));
	                }
				?>
				
				<tbody align="center">
					<td><?php echo($row2["codigo"]);?></td>
					<td><?php echo($row2["nombre"]);?></td>
					<td><?php echo($row3["nombre"]);?></td>
					<td colspan="2"><?php echo($precio);?></td>
					<td>
						<?php
						if($row2["limite"]==1){?>
						<input type="number" required title="Escriba la cantidad de producto(s) a vender" name="cantidad_<?php echo($i);?>">
						<?php }else{
						?>
						<select title="Seleccione la cantidad de producto(s) a vender" name="cantidad_<?php echo($i);?>">
							<?php for($ii=0;$ii<$row2["cantidad"];$ii++){?>
								<option><?php echo($ii+1)?></option>
							<?php }?>
						</select>
						<?php }?>
					</td>
					<td>
						<a href="#!Secure" onclick="quitar_<?php echo($i);?>();">
							<img src="../images/menos.png" alt="quitar" title="Pulse para quitar de la lista." width="50px">
						</a>
					</td>
				</tbody>
				<?php }/*fin for*/?>
				<tbody align="center">
					<td colspan="7">
						<textarea name="nota" title="Nota de venta (Opcional)" placeholder="Escriba una nota de venta (Opcional)"></textarea>
					</td>
				</tbody>
			</form>
				<?php }/*Fin isset*/?>
		</table>
		<?php if(isset($_SESSION['lista'])){?>
		<br>
		<center>
				<input type="submit" name="procesar" value="Procesar" onclick="procesar();">
		</center>
		<?php }?>
    </div>
  </div>
</div>

<?php
if(isset($_SESSION['lista'])){
/*------------------------------------------------------------------------------------------*/ 
	/*Quitar productos de la lista*/
	for($i=0;$i<$cantidad_lista;$i++){
		?>
		<script type="text/javascript">
			function quitar_<?php echo($i);?>(){
				document.formulario_q<?php echo($i);?>.submit();
			}
		</script>
		<form action="index.php?ruta=g-venta" method="post" name="formulario_q<?php echo($i);?>">
			<input type="hidden" name="remover" value="<?php echo($i);?>">
		</form>
		<?php
	}
}
/*-------------------------------------------------------------------------------------------*/
?>