<?php
if(isset($_POST["nombre"])){
    $query=($mysql->query("SELECT * FROM usuarios WHERE email='".$_POST["email"]."' OR cedula='".$_POST["cedula"]."'"));
    $row=(mysqli_fetch_assoc($query));
    if($row["id"]>0){
        ?>
        <script type="text/javascript">
            alert("Error! Usuario NO registrado. E-mail / C.I en uso.");
        </script>
        <?php
    }else{
        $mysql->query("INSERT INTO usuarios(nombre,nacionalidad,cedula,email,telefono,direccion,rol,clave,fecha) VALUES('".$_POST["nombre"]."','".$_POST["nacionalidad"]."','".$_POST["cedula"]."','".$_POST["email"]."','".$_POST["telefono"]."','".$_POST["direccion"]."','".$_POST["rol"]."','".encriptacionBASE64($_POST["clave"])."',now())");
        ?>
        <script type="text/javascript">
            alert("¡Enhorabuena! Usuario del sistema. agregado con éxito.");
        </script>
        <?php
    }
}
?>
<div class="limiter">
  <div class="container-login1000">
    <div class="wrap-login1000">
    	<h4 align="center">Agregar usuario del sistema</h4>
    	<br>
    	<form action="index.php?ruta=a-usuario" method="post">
    		<table border="0" width="100%" align="center">
    			<tr align="center">
                    <td>
                        <input type="text" name="nombre" title="Nombre completo" placeholder="Nombre completo" autocomplete="off" required>
                    </td>
                    <td>
                         <select name="nacionalidad" title="Nacionalidad" required>
                            <option disabled> (Nacionalidad) </option>
                            <option value="V"> V- Venezolano </option>
                            <option value="E"> E- Extranjero </option>
                        </select>
                    </td>
    				<td>
    					<input type="number" name="cedula" title="Cédula de identidad" placeholder="Cédula de identidad" autocomplete="off" required>
    				</td>
    				<td>
    			</tr>
    			<tr>
    				<td colspan="3">&nbsp;</td>
    			</tr>
                <tr align="center">
                    <td>
                        <input type="email" name="email" title="Correo electrónico" placeholder="Correo electrónico" autocomplete="off" required>
                    </td>
                    <td>
                        <input type="text" name="telefono" title="Teléfono (Opcional)" placeholder="Teléfono (Opcional)" autocomplete="off">
                    </td>
                    <td colspan="3">
                        <select name="rol" title="Rango dentro del sistema" required>
                            <option disabled> (Rango dentro del sistema) </option>
                            <option value="2"> Empleado </option>
                            <option value="1"> Administrador </option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">&nbsp;</td>
                </tr>
    			<tr align="center">
    				<td colspan="2">
    					  <textarea class="textarea2" name="direccion" title="Dirección" placeholder="Dirección (Opcional)"></textarea>
    				</td>
                    <td>
                        <input type="text" name="clave" title="Contraseña de acceso" placeholder="Contraseña de acceso" autocomplete="off" required>
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