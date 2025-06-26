<?php
unset($_SESSION['lista']);
if(!isset($_POST["ref"])){
	?>
    <script type="text/javascript">
        window.location.href="../index.html";
    </script>
    <?php
}else{
	$query=($mysql->query("SELECT * FROM productos WHERE id='".$_POST["ref"]."'"));
	$row=(mysqli_fetch_assoc($query));
    $query3=($mysql->query("SELECT * FROM presentacion WHERE id='".$row["presentacion"]."'"));
    $presentacion=(mysqli_fetch_assoc($query3));
    if($row["limite"]==1){
        $cantidad=("Ilimitado");
    }else{
        $cantidad=($row["cantidad"]);
    }
}
?>
<script type="text/javascript">
  function imprimir(producto){
    var contenido= document.getElementById(producto).innerHTML;
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
    			<input type="button" name="imprimir" value="Imprimir" onclick="imprimir('producto');">
    		</center>
    		<br>
			<div id="producto">
				<h4 align="center">Productos registrado</h4>
				<br>
    			<table width="100%" border="1">
        			<thead style="font-weight: bold;background-color: #D5D5D5;">
        				<tr>
        					<th style="text-align: center;">Fecha de registro</th>
        					<th style="text-align: center;">Código</th>
        					<th style="text-align: center;">Nombre</th>
        				</tr>
        			</thead>
        			<tbody align="center">
        				<tr>
        					<td><?php echo(fechaHora($row["fecha"]));?></td>
        					<td><?php echo($row["codigo"]);?></td>
        					<td><?php echo($row["nombre"]);?></td>
        				</tr>
        			</tbody>
        			<thead style="font-weight: bold;background-color: #D5D5D5;">
        				<tr>
        					<th style="text-align: center;">Presentación</th>
        					<th style="text-align: center;">Disponible</th>
        					<th style="text-align: center;">Descripción</th>
        				</tr>
        			</thead>
        			<tbody align="center">
        				<tr>
        					<td><?php echo($presentacion["nombre"]);?></td>
        					<td><?php echo($cantidad);?></td>
        					<td><?php echo($row["descripcion"]);?></td>
        				</tr>
        			</tbody> 
    			</table>
    		</div>
        </div>
    </div>
</div>