<?php
if(!isset($_POST["ref"])){
	include("home.php");
}else{
	$mysql->query("DELETE FROM usuarios WHERE id='".$_POST["ref"]."'");
	?>
	<script type="text/javascript">
		window.location.href="index.php?ruta=c-usuario&alert=delete-usuario";
	</script>
	<?php
}
?>