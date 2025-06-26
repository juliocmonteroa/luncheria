<?php
if(isset($_POST["codigo"])){
    $query_x=$mysql->query("SELECT id FROM productos WHERE codigo='".$_POST["codigo"]."' OR nombre='".$_POST["nombre"]."'");
    $row_x=(mysqli_fetch_assoc($query_x));
    if($row_x["id"]>0){
        ?>
        <script type="text/javascript">
            alert("Error! Producto NO agregado Código/Nombre en uso, por favor intente nuevamente.");
        </script>
        <?php
    }else{
        if(!isset($_POST["cantidad"])){
            $cantidad=(0);
        }else{
            if($_POST["cantidad"]>0){
               $cantidad=($_POST["cantidad"]); 
           }else{
                $cantidad=(0);
           }
            
        }
        if(isset($_POST["precio_soloenBS"])){
            if($_POST["precio_soloenBS"]==true){
                $precio_soloenBS=(1);
            }else{
                $precio_soloenBS=(0);
            }
        }else{
            $precio_soloenBS=(0);
        }
        $mysql->query("INSERT INTO productos(codigo,nombre,presentacion,descripcion,limite,cantidad,precio,precio_soloenBS,fecha) VALUES('".$_POST["codigo"]."','".$_POST["nombre"]."','".$_POST["presentacion"]."','".$_POST["descripcion"]."','".$_POST["limite"]."','".$cantidad."','".$_POST["precio"]."','".$precio_soloenBS."',now())");
        ?>
        <script type="text/javascript">
            alert("¡Enhorabuena! Producto agregado con éxito.");
        </script>
        <?php
    }
}
?>
<script type="text/javascript">
    $( function() {
    $("#limite").change( function() {
        if($(this).val() === "1") {
            $("#cantidad").prop("disabled", true);
        } else {
            $("#cantidad").prop("disabled", false);
        }
    });
});
</script>
<div class="limiter">
  <div class="container-login1000">
    <div class="wrap-login1000">
    	<h4 align="center">Agregar producto</h4>
    	<br>
    	<form action="index.php?ruta=a-producto" method="post">
    		<table border="0" width="100%" align="center">
    			<tr align="center">
                    <td>
                        <input type="text" name="codigo" title="Código del producto" placeholder="Código del producto" autocomplete="off" required>
                    </td>
    				<td>
    					<input type="text" name="nombre" title="Nombre del producto" placeholder="Nombre del producto" autocomplete="off" required>
    				</td>
    				<td>
    					 <select name="presentacion" title="Tipo de presentacion" required>
    						<option disabled>(Tipo de presentacion)</option>
                            <?php
                                $query2=($mysql->query("SELECT * FROM presentacion"));
                                while($row2=(mysqli_fetch_assoc($query2))){
                            ?>
    						<option value="<?php echo($row2['id']);?>"><?php echo($row2["nombre"]);?></option>
                            <?php }?>
    					</select>
    				</td>
    			</tr>
    			<tr>
    				<td colspan="3">&nbsp;</td>
    			</tr>
    			<tr align="center">
    				<td colspan="2">
    					<textarea name="descripcion" title="Descripción del producto (Opcional)" placeholder="Descripción del producto (Opcional)" rows="6"></textarea>
    				</td>
                    <td>
                        <input type="number" name="precio" title="Precio del producto en $" placeholder="Precio del producto en $" autocomplete="off" required step='0.001'>
                        <br><br>
                            <p>Aplicar precio sólo en bolívares <input type="checkbox" name="precio_soloenBS"></p>
                        <br>
                        <select id="limite" name="limite" title="Cantidad limite"  onchange="limite(1);" required>
                            <option disabled>(Tipo de limite de existencias)</option>
                            <option value="1">Cantidad SIN limite de existencias</option>
                            <option value="0">Cantidad CON limite de existencias</option>
                        </select>
                        <input type="text" id="cantidad" name="cantidad" title="Cantidad del producto" placeholder="Cantidad del producto" autocomplete="off" disabled required>
                    </td>
    			</tr>
    			<tr>
    				<td colspan="3">&nbsp;</td>
    			</tr>
    			<tr align="center">
    				<td colspan="3">
    					<input type="submit" name="agregar" value="Agregar">
    				</td>
    			</tr>
    		</table>
    	</form>
    </div>
  </div>
</div>