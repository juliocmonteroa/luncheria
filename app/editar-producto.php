<?php
if(!isset($_POST["ref"])){
    include("home.php");
}else{
    if(isset($_POST["nombre"])){
        if($_POST["limite"]==0){
            $cantidad=($_POST["cantidad"]);
            if($cantidad<0){
                $cantidad=(0);
            }
        }else{
            $cantidad=(0);
        }
        if($_POST["precio"]>0){
            $precio=($_POST["precio"]);
        }else{
            $precio=(0);
        }
        $mysql->query("UPDATE productos SET nombre='".$_POST["nombre"]."',
                                            presentacion='".$_POST["presentacion"]."',
                                            descripcion='".$_POST["descripcion"]."',
                                            limite='".$_POST["limite"]."',
                                            cantidad='".$cantidad."',
                                            precio='".$precio."' WHERE id='".$_POST["ref"]."'");
    ?>
    <script type="text/javascript">
        alert("¡Enhorabuena! Producto actualizado con éxito.");
    </script>
    <?php
    }
    $query=($mysql->query("SELECT * FROM productos WHERE id='".$_POST["ref"]."'"));
    $row=(mysqli_fetch_assoc($query));
    if($row['limite']==1){
        $cantidad=("");
    }else{
        $cantidad=($row['cantidad']);
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
    	<h4 align="center">Editar presentación</h4>
    	<br>
    	<form action="index.php?ruta=editar-producto" method="post">
            <input type="hidden" name="ref" value="<?php echo($_POST['ref']);?>">
    		<table border="0" width="100%" align="center">
    			<tr align="center">
                    <td>
                        <input type="text" name="codigo" title="Código del presentacion" placeholder="Código del presentacion" autocomplete="off" disabled value="<?php echo($row['codigo']);?>">
                    </td>
    				<td>
    					<input type="text" name="nombre" title="Nombre del presentacion" placeholder="Nombre del presentacion" autocomplete="off" required value="<?php echo($row['nombre']);?>">
    				</td>
    				<td>
    					 <select name="presentacion" name="Tipo de presentacion" title="Tipo de presentacion" required>
    						<option disabled>(Tipo de Presentación)</option>
                            <?php
                                $query2=($mysql->query("SELECT * FROM presentacion"));
                                while($row2=(mysqli_fetch_assoc($query2))){
                            ?>
    						<option value="<?php echo($row2['id']);?>" <?php if($row2['id']==$row['presentacion']){echo('selected');}?>><?php echo($row2["nombre"]);?></option>
                            <?php }?>
                        </select>
    				</td>
    			</tr>
    			<tr>
    				<td colspan="3">&nbsp;</td>
    			</tr>
    			<tr align="center">
    				<td colspan="2">
    					<textarea name="descripcion" title="Descripción del presentacion (Opcional)" placeholder="Descripción del presentacion (Opcional)" rows="6"><?php echo($row['descripcion']);?></textarea>
    				</td>
                    <td>
                        <input type="number" name="precio" title="Precio del producto en $" placeholder="Precio del producto en $" autocomplete="off" required value="<?php echo($row['precio']);?>" step='0.01'>
                        <br><br>
                        <select id="limite" name="limite" title="Cantidad limite"  onchange="limite(1);" required>
                            <option disabled>(Tipo de limite de existencias)</option>
                            <option value="1" <?php if($row['limite']==1){echo(" selected ");}?>>Cantidad SIN limite de existencias</option>
                            <<option value="0" <?php if($row['limite']==0){echo(" selected ");}?>>Cantidad CON limite de existencias</option>
                        </select>
                        <input type="number" id="cantidad" name="cantidad" title="Cantidad del producto" placeholder="Cantidad del producto" autocomplete="off" <?php if($row['limite']==1){echo(" disabled ");}?> required value="<?php echo($cantidad);?>">
                    </td>
    			</tr>
    			<tr>
    				<td colspan="3">&nbsp;</td>
    			</tr>
    			<tr align="center">
    				<td colspan="3">
    					<input type="submit" name="editar" value="Editar">
    				</td>
    			</tr>
    		</table>
    	</form>
    </div>
  </div>
</div>
<?php
}
?>