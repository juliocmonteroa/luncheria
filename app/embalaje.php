<?php
if(isset($_POST["agregar"])){
    $queryx=($mysql->query("SELECT * FROM embalaje WHERE nombre='".$_POST["nombre"]."'"));
    $rowx=(mysqli_fetch_assoc($queryx));
    if($rowx["nombre"]==$_POST["nombre"]){
        ?>
        <script type="text/javascript">
            alert("Error! Tipo de embajale ya registrado.");
        </script>
        <?php
    }else{
        $mysql->query("INSERT INTO embalaje(nombre) VALUES('".$_POST["nombre"]."')");
        ?>
        <script type="text/javascript">
            alert("Enhorabuena! Tipo de embajale agregado con éxito.");
        </script>
        <?php
    }
}
if(isset($_POST["nombre_e"])){
    $mysql->query("UPDATE embalaje SET nombre='".$_POST["nombre_e"]."' WHERE id='".$_POST["ref"]."'");
    ?>
    <script type="text/javascript">
        alert("Enhorabuena! Tipo de embajale actualizado con éxito.");
    </script>
    <?php
}
?>
<div class="limiter">
  <div class="container-login1000">
    <div class="wrap-login1000">
        <h4 align="center">Agregar tipo de embalaje</h4>
        <br>
        <form action="index.php?ruta=embalaje" method="post">
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
        <h4 align="center">Consultar tipo de embalaje</h4>
        <br>
        <table width="100%" border="1">
            <caption>Tipos de embalaje</caption>
            <thead align="center" style="font-weight: bold;background-color: #D5D5D5;">
                <tr>
                    <td width="60px">Nro.</td>
                    <td>Nombre</td>
                    <td width="70px">Editar</td>
                    <td width="80px">Eliminar</td>
                </tr>
            </thead>
            <?php
            $query=($mysql->query("SELECT * FROM embalaje"));
            $contador=(0);
            while($row=(mysqli_fetch_assoc($query))){ 
                $contador+=(1);
                ?>
                <input type="hidden" name="embalaje_<?php echo($contador);?>" value="<?php echo($row['nombre']);?>">
                <tbody align="center">
                    <tr>
                        <td><?php echo($contador);?></td>
                        <td>
                            <form action="?ruta=embalaje" method="post" name="editar_f_<?php echo($contador);?>">
                                <input type="hidden" name="ref" value="<?php echo($row['id']);?>">
                                <input type="text" name="nombre_e" id="nombre_e<?php echo($contador);?>" value="<?php echo($row["nombre"]);?>" name="Nombre del embalaje" title="Nombre del embalaje" autocomplete="off" required>
                            </form>
                        </td>
                        <td>
                            <script type="text/javascript">
                                function editar_<?php echo($contador);?>(){
                                    var embalaje=document.getElementsByName("embalaje_<?php echo($contador);?>")[0].value;
                                     var nuevo=document.getElementById("nombre_e<?php echo($contador);?>").value;
                                    if (confirm('¿Esta seguro de editar este embalaje?\n\nNombre anterior: '+embalaje+' | Nuevo nombre: '+nuevo)){
                                        document.editar_f_<?php echo($contador);?>.submit();
                                    }
                                }
                            </script>
                            <!--<form action="?ruta=editar-embalaje" method="post" name="editar_f_<?php echo($contador);?>">
                                <input type="hidden" name="ref" value="<?php echo($row['id']);?>">
                            </form>-->
                            <a href="#!Secure" title="Editar" onclick="editar_<?php echo($contador);?>();">
                                <img src="../images/editar.png" alt="Editar" width="50px">
                            </a>
                        </td>
                        <td>
                            <script type="text/javascript">
                                function eliminar_<?php echo($contador);?>(){
                                    var embalaje=document.getElementsByName("embalaje_<?php echo($contador);?>")[0].value;
                                    if (confirm('¿Esta seguro de eliminar este embalaje? -> '+embalaje+'')){
                                        document.eliminar_f_<?php echo($contador);?>.submit();
                                    }
                                }
                            </script>
                            <form action="?ruta=eliminar-embalaje" method="post" name="eliminar_f_<?php echo($contador);?>">
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