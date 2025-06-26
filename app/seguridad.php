<?php
if(isset($_POST['restore'])){
    if($_FILES["copiadeseguridad"]["type"]=="application/octet-stream"){
        //conexion con la base de datos
        $conn = mysqli_connect($GLOBALS["db"][0],$GLOBALS["db"][1],$GLOBALS["db"][2],$GLOBALS["db"][3]);
        // Vaerificacion de extencion archivo .SQL
        if(!in_array(strtolower(pathinfo($_FILES["copiadeseguridad"]["name"], PATHINFO_EXTENSION)), array(
            "sql"))){
                $response = array( "type" => "error", "message" => NULL);
        }else{
            if(is_uploaded_file($_FILES["copiadeseguridad"]["tmp_name"])){
                $nuevo_nombre_archivo=("Restore SQL ".date("d-m-Y")." RAND".rand(0,99999).".sql");
                move_uploaded_file($_FILES["copiadeseguridad"]["tmp_name"],"../generador/".$nuevo_nombre_archivo);
                $response = restaurar("../generador/".$nuevo_nombre_archivo, $conn);
            }
        }
        if (!empty($response)){
            //echo nl2br($response["message"]);
            ?>
            <script type="text/javascript">
                alert("¡Enhorabuena!: La base de datos se ha restaurado con éxito.");</script>
            <?php
        }
    }else{
        ?>
        <script type="text/javascript">
            alert("¡Error!: Formato invalido debe ser un archivo .SQL (application/octet-stream)");</script>
        <?php
    }
}
?>
<div class="limiter">
	<div class="container-login1000">
		<div class="wrap-login1000">
			<h2 align="center">Copia de seguridad<br><br></h2>
			<table width="100%" border="0">
            </thead>
            <tbody>
                <tr>
                    <td width="50%" align="center">
                        <form action="index.php?ruta=seguridad" method="post">
                            <h3>&bull; Respaldo &bull;</h3>
                            <br>
                            <input type="submit" name="backup" value="Generar respaldo">
                        </form>
                    </td>
                    <td width="50%" align="center">
                        <form action="index.php?ruta=seguridad" method="post" enctype="multipart/form-data">
                            <h3>&bull; Restaurar &bull;</h3>
                            <br>
                            <input type="file" name="copiadeseguridad" accept=".sql" required><br><br>
                            <input type="submit" name="restore" value="Generar recuperación">
                        </form>
                    </td>
                </tr>
                <?php
                if(isset($_POST['backup'])){
                ?>
                <tr>
                    <td align="center"><br>
                        <a href="../generador/<?php echo($GLOBALS["db"][3]);?>.sql" target="_blank">Descargar su copia de seguridad.</a>
                        <br><br>
                    </td>
                    <td></td>   
                </tr>
            <?php }/*Fin copia de seguridad*/?>
            </tbody>
        </table>
		</div>
	</div>
</div>
<?php
if(isset($_POST['backup'])){
    copiaSeguridad($GLOBALS["db"][0], $GLOBALS["db"][1], $GLOBALS["db"][2], $GLOBALS["db"][3]);
    exit();
}
?>