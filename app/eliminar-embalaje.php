<?php
if(!isset($_POST["ref"])){
	include("home.php");
}else{
	$mysql->query("DELETE FROM embalaje WHERE id='".$_POST["ref"]."'");
	?>
	<script type="text/javascript">
		window.location.href="index.php?ruta=embalaje&alert=delete-embalaje";
	</script>
	<?php
}
?>