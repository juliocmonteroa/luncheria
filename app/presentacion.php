<?php
if(isset($_POST["agregar"])){
    $queryx=($mysql->query("SELECT * FROM presentacion WHERE nombre='".$_POST["nombre"]."'"));
    $rowx=(mysqli_fetch_assoc($queryx));
    if($rowx["nombre"]==$_POST["nombre"]){
        ?>
        <script type="text/javascript">
            alert("Error! Tipo de presentacion ya registrado.");
        </script>
        <?php
    }else{
        $mysql->query("INSERT INTO presentacion(nombre) VALUES('".$_POST["nombre"]."')");
        ?>
        <script type="text/javascript">
            alert("Enhorabuena! Tipo de presentacion agregado con éxito.");
        </script>
        <?php
    }
}
if(isset($_POST["nombre_e"])){
    $mysql->query("UPDATE presentacion SET nombre='".$_POST["nombre_e"]."' WHERE id='".$_POST["ref"]."'");
    ?>
    <script type="text/javascript">
        alert("Enhorabuena! Tipo de presentacion actualizado con éxito.");
    </script>
    <?php
}
?>
<div class="limiter">
  <div class="container-login1000">
    <div class="wrap-login1000">
        <h4 align="center">Agregar tipo de presentacion</h4>
        <br>
        <form action="index.php?ruta=presentacion" method="post">
            <table width="100%" border="0">
                <thead align="center">
                    <tr>
                        <td width="70%">
                             <input type="text" name="nombre" title="Escriba un nombre" placeholder="Escriba un nombre" autocomplete="off" required>
                        </td>
                        <td>
                            <input type="submit" name="agregar" value="Agregar">
                        </td>
                    </tr>
                </thead>
            </table>
        </form>
        <br>
        <h4 align="center">Consultar tipo de presentacion</h4>
        <br>
        <table width="100%" border="1">
            <caption>Tipos de presentacion</caption>
            <thead align="center" style="font-weight: bold;background-color: #D5D5D5;">
                <tr>
                    <td width="60px">Nro.</td>
                    <td>Nombre</td>
                    <td width="70px">Editar</td>
                    <td width="80px">Eliminar</td>
                </tr>
            </thead>
            <?php
            $query=($mysql->query("SELECT * FROM presentacion"));
            $contador=(0);
            while($row=(mysqli_fetch_assoc($query))){ 
                $contador+=(1);
                ?>
                <input type="hidden" name="presentacion_<?php echo($contador);?>" value="<?php echo($row['nombre']);?>">
                <tbody align="center">
                    <tr>
                        <td><?php echo($contador);?></td>
                        <td>
                            <form action="?ruta=presentacion" method="post" name="editar_f_<?php echo($contador);?>">
                                <input type="hidden" name="ref" value="<?php echo($row['id']);?>">
                                <input type="text" name="nombre_e" id="nombre_e<?php echo($contador);?>" value="<?php echo($row["nombre"]);?>" name="Nombre del presentacion" title="Nombre del presentacion" autocomplete="off" required>
                            </form>
                        </td>
                        <td>
                            <script type="text/javascript">
                                function editar_<?php echo($contador);?>(){
                                    var presentacion=document.getElementsByName("presentacion_<?php echo($contador);?>")[0].value;
                                     var nuevo=document.getElementById("nombre_e<?php echo($contador);?>").value;
                                    if (confirm('¿Esta seguro de editar este presentacion?\n\nNombre anterior: '+presentacion+' | Nuevo nombre: '+nuevo)){
                                        document.editar_f_<?php echo($contador);?>.submit();
                                    }
                                }
                            </script>
                            <!--<form action="?ruta=editar-presentacion" method="post" name="editar_f_<?php echo($contador);?>">
                                <input type="hidden" name="ref" value="<?php echo($row['id']);?>">
                            </form>-->
                            <a href="#!Secure" title="Editar" onclick="editar_<?php echo($contador);?>();">
                                <img src="../images/editar.png" alt="Editar" width="50px">
                            </a>
                        </td>
                        <td>
                            <script type="text/javascript">
                                function eliminar_<?php echo($contador);?>(){
                                    var presentacion=document.getElementsByName("presentacion_<?php echo($contador);?>")[0].value;
                                    if (confirm('¿Esta seguro de eliminar este presentacion? -> '+presentacion+'')){
                                        document.eliminar_f_<?php echo($contador);?>.submit();
                                    }
                                }
                            </script>
                            <form action="?ruta=eliminar-presentacion" method="post" name="eliminar_f_<?php echo($contador);?>">
                                <input type="hidden" name="ref" value="<?php echo($row['id']);?>">
                            </form>
                            <a href="#!Secure" title="Eliminar" onclick="eliminar_<?php echo($contador);?>();">
                               <img src="../images/eliminar.svg" alt="Eliminar" width="50px">
                            </a>
                        </td>
                    </tr>
                </tbody>
            <?php }?>
        </table>
        </div>
    </div>
</div>