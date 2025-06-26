<div class="limiter">
  <div class="container-login1000">
    <div class="wrap-login1000">
    	<h4 align="center">Consultar usuario del sistema</h4>
    	<br>
    		<table border="0" width="100%" align="center">
                <form action="index.php?ruta=c-usuario" method="post">
    			<tr align="center">
                    <td>
                        <input type="search" name="usuario" title="Escriba el nombre / cédula del usuario a buscar." placeholder="Escriba el nombre / cédula del usuario a buscar" autocomplete="off" required>
                    </td>
                    <td>
                        <input style="width: 100%" type="submit" name="buscar" value="Buscar">
                    </td>
                </tr>
                </form>
                <tr>
                    <td colspan="2">&nbsp;</td>
                </tr>
                <?php
                if(isset($_POST["usuario"])){
                    $query=($mysql->query("SELECT * FROM usuarios WHERE nombre LIKE '%".$_POST["usuario"]."%' OR cedula LIKE '%".$_POST["usuario"]."%'"));
                    $contador=0;
                ?>
                <tr>
                    <td colspan="2">
                        <table width="100%" border="1">
                            <caption><em>Resultado de la busqueda: <?php echo($_POST["usuario"]);?></em></caption>
                            <thead align="center" style="font-weight: bold;background-color: #D5D5D5;">
                                <tr>
                                    <td>Nro.</td>
                                    <td>Nombre</td>
                                    <td>C.I</td>
                                    <td>Rol</td>
                                    <td width="60px">Ver</td>
                                    <td width="70px">Editar</td>
                                    <td width="80px">Eliminar</td>
                                </tr>
                            </thead>
                            <tbody align="center">
                                <?php
                                while($row=mysqli_fetch_assoc($query)){
                                    $contador+=1;
                                    if($row["rol"]==1){
                                        $rol=("Administrador");
                                    }else{
                                        $rol=("Empleado");
                                    }
                                    ?>
                                    <tr>
                                        <td width="60px"><?php echo($contador);?></td>
                                        <td><?php echo($row["nombre"]);?></td>
                                        <td><?php echo($row["nacionalidad"]."-".$row["cedula"]);?></td>
                                        <td><?php echo($rol);?></td>
                                        <td>
                                            <script type="text/javascript">
                                                function ver_<?php echo($contador);?>(){
                                                      
                                                    document.ver_f_<?php echo($contador);?>.submit();
                                                }
                                            </script>
                                            <form action="?ruta=ver-usuario" method="post" name="ver_f_<?php echo($contador);?>">
                                                <input type="hidden" name="ref" value="<?php echo($row['id']);?>">
                                            </form>
                                            <a href="#!Secure" title="Ver" onclick="ver_<?php echo($contador);?>();">
                                                <img src="../images/ver.png" alt="Editar" width="50px">
                                            </a>
                                        </td>
                                        <td>
                                            <script type="text/javascript">
                                                function editar_<?php echo($contador);?>(){
                                                    if (confirm('¿Esta seguro de editar este usuario?')){
                                                        document.editar_f_<?php echo($contador);?>.submit();
                                                    }
                                                }
                                            </script>
                                            <form action="?ruta=editar-usuario" method="post" name="editar_f_<?php echo($contador);?>">
                                                <input type="hidden" name="ref" value="<?php echo($row['id']);?>">
                                            </form>
                                            <a href="#!Secure" title="Editar" onclick="editar_<?php echo($contador);?>();">
                                                <img src="../images/editar.png" alt="Editar" width="50px">
                                            </a>
                                        </td>
                                        <td>
                                            <script type="text/javascript">
                                                function eliminar_<?php echo($contador);?>(){
                                                    if (confirm('¿Esta seguro de eliminar este usuario?')){
                                                        document.eliminar_f_<?php echo($contador);?>.submit();
                                                    }
                                                }
                                            </script>
                                            <form action="?ruta=eliminar-usuario" method="post" name="eliminar_f_<?php echo($contador);?>">
                                                <input type="hidden" name="ref" value="<?php echo($row['id']);?>">
                                            </form>
                                            <a href="#!Secure" title="Eliminar" onclick="eliminar_<?php echo($contador);?>();">
                                               <img src="../images/eliminar.svg" alt="Eliminar" width="50px">
                                            </a>
                                        </td>
                                    </tr>
                                    <?php
                                }//fin while
                                if($contador==0){
                                    ?>
                                    <tr>
                                        <td colspan="7" align="center">No hay resultados.</td>
                                    </tr>
                                    <?php
                                }//fin isset usuario
                                ?>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <?php }/*Fin isset usuario*/?>
    		</table>
        </div>
    </div>
</div>