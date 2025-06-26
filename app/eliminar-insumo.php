<?php
if(!isset($_POST["ref"])){
	include("home.php");
}else{
	$mysql->query("DELETE FROM insumos WHERE id='".$_POST["ref"]."'");
	$mysql->query("DELETE FROM existencias WHERE id_insumos='".$_POST["ref"]."'");
	?>
	<script type="text/javascript">
		window.location.href="index.php?ruta=c-insumo&alert=delete-insumo";
	</script>
	<?php
}
?>