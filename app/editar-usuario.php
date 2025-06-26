<?php
if(!isset($_POST["ref"])){
    ?>
  <script type="text/javascript">
    window.location.href="../index.html";
  </script>
  <?php
}
if(isset($_POST["nombre"])){
    $mysql->query("UPDATE usuarios SET nombre='".$_POST["nombre"]."',
                                    nacionalidad='".$_POST["nacionalidad"]."',
                                    cedula='".$_POST["cedula"]."',
                                    email='".$_POST["email"]."',
                                    telefono='".$_POST["telefono"]."',
                                    direccion='".$_POST["direccion"]."',
                                    rol='".$_POST["rol"]."',
                                    clave='".encriptacionBASE64($_POST["clave"])."' 
                                    WHERE id='".$_POST["ref"]."'");
    ?>
    <script type="text/javascript">
        alert("¡Enhorabuena! Usuario del sistema. actualizado con éxito.");
    </script>
    <?php
}
 $query=($mysql->query("SELECT * FROM usuarios WHERE id='".$_POST["ref"]."'"));
 $row=(mysqli_fetch_assoc($query));
?>
<div class="limiter">
  <div class="container-login1000">
    <div class="wrap-login1000">
    	<h4 align="center">Actualización usuario</h4>
    	<br>
    	<form action="index.php?ruta=editar-usuario" method="post">
            <input type="hidden" name="ref" value="<?php echo($_POST['ref']);?>">
    		<table border="0" width="100%" align="center">
    			<tr align="center">
                    <td>
                        <input type="text" name="nombre" title="Nombre completo" placeholder="Nombre completo" autocomplete="off" required value="<?php echo($row['nombre']);?>">
                    </td>
                    <td>
                         <select name="nacionalidad" title="Nacionalidad" required>
                            <option disabled> (Nacionalidad) </option>
                            <option value="V" <?php if($row["nacionalidad"]=="V"){echo("selected");}?>> V- Venezolano </option>
                            <option value="E" <?php if($row["nacionalidad"]=="E"){echo("selected");}?>> E- Extranjero </option>
                        </select>
                    </td>
    				<td>
    					<input type="number" name="cedula" title="Cédula de identidad" placeholder="Cédula de identidad" autocomplete="off" required value="<?php echo($row['cedula']);?>">
    				</td>
    				<td>
    			</tr>
    			<tr>
    				<td colspan="3">&nbsp;</td>
    			</tr>
                <tr align="center">
                    <td>
                        <input type="text" name="email" title="Correo electrónico" placeholder="Correo electrónico" autocomplete="off" required value="<?php echo($row['email']);?>">
                    </td>
                    <td>
                        <input type="text" name="telefono" title="Teléfono (Opcional)" placeholder="Teléfono (Opcional)" autocomplete="off" value="<?php echo($row['telefono']);?>">
                    </td>
                    <td colspan="3">
                        <select name="rol" title="Rango dentro del sistema" required>
                            <option disabled> (Rango dentro del sistema) </option>
                            <option value="2" <?php if($row["rol"]==2){echo("selected");}?>> Empleado </option>
                            <option value="1" <?php if($row["rol"]==1){echo("selected");}?>> Administrador </option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">&nbsp;</td>
                </tr>
    			<tr align="center">
    				<td colspan="2">
    					  <textarea class="textarea2" name="direccion" title="Dirección" placeholder="Dirección (Opcional)"><?php echo($row['direccion']);?></textarea>
    				</td>
                    <td>
                        <input type="text" name="clave" title="Contraseña de acceso" placeholder="Contraseña de acceso" autocomplete="off" required value="<?php echo(desencriptacionBASE64($row['clave']));?>">
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