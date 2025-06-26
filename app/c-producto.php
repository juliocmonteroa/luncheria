<?php
unset($_SESSION['lista']);
?>
<div class="limiter">
  <div class="container-login1000">
    <div class="wrap-login1000">
    	<h4 align="center">Consultar producto(s)</h4>
    	<br>
    		<table border="0" width="100%" align="center">
                <form action="index.php?ruta=c-producto" method="post">
    			<tr align="center">
                    <td>
                        <input type="search" name="producto" title="Escriba el código / nombre del producto a buscar" placeholder="Escriba el código / nombre del producto a buscar" autocomplete="off" required>
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
                if(isset($_POST["producto"])){
                    $query=($mysql->query("SELECT * FROM productos WHERE codigo LIKE '%".$_POST["producto"]."%' OR nombre LIKE '%".$_POST["producto"]."%'"));
                    $contador=0;
                ?>
                <tr>
                    <td colspan="2">
                        <table width="100%" border="1">
                            <caption><em>Resultado de la busqueda: <?php echo($_POST["producto"]);?></em></caption>
                            <thead align="center" style="font-weight: bold;background-color: #D5D5D5;">
                                <tr>
                                    <td>Nro.</td>
                                    <td>Código</td>
                                    <td>Nombre</td>
                                    <td>Disponible(s)</td>
                                    <td width="60px">Ver</td>
                                    <?php if(desencriptacionBASE64($_SESSION["rol"])==1){?>
                                    <td width="70px">Editar</td>
                                    <td width="80px">Eliminar</td>
                                    <?php }?>
                                </tr>
                            </thead>
                            <tbody align="center">
                                <?php
                                while($row=mysqli_fetch_assoc($query)){
                                    if($row["limite"]==1){
                                        $cantidad=("Ilimitado");
                                    }else{
                                        $cantidad=($row["cantidad"]);
                                    }
                                    $contador+=1;
                                    ?>
                                    <tr>
                                        <td width="60px"><?php echo($contador);?></td>
                                        <td><?php echo($row["codigo"]);?></td>
                                        <td><?php echo($row["nombre"]);?></td>
                                        <td><?php echo($cantidad);?></td>
                                        <td>
                                            <script type="text/javascript">
                                                function ver_<?php echo($contador);?>(){
                                                      
                                                    document.ver_f_<?php echo($contador);?>.submit();
                                                }
                                            </script>
                                            <form action="?ruta=ver-producto" method="post" name="ver_f_<?php echo($contador);?>">
                                                <input type="hidden" name="ref" value="<?php echo($row['id']);?>">
                                            </form>
                                            <a href="#!Secure" title="Ver" onclick="ver_<?php echo($contador);?>();">
                                                <img src="../images/ver.png" alt="Editar" width="50px">
                                            </a>
                                        </td>
                                        <?php /*condicion rol admin*/
                                            if(desencriptacionBASE64($_SESSION["rol"])==1){?>
                                        <td>
                                            <script type="text/javascript">
                                                function editar_<?php echo($contador);?>(){
                                                    if (confirm('¿Esta seguro de editar este producto?')){
                                                        document.editar_f_<?php echo($contador);?>.submit();
                                                    }
                                                }
                                            </script>
                                            <form action="?ruta=editar-producto" method="post" name="editar_f_<?php echo($contador);?>">
                                                <input type="hidden" name="ref" value="<?php echo($row['id']);?>">
                                            </form>
                                            <a href="#!Secure" title="Editar" onclick="editar_<?php echo($contador);?>();">
                                                <img src="../images/editar.png" alt="Editar" width="50px">
                                            </a>
                                        </td>
                                        <td>
                                            <script type="text/javascript">
                                                function eliminar_<?php echo($contador);?>(){
                                                    if (confirm('¿Esta seguro de eliminar este producto y sus existencias?')){
                                                        document.eliminar_f_<?php echo($contador);?>.submit();
                                                    }
                                                }
                                            </script>
                                            <form action="?ruta=eliminar-producto" method="post" name="eliminar_f_<?php echo($contador);?>">
                                                <input type="hidden" name="ref" value="<?php echo($row['id']);?>">
                                            </form>
                                            <a href="#!Secure" title="Eliminar" onclick="eliminar_<?php echo($contador);?>();">
                                               <img src="../images/eliminar.svg" alt="Eliminar" width="50px">
                                            </a>
                                        </td>
                                        <?php }/*fin condicion rol admin*/?>
                                    </tr>
                                    <?php
                                }//fin while
                                if($contador==0){
                                    ?>
                                    <tr>
                                        <td colspan="7" align="center">No hay resultados.</td>
                                    </tr>
                                    <?php
                                }//fin isset producto
                                ?>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <?php }/*Fin isset producto*/?>
    		</table>
        </div>
    </div>
</div>