<header>
    <nav class="menu">
        <ul>
            <li onclick="url('inicio');">Inicio</li>
            <li>Ventas

            	<ul>
            		<li onclick="url('g-venta');">Generar venta(s)</li>
            		<!--<li onclick="url('g-devolucion');">Generar devolución(s)</li>-->
            		<li onclick="url('v-dia');">Venta(s) del día</li>
                    <li onclick="url('facturas-a');">Facturas (Activas)</li>
                    <li onclick="url('facturas');">Facturas (Facturadas)</li>
            		<li onclick="url('l-precio');">Lista de precio(s)</li>
                    <li onclick="url('c-producto');">Consultar producto(s)</li>
            		<?php if(desencriptacionBASE64($_SESSION["rol"])==1){?>
                    <li onclick="url('a-producto');">Agregar producto(s)</li>
                    <li onclick="url('presentacion');">Presentacion(s)</li>
            		<?php }?>
            	</ul>

            </li>
            <li>Inventario
            
                <ul>
                    <li onclick="url('c-insumo');">Consultar insumo(s)</li>
                    <?php if(desencriptacionBASE64($_SESSION["rol"])==1){?>
                    <li onclick="url('embalaje');">Embalaje(s)</li>
                    <li onclick="url('a-insumo');">Agregar insumo(s)</li>
                    <li onclick="url('p-entrada');">Procesar entrada de insumo(s)</li>
                    <li onclick="url('p-salida');">Procesar salida de insumo(s)</li>
                    <?php }?>
                </ul>
        
            </li>
            <?php if(desencriptacionBASE64($_SESSION["rol"])==1){?>
            <li>Avanzado
            
                <ul>
                	<li onclick="url('precio');">Ajuste de precio(s)</li>
                    <li onclick="url('c-usuario');">Consultar usuario(s)</li>
                    <li onclick="url('a-usuario');">Agregar usuario(s)</li>
                    <li onclick="url('reporte');">Generar reporte(s)</li>
                    <li onclick="url('seguridad');">Copia de seguridad</li>
                </ul>
            
            </li>
            <?php }?>
            <li onclick="url('salir');">Cerrar Sesión</li>
        </ul>
    </nav>
</header>