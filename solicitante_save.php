<?php

	$conect = pg_connect("host=localhost user=postgres password=postgres dbname=chamados port=5432");

	$id = $_POST['id'];
	$nome = $_POST['nome'];
	$setor = $_POST['selSetor'];



	if ((!isset($_POST['id'])) || ($_POST['id'] == '')){
		$sql = "insert into solicitante (
					nome, idsetor) 
				values (
					'$nome', $setor)";

		if (pg_query($conect, $sql)) {
			$response = array("success" => true);
		}
	
		else{
			$response = array("success" => false);
		}
	}

	else{
		$sql = "update solicitante set 
					nome = '$nome',
					idsetor = $setor
				where 
					idsolicitante = $id";

		if (pg_query($conect, $sql)) {
			$response = array("success" => true);
		}
	
		else{
			$response = array("success" => false);
		}
	}

	echo json_encode($response);

?>
