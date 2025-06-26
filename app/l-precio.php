<?php
?>
<script type="text/javascript">
  function imprimir(lista){
    var contenido= document.getElementById(lista).innerHTML;
     var contenidoOriginal= document.body.innerHTML;

     document.body.innerHTML = contenido;

     window.print();

     document.body.innerHTML = contenidoOriginal;
  }
</script>
<div class="limiter">
    <div class="container-login1000">
        <div class="wrap-login1000">
            <br>
            <center>
                <input type="button" name="imprimir" value="Imprimir" onclick="imprimir('lista');">
                <p><em>Lista de productos que tengan existencia(s).</em></p>
            </center>
            <br>
            <div id="lista">
                <h3 align="center"><?php echo($GLOBALS['title'].date(" - Y"));?></h3>
                <br>
                <h4 align="center">Lista de precios</h4>
                <br>
                <table border="1" width="100%">
                    <caption>Fin de la lista</caption>
                    <thead>
                        <tr align="center" style="font-weight: bold;">
                            <td>Nro.</td>
                            <td>Código</td>
                            <td>Nombre</td>
                            <td>Precio</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query=($mysql->query("SELECT * FROM productos WHERE limite='1' OR cantidad>0"));
                        $query2=($mysql->query("SELECT * FROM configuracion WHERE id='1'"));
                        $dolar=(mysqli_fetch_assoc($query2));
                        $contador=(0);
                        while($row=(mysqli_fetch_assoc($query))){
                        $contador+=(1);
                        $precio=(number_format(($row["precio"]*$dolar["precio"]),2,",","."));
                        ?>
                        <tr align="center">
                            <td><?php echo($contador);?></td>
                            <td><?php echo($row["codigo"]);?></td>
                            <td><?php echo($row["nombre"]);?></td>
                            <td align="right"><?php echo($precio);?></td>
                        </tr>
                        <?php }?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>