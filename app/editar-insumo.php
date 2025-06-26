<?php
if(!isset($_POST["ref"])){
    include("home.php");
}else{
    if(isset($_POST["nombre"])){
        $mysql->query("UPDATE insumos SET nombre='".$_POST["nombre"]."',
                                            tipo='".$_POST["tipo"]."',
                                            descripcion='".$_POST["descripcion"]."' WHERE id='".$_POST["ref"]."'");
    ?>
    <script type="text/javascript">
        alert("¡Enhorabuena! Insumo actualizado con éxito.");
    </script>
    <?php
    }
    $query=($mysql->query("SELECT * FROM insumos WHERE id='".$_POST["ref"]."'"));
    $row=(mysqli_fetch_assoc($query));
?>
<div class="limiter">
  <div class="container-login1000">
    <div class="wrap-login1000">
    	<h4 align="center">Editar insumo</h4>
    	<br>
    	<form action="index.php?ruta=editar-insumo" method="post">
            <input type="hidden" name="ref" value="<?php echo($_POST['ref']);?>">
    		<table border="0" width="100%" align="center">
    			<tr align="center">
                    <td>
                        <input type="text" name="codigo" title="Código del insumo" placeholder="Código del insumo" autocomplete="off" disabled value="<?php echo($row['codigo']);?>">
                    </td>
    				<td>
    					<input type="text" name="nombre" title="Nombre del insumo" placeholder="Nombre del insumo" autocomplete="off" required value="<?php echo($row['nombre']);?>">
    				</td>
    				<td>
    					 <select name="tipo" name="Tipo de embalaje" title="Tipo de embalaje" required>
    						<option disabled>(Tipo de Embalaje)</option>
                            <?php
                                $query2=($mysql->query("SELECT * FROM embalaje"));
                                while($row2=(mysqli_fetch_assoc($query2))){
                            ?>
    						<option value="<?php echo($row2['id']);?>" <?php if($row2['id']==$row['tipo']){echo('selected');}?>><?php echo($row2["nombre"]);?></option>
                            <?php }?>
                        </select>
    				</td>
    			</tr>
    			<tr>
    				<td colspan="3">&nbsp;</td>
    			</tr>
    			<tr align="center">
    				<td colspan="3">
    					<textarea name="descripcion" title="Descripción del insumo (Opcional)" placeholder="Descripción del insumo (Opcional)"><?php echo($row['descripcion']);?></textarea>
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