<?php
	require("head.php");

	$idsolicitante = $_GET["idsolicitante"];
	$hoje = Date("d/m/y H:i:s");
	
	$sql = "UPDATE solicitante SET data_exclusao = '$hoje' WHERE idsolicitante = $idsolicitante";
	$resultado = pg_query($sql);

	if($resultado==true){
		header("Location: solicitante.php?retorno=1");
	}

	else{
		header("Location: solicitante.php?retorno=2");
	}

	
