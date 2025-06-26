<?php
if(!isset($_POST["ref"])){
	include("home.php");
}else{
	$mysql->query("DELETE FROM presentacion WHERE id='".$_POST["ref"]."'");
	?>
	<script type="text/javascript">
		window.location.href="index.php?ruta=presentacion&alert=delete-presentacion";
	</script>
	<?php
}
?>