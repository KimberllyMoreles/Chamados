<?php
	require("head.php");

	$idchamado = $_GET["idchamado"];
	$hoje = Date("d/m/y H:i:s");
	
	$sql = "UPDATE chamado SET data_exclusao = '$hoje' WHERE idchamado = $idchamado";
	$resultado = pg_query($sql);

	if($resultado==true){
		header("Location: chamado.php?retorno=1");
	}

	else{
		header("Location: chamado.php?retorno=2");
	}

	
