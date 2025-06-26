<?php
$reset=(true);
if(isset($_POST["insumo"])){
	$reset=(false);
	$id=($_POST["insumo"]);
	$cantidad=($_POST["cantidad"]);
	$estante=($_POST["estante"]);
	if(isset($_SESSION["lista"])){
		//Si el array ya tiene elementos, le agrego otro elemento
		$cantidad_array=(count($_SESSION['lista']));
		$duplicado=(false);
		for($i=0;$i<$cantidad_array;$i++){
			$id_array=($_SESSION['lista'][$i][0]);
			$estante_array=($_SESSION['lista'][$i][2]);
			if($id_array == $id AND  $estante_array == $estante){
				$duplicado=(true);
				$cantidad_anterior=($_SESSION['lista'][$i][1]);
				$cantidad=($cantidad_anterior+$cantidad);
				$_SESSION['lista'][$i][1]=$cantidad;
			}
		}
		if($duplicado==false){
			$insumo_tmp=(array(array("$id","$cantidad","$estante")));
		    $insumo=(array_merge($_SESSION['lista'], $insumo_tmp));
			$_SESSION['lista']=($insumo);
		}

	}else{
		//Si no existe el arreglo
		$insumo=(array(array("$id","$cantidad","$estante")));
		$_SESSION['lista']=($insumo);
	}
}
/*-------------------------------------------------------------------------------*/
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
/*-------------------------------------------------------------------------------*/
?>
<script type="text/javascript">
	function agregar(){
		var cantidad=document.getElementsByName("cantidad")[0].value;
		if(cantidad>0){
			document.formulario_agregar.submit();
		}else{
			alert("La cantidad de insumos debe ser mayor a 0.");
		}
	}
</script>
<div class="limiter">
  <div class="container-login1000">
    <div class="wrap-login1000">
      <h2 align="center" style="padding-bottom: 10px;">Procesar entrada de insumo(s) (Almacen)</h2>
		<table width="100%" border="1">
			<thead align="center" style="font-weight: bold;background-color: #D5D5D5;">
				<tr>
					<td colspan="4">Seleccionar insumo</td>
					<td width="140px">Cantidad</td>
					<td width="140px">Estante</td>
					<td width="80px">Agregar</td>
				</tr>
			</thead>
			<form action="index.php?ruta=p-entrada" method="post" name="formulario_agregar">
				<tbody align="center">
					<tr>
						<td colspan="4">
							<select name="insumo">
								<?php
								$query=($mysql->query("SELECT * FROM insumos"));
								while($row=(mysqli_fetch_assoc($query))){
								?>
								<option value="<?php echo($row['id']);?>">
									Código: <?php echo($row['codigo']);?> | Nombre: <?php echo($row['nombre']);?>	
								</option>
								<?php }?>
							</select>
						</td>
						<td>
							<input type="number" name="cantidad" placeholder="Cantidad" title="Cantidad" autocomplete="off" required>
						</td>
						<td>
							<input type="text" name="estante" placeholder="Estante" title="Estante" autocomplete="off" required>
						</td>
						<td>
							<a href="#!Secure" onclick="agregar();">
								<img src="../images/mas.png" alt="Agregar" title="Pulse para agregar a la lista." width="50px">
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
							Insumos en lista:
						</h4>
					</td>
				</tr>
				<tr style="font-weight: bold;background-color: #F6CEF5;">
					<td width="100px">Código</td>
					<td>Nombre</td>
					<td>Tipo</td>
					<td>Cantidad</td>
					<td>Estante</td>
					<td>Descripción</td>
					<td>Quitar</td>
				</tr>
			</thead>
			<script type="text/javascript">
				function procesar(){
					document.procesar_formulario.submit();
				}
			</script>
			<form action="index.php?ruta=p-entrada2" method="post" name="procesar_formulario">
				<?php
				$cantidad_lista=(count($_SESSION['lista']));
				for($i=0;$i<$cantidad_lista;$i++){
					$id=($_SESSION['lista'][$i][0]);
					$cantidad=($_SESSION['lista'][$i][1]);
					$estante=($_SESSION['lista'][$i][2]);
					$query=$mysql->query("SELECT * FROM insumos WHERE id='".$id."'");
					$row=(mysqli_fetch_assoc($query));
					//tipo de embalaje
					$query2=($mysql->query("SELECT * FROM embalaje WHERE id='".($row["tipo"])."'"));
	                $row2=(mysqli_fetch_assoc($query2));
				?>
				<tbody align="center">
					<td><?php echo($row["codigo"]);?></td>
					<td><?php echo($row["nombre"]);?></td>
					<td><?php echo($row2["nombre"]);?></td>
					<td><?php echo($cantidad);?></td>
					<td><?php echo($estante);?></td>
					<td><?php echo($row["descripcion"]);?></td>
					<td>
						<a href="#!Secure" onclick="quitar_<?php echo($i);?>();">
							<img src="../images/menos.png" alt="quitar" title="Pulse para quitar de la lista." width="50px">
						</a>
					</td>
				</tbody>
				<?php }/*fin for*/?>
				<tbody align="center">
					<td colspan="7">
						<textarea name="nota" title="Nota de entrada (Opcional)" placeholder="Escriba una nota de entrada (Opcional)"></textarea>
					</td>
				</tbody>
			</form>
			<?php }/*Fin isset*/?>
		</table>
		<?php if(isset($_SESSION['lista'])){?>
		<br>
		<center>
			<input type="button" name="procesar" value="Procesar" onclick="procesar();">
		</center>
		<?php }?>
    </div>
  </div>
</div>
<?php
/*------------------------------------------------------*/ 
/*Quitar insumos de la lista*/
for($i=0;$i<$cantidad_lista;$i++){
	?>
	<script type="text/javascript">
		function quitar_<?php echo($i);?>(){
			document.formulario_q<?php echo($i);?>.submit();
		}
	</script>
	<form action="index.php?ruta=p-entrada" method="post" name="formulario_q<?php echo($i);?>">
		<input type="hidden" name="remover" value="<?php echo($i);?>">
	</form>
	<?php
}
/*------------------------------------------------------*/
?>