<div class="limiter">
  <div class="container-login1000">
    <div class="wrap-login1000">
      <h2 align="center">
        Reportes
        <br><br>
		</h2>
		<form action="../generador/reportes.php" method="post" target="_blank">
	      	<table width="100%" border="0">
	      		<thead align="center">
		      		<tr>
		      			<td width="70%">
		      				<select name="tipo" required title="Seleccione un tipo de reporte.">
		      					<option value="0">Inventario</option>
		      					<option value="1">Insumos existentes</option>
		      					<option value="2">Insumos agotados</option>
		      					<option value="3">Entradas de insumos</option>
		      					<option value="4">Salidas de insumos</option>
		      					<option value="5">Usuarios del sistema</option>
		      					<option value="6">Lista de productos</option>
		      					<option value="7">Ventas generales</option>
		      				</select>
		      			</td>
		      			<td>
							<input type="submit" name="generar" value="Generar reporte">
		      			</tr>
		      		</tr>
	      		</thead>
	   		</table>
	   	</td>
    </div>
  </div>
</div>