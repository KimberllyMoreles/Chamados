<?php
	require("head.php");
	
	$id = $_GET["id"];
	$hoje = Date("d/m/y H:i:s");
	
	$sql = "UPDATE atendente SET data_exclusao = '$hoje' WHERE idatendente = $id";
	$resultado = pg_query($sql);

	if($resultado==true){
		header("Location: atendente.php?retorno=1");
	}

	else{
		header("Location: atendente.php?retorno=2");
	}

	
