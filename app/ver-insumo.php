<?php
unset($_SESSION['lista']);
if(!isset($_POST["ref"])){
	?>
    <script type="text/javascript">
        window.location.href="../index.html";
    </script>
    <?php
}else{
	$query=($mysql->query("SELECT * FROM insumos WHERE id='".$_POST["ref"]."'"));
	$row=(mysqli_fetch_assoc($query));
    $query2=($mysql->query("SELECT * FROM existencias WHERE id_insumos='".$row["id"]."'"));
    $contador=(0);
    while($disponible=(mysqli_fetch_assoc($query2))){
        $contador+=1;
        $cantidad=($disponible['cantidad']);
        $estante=($disponible['estante']);
        if(isset($_SESSION['lista'])){
            $array_tmp=(array(array("$cantidad","$estante")));
            $_SESSION['lista']=(array_merge($_SESSION['lista'], $array_tmp));
        }else{
            $_SESSION['lista']=(array(array("$cantidad","$estante")));
        }
    }
    $query3=($mysql->query("SELECT * FROM embalaje WHERE id='".$row["tipo"]."'"));
    $embalaje=(mysqli_fetch_assoc($query3));
}
?>
<script type="text/javascript">
  function imprimir(insumo){
    var contenido= document.getElementById(insumo).innerHTML;
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
    			<input type="button" name="imprimir" value="Imprimir" onclick="imprimir('insumo');">
    		</center>
    		<br>
			<div id="insumo">
				<h4 align="center">Insumos registrado</h4>
				<br>
    			<table width="100%" border="1">
        			<thead style="font-weight: bold;background-color: #D5D5D5;">
        				<tr>
        					<th style="text-align: center;">Fecha de registro</th>
        					<th style="text-align: center;">Código</th>
        					<th style="text-align: center;">Nombre</th>
        				</tr>
        			</thead>
        			<tbody align="center">
        				<tr>
        					<td><?php echo(fechaHora($row["fecha"]));?></td>
        					<td><?php echo($row["codigo"]);?></td>
        					<td><?php echo($row["nombre"]);?></td>
        				</tr>
        			</tbody>
        			<thead style="font-weight: bold;background-color: #D5D5D5;">
        				<tr>
        					<th style="text-align: center;">Tipo</th>
        					<th style="text-align: center;">Disponible</th>
        					<th style="text-align: center;">Descripción</th>
        				</tr>
        			</thead>
        			<tbody align="center">
        				<tr>
        					<td><?php echo($embalaje["nombre"]);?></td>
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
                                        for($i=0;$i<$contador;$i++){
                                            $total+=($_SESSION['lista'][$i][0]);
                                            if($_SESSION['lista'][$i][0]>0){
                                                ?>
                                                <tr>
                                                    <td><?php echo($_SESSION['lista'][$i][0]);?></td>
                                                    <td><?php echo($_SESSION['lista'][$i][1]);?></td>
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
                            </td>
        					<td><?php echo($row["descripcion"]);?></td>
        				</tr>
        			</tbody> 
    			</table>
    		</div>
        </div>
    </div>
</div>