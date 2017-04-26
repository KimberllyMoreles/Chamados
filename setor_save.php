<?php

	$conect = pg_connect("host=localhost user=postgres password=postgres dbname=chamados port=5432");

	$id = $_POST['id'];
	$nome = $_POST['nome'];



	if ((!isset($_POST['id'])) || ($_POST['id'] == '')){
		$sql = "insert into setor (
					nome) 
				values (
					'$nome')";

		if (pg_query($conect, $sql)) {
			$response = array("success" => true);
		}
	
		else{
			$response = array("success" => false);
		}
	}

	else{

		$id = $_POST['id'];
		$sql = "update setor set 
					nome = '$nome'
				where 
					idsetor = $id";

		if (pg_query($conect, $sql)) {
			$response = array("success" => true);
		}
	
		else{
			$response = array("success" => false);
		}
	}

	echo json_encode($response);

?>
