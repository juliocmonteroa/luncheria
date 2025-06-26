<?php
if(isset($_POST["codigo"])){
    $query_x=$mysql->query("SELECT id FROM insumos WHERE codigo='".$_POST["codigo"]."'");
    $row_x=(mysqli_fetch_assoc($query_x));
    if($row_x["id"]>0){
        ?>
        <script type="text/javascript">
            alert("Error! Insumo NO agregado Código en uso, por favor intente nuevamente.");
        </script>
        <?php
    }else{
        $mysql->query("INSERT INTO insumos(codigo,nombre,tipo,descripcion,fecha) VALUES('".$_POST["codigo"]."','".$_POST["nombre"]."','".$_POST["tipo"]."','".$_POST["descripcion"]."',now())");
        ?>
        <script type="text/javascript">
            alert("¡Enhorabuena! insumo agregado con éxito.");
        </script>
        <?php
    }
}
?>
<div class="limiter">
  <div class="container-login1000">
    <div class="wrap-login1000">
    	<h4 align="center">Agregar insumo</h4>
    	<br>
    	<form action="index.php?ruta=a-insumo" method="post">
    		<table border="0" width="100%" align="center">
    			<tr align="center">
                    <td>
                        <input type="text" name="codigo" title="Código del insumo" placeholder="Código del insumo" autocomplete="off" required>
                    </td>
    				<td>
    					<input type="text" name="nombre" title="Nombre del insumo" placeholder="Nombre del insumo" autocomplete="off" required>
    				</td>
    				<td>
    					 <select name="tipo" title="Tipo de embalaje" required>
    						<option disabled>(Tipo de Embalaje)</option>
                            <?php
                                $query2=($mysql->query("SELECT * FROM embalaje"));
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
    				<td colspan="3">
    					<textarea name="descripcion" title="Descripción del insumo (Opcional)" placeholder="Descripción del insumo (Opcional)"></textarea>
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