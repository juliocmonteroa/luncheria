<?php
$reset=(true);
if(isset($_POST["insumo"])){
	$reset=(false);
	$id=($_POST["insumo"]);
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
			$insumo_tmp=(array(array("$id")));
		    $insumo=(array_merge($_SESSION['lista'], $insumo_tmp));
			$_SESSION['lista']=($insumo);
		}
	}else{
		//Si no existe el arreglo
		$insumo=(array(array("$id")));
		$_SESSION['lista']=($insumo);
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
/*-------------------------------------------------------------------------------*/
?>
<script type="text/javascript">
	function agregar(){
		var cantidad=document.getElementsByName("insumo")[0].value;
		if(cantidad>0){
			document.formulario_agregar.submit();
		}else{
			alert("No hay insumos disponibles.");
		}
	}
</script>
<div class="limiter">
  <div class="container-login1000">
    <div class="wrap-login1000">
      <h2 align="center" style="padding-bottom: 10px;">Procesar salida de insumo(a) (Almacen)</h2>
		<table width="100%" border="1">
			<thead align="center" style="font-weight: bold;background-color: #D5D5D5;">
				<tr>
					<td colspan="6">Seleccionar insumo</td>
					<td>Agregar</td>
				</tr>
			</thead>
			<form action="index.php?ruta=p-salida" method="post" name="formulario_agregar">
				<tbody align="center">
					<tr>
						<td colspan="6">
							<select name="insumo">
								<?php
								$query=($mysql->query("SELECT * FROM existencias WHERE cantidad>0"));
								$contador+=(0);
								while($row=(mysqli_fetch_assoc($query))){
									$contador+=(1);
									$query2=($mysql->query("SELECT * FROM insumos WHERE id='".$row["id_insumos"]."'"));
									$row2=(mysqli_fetch_assoc($query2));
								?>
								<option value="<?php echo($row['id']);?>">
									Código: <?php echo($row2['codigo']);?> | Nombre: <?php echo($row2['nombre']);?>	| Disponible: <?php echo($row['cantidad']);?> | Estante: <?php echo($row['estante']);?>
								</option>
								<?php }
								if($contador<=0){
									?>
									<option value="0"> No hay insumos disponibles. </option>
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
							Insumos en lista:
						</h4>
						<em>Nota: Recuerde colocar la nota de salida y seleccionar la cantidad despues de terminar de agregar todos los poductos.</em>
					</td>
				</tr>
				<tr style="font-weight: bold;background-color: #F6CEF5 ;">
					<td width="100px">Código</td>
					<td>Nombre</td>
					<td>Tipo</td>
					<td>Descripción</td>
					<td>Estante</td>
					<td>Cantidad</td>
					<td>Quitar</td>
				</tr>
			</thead>
			<script type="text/javascript">
				function procesar(){
					document.procesar_formulario.submit();
				}
			</script>
			<form action="index.php?ruta=p-salida2" method="post" name="procesar_formulario">
				<?php
				$cantidad_lista=(count($_SESSION['lista']));
				$contador=(0);
				for($i=0;$i<$cantidad_lista;$i++){
					$contador+=(1);
					$id=($_SESSION['lista'][$i][0]);
					$query=$mysql->query("SELECT * FROM existencias WHERE id='".$id."'");
					$row=(mysqli_fetch_assoc($query));
					$query2=$mysql->query("SELECT * FROM insumos WHERE id='".$row["id_insumos"]."'");
					$row2=(mysqli_fetch_assoc($query2));
					//tipo de embalaje
					$query3=($mysql->query("SELECT * FROM embalaje WHERE id='".($row2["tipo"])."'"));
	                $row3=(mysqli_fetch_assoc($query3));
				?>
				
				<tbody align="center">
					<td><?php echo($row2["codigo"]);?></td>
					<td><?php echo($row2["nombre"]);?></td>
					<td><?php echo($row3["nombre"]);?></td>
					<td><?php echo($row2["descripcion"]);?></td>
					<td><?php echo($row["estante"]);?></td>
					<td>
						<select name="cantidad_<?php echo($i);?>">
							<?php for($ii=0;$ii<$row["cantidad"];$ii++){?>
								<option><?php echo($ii+1)?></option>
							<?php }?>
						</select>
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
						<textarea name="nota" title="Nota de salida (Opcional)" placeholder="Escriba una nota de salida (Opcional)"></textarea>
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
	<form action="index.php?ruta=p-salida" method="post" name="formulario_q<?php echo($i);?>">
		<input type="hidden" name="remover" value="<?php echo($i);?>">
	</form>
	<?php
}
/*------------------------------------------------------*/
?>