<?php
unset($_SESSION['lista']);
if(!isset($_POST["ref"])){
	?>
	<script type="text/javascript">
		window.location.href="../index.html";
	</script>
	<?php
}else{
	$query=($mysql->query("SELECT * FROM usuarios WHERE id='".$_POST["ref"]."'"));
	$row=(mysqli_fetch_assoc($query));
	if($row["rol"]==1){
        $rol=("Administrador");
    }else{
        $rol=("Empleado");
    }
?>
<script type="text/javascript">
  function imprimir(usuario){
    var contenido= document.getElementById(usuario).innerHTML;
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
			<center>
				<input type="button" name="imprimir" value="Imprimir" onclick="imprimir('usuario');">
			</center>
			<br>
			<div id="usuario">
				<h4 align="center">Usuario del sistema registrado</h4>
				<br>
				<table width="100%" border="1">
        			<thead style="font-weight: bold;background-color: #D5D5D5;">
        				<tr>
        					<th style="text-align: center;">Fecha de registro</th>
        					<th style="text-align: center;">Nombre</th>
        					<th style="text-align: center;">C.I</th>
        				</tr>
        			</thead>
        			<tbody align="center">
        				<tr>
        					<td><?php echo(fechaHora($row["fecha"]));?></td>
        					<td><?php echo($row["nombre"]);?></td>
        					<td><?php echo($row["nacionalidad"]."-".$row["cedula"]);?></td>
        				</tr>
        			</tbody>
        			<thead style="font-weight: bold;background-color: #D5D5D5;">
        				<tr>
        					<th style="text-align: center;">E-mail</th>
        					<th style="text-align: center;">Teléfono</th>
        					<th style="text-align: center;">Rol</th>
        				</tr>
        			</thead>
        			<tbody align="center">
        				<tr>
        					<td><?php echo($row["email"]);?></td>
        					<td><?php echo($row["telefono"]);?></td>
        					<td><?php echo($rol);?></td>
        				</tr>
        			</tbody>
        			<thead style="font-weight: bold;background-color: #D5D5D5;">
        				<tr>
        					<th colspan="3" style="text-align: center;">Dirección</th>
        				</tr>
        			</thead>
        			<tbody align="center">
        				<tr>
        					<td colspan="3"><?php echo($row["direccion"]);?>&nbsp;</td>
        				</tr>
        			</tbody>
    			</table>
			</div>
		</div>
	</div>
</div>
<?php }?>