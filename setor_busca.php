<?php

	$conect = pg_connect("host=localhost user=postgres password=postgres dbname=chamados port=5432");

	$id = $_POST['id'];

	if ((isset($_POST['id'])) && ($_POST['id'] != '')) {
		$sql = "SELECT
					nome
				FROM
					setor
				WHERE 
					idsetor = $id
				AND 
					data_exclusao IS NULL";
			
		$result = pg_query($conect, $sql);
		$dados = pg_fetch_array($result);

		$response['nome'] = $dados['nome'];

	}

	else{
		$response = array("success" => false);
	}

	echo json_encode($response);	

?>
