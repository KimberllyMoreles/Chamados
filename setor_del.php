<?php
	require("head.php");

	$idsetor = $_GET["id"];
	$hoje = Date("d/m/y H:i:s");
	
	$sql = "UPDATE setor SET data_exclusao = '$hoje' WHERE idsetor = $idsetor";
	$resultado = pg_query($sql);

	if($resultado==true){
		header("Location: setor.php?retorno=1");
	}

	else{
		header("Location: setor.php?retorno=2");
	}

	
