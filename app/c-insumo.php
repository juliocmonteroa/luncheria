<?php
unset($_SESSION['lista']);
?>
<div class="limiter">
  <div class="container-login1000">
    <div class="wrap-login1000">
    	<h4 align="center">Consultar insumo(s)</h4>
    	<br>
    		<table border="0" width="100%" align="center">
                <form action="index.php?ruta=c-insumo" method="post">
    			<tr align="center">
                    <td>
                        <input type="search" name="insumo" title="Escriba el código / nombre del insumo a buscar" placeholder="Escriba el código / nombre del insumo a buscar" autocomplete="off" required>
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
                if(isset($_POST["insumo"])){
                    $query=($mysql->query("SELECT * FROM insumos WHERE codigo LIKE '%".$_POST["insumo"]."%' OR nombre LIKE '%".$_POST["insumo"]."%'"));
                    $contador=0;
                ?>
                <tr>
                    <td colspan="2">
                        <table width="100%" border="1">
                            <caption><em>Resultado de la busqueda: <?php echo($_POST["insumo"]);?></em></caption>
                            <thead align="center" style="font-weight: bold;background-color: #D5D5D5;">
                                <tr>
                                    <td>Nro.</td>
                                    <td>Código</td>
                                    <td>Nombre</td>
                                    <td>Disponible(s) / Estante(s)</td>
                                    <td width="60px">Ver</td>
                                    <?php /*condicion rol admin*/
                                        if(desencriptacionBASE64($_SESSION["rol"])==1){?>
                                    <td width="70px">Editar</td>
                                    <td width="80px">Eliminar</td>
                                    <?php }/*fin condicion rol admin*/?>
                                </tr>
                            </thead>
                            <tbody align="center">
                                <?php
                                while($row=mysqli_fetch_assoc($query)){
                                    $query2=($mysql->query("SELECT * FROM existencias WHERE id_insumos='".$row["id"]."'"));
                                    $contador2=(0);
                                    while($disponible=(mysqli_fetch_assoc($query2))){
                                        $contador2+=1;
                                        $cantidad=($disponible['cantidad']);
                                        $estante=($disponible['estante']);
                                        if(isset($_SESSION['lista'])){
                                            $array_tmp=(array(array("$cantidad","$estante")));
                                            $_SESSION['lista']=(array_merge($_SESSION['lista'], $array_tmp));
                                        }else{
                                            $_SESSION['lista']=(array(array("$cantidad","$estante")));
                                        }
                                    }
                                    $contador+=1;
                                    ?>
                                    <tr>
                                        <td width="60px"><?php echo($contador);?></td>
                                        <td><?php echo($row["codigo"]);?></td>
                                        <td><?php echo($row["nombre"]);?></td>
                                        <td>
                                            <table border="1" width="100%">
                                                <thead align="center">
                                                    <tr style="font-weight: bold;background-color: #F6CEF5;">
                                                        <td>Disponible</td>
                                                        <td>Estante</td>
                                                    </tr>
                                                </thead>
                                                <tbody align="center">
                                                    <?php
                                                    $total=(0);
                                                    for($i=0;$i<$contador2;$i++){
                                                        $total+=($_SESSION['lista'][$i][0]);
                                                        if($_SESSION['lista'][$i][0]>0){
                                                            ?>
                                                            <tr>
                                                                <td><?php echo($_SESSION['lista'][$i][0]);?></td>
                                                                <td><?php if($total>0){echo($_SESSION['lista'][$i][1]);}else{echo("Agotado");}?></td>
                                                            </tr>
                                                            <?php 
                                                        }/*fin if*/
                                                    }/*fin for*/?>
                                                    <tr align="left" style="background-color: #F6CEF5;">
                                                        <td colspan="2"><em>Total disponible: <?php echo($total);?></em></td>    
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                        <td>
                                            <script type="text/javascript">
                                                function ver_<?php echo($contador);?>(){
                                                      
                                                    document.ver_f_<?php echo($contador);?>.submit();
                                                }
                                            </script>
                                            <form action="?ruta=ver-insumo" method="post" name="ver_f_<?php echo($contador);?>">
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
                                                    if (confirm('¿Esta seguro de editar este insumo?')){
                                                        document.editar_f_<?php echo($contador);?>.submit();
                                                    }
                                                }
                                            </script>
                                            <form action="?ruta=editar-insumo" method="post" name="editar_f_<?php echo($contador);?>">
                                                <input type="hidden" name="ref" value="<?php echo($row['id']);?>">
                                            </form>
                                            <a href="#!Secure" title="Editar" onclick="editar_<?php echo($contador);?>();">
                                                <img src="../images/editar.png" alt="Editar" width="50px">
                                            </a>
                                        </td>
                                        <td>
                                            <script type="text/javascript">
                                                function eliminar_<?php echo($contador);?>(){
                                                    if (confirm('¿Esta seguro de eliminar este insumo y sus existencias?')){
                                                        document.eliminar_f_<?php echo($contador);?>.submit();
                                                    }
                                                }
                                            </script>
                                            <form action="?ruta=eliminar-insumo" method="post" name="eliminar_f_<?php echo($contador);?>">
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
                                }//fin isset insumo
                                ?>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <?php }/*Fin isset insumo*/?>
    		</table>
        </div>
    </div>
</div>