<?php
if(isset($_POST["valor"])){
    $mysql->query("UPDATE configuracion SET precio='".$_POST["valor"]."' WHERE id='1'");
    ?>
    <script type="text/javascript">
        alert("Enhorabuena! Valor del $(Dolar) en Bs.S(Bolívares Soberanos) actualizado con éxito.");
    </script>
    <?php
}
?>
<div class="limiter">
  <div class="container-login1000">
    <div class="wrap-login1000">
        <h4 align="center">Ajuste de precio(s)</h4>
        <br>
        <table width="100%" border="1">
            <caption>Tipos de embalaje</caption>
            <thead align="center" style="font-weight: bold;background-color: #D5D5D5;">
                <tr>
                    <td width="120px">Fecha</td>
                    <td>Valor del $(Dolar) en Bs.S(Bolívares Soberanos)</td>
                    <td width="90px">Actualizar</td>
                </tr>
            </thead>
            <?php
                $query=($mysql->query("SELECT * FROM configuracion WHERE id='1'"));
                $row=(mysqli_fetch_assoc($query));
            ?>
            <tbody align="center">
                <tr>
                    <td><?php echo(date("d-m-Y"))?></td>
                    <td>
                        <form action="?ruta=precio" method="post" name="actualizar_precio">
                            <input type="text" name="valor" id="valor" value="<?php echo($row["precio"]);?>"title="Valor del $(Dolar) en Bs.S(Bolívares Soberanos)" autocomplete="off" required>
                        </form>
                    </td>
                    <td>
                        <script type="text/javascript">
                            function actualizar_producto(){
                                if (confirm('¿Esta seguro de actualizar el valor del $(Dolar) en Bs.S(Bolívares Soberanos)?\nEsa acción actualizara todos los precios de los productos en venta.')){
                                    document.actualizar_precio.submit();
                                }
                            }
                        </script>
                        <a href="#!Secure" title="Editar" onclick="actualizar_producto();">
                            <img src="../images/editar.png" alt="Editar" width="50px">
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>
        </div>
    </div>
</div>