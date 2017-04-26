<?php

	$conect = pg_connect("host=localhost user=postgres password=postgres dbname=chamados port=5432");

	$idchamado = $_POST["id"];
	$atendente = $_POST["selAtendente"];
	$solicitante = $_POST["selSolicitante"];	
	$setor = $_POST["selSetor"];
	$problema = $_POST["problema"];
	$resolucao = $_POST["resolucao"];
	$horai = $_POST["inicio"];
	$horat = $_POST["termino"];
	
	if ((!isset($_POST['id'])) || ($_POST['id'] == '')){				
		$sql = "INSERT INTO 
					chamado (idatendente, idsolicitante, idsetor, problema, resolucao, horai, horat)
				VALUES 
					($atendente, $solicitante, $setor, '$problema', '$resolucao', '$horai', '$horat')";
				
		if (pg_query($conect, $sql)) {
			$response = array("success" => true);
		}
	
		else{
			$response = array("success" => false);
		}
	}

	else{		
		$sql = "UPDATE 
					chamado 
				SET 
					idatendente =$atendente, idsolicitante=$solicitante, idsetor=$setor, problema='$problema',resolucao='$resolucao', horai='$horai', horat='$horat'
				WHERE 
					idchamado=$idchamado";
					
		if (pg_query($conect, $sql)) {
			$response = array("success" => true);
		}
	
		else{
			$response = array("success" => false);
		}
	}

	echo json_encode($response);
