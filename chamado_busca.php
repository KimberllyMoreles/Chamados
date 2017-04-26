<?php

	$conect = pg_connect("host=localhost user=postgres password=postgres dbname=chamados port=5432");

	$id = $_POST['id'];

	if ((isset($_POST['id'])) && ($_POST['id'] != '')) {
		$sql = "SELECT
					 c.idchamado,
					 a.nome as atendente,
					 c.idatendente, 
					 s.nome as solicitante, 
					 c.idsolicitante,
					 st.nome as setor,
					 c.idsetor,
					 c.problema,
					 c.resolucao,
					 c.horai,
					 c.horat
				FROM 
					chamado c 
					left join atendente a on a.idatendente = c.idatendente 
					left join solicitante s on s.idsolicitante = c.idsolicitante 
					left join setor st on st.idsetor = c.idsetor
				WHERE 
					c.idchamado = $id
				AND
					c.data_exclusao IS NULL";
			
		$result = pg_query($conect, $sql);
		$dados = pg_fetch_array($result);

		$response['idchamado'] = $dados['idchamado'];
		$response['idatendente'] = $dados['idatendente'];
		$response['idsolicitante'] = $dados['idsolicitante'];
		$response['idsetor'] = $dados['idsetor'];
		$response['atendente'] = $dados['atendente'];
		$response['solicitante'] = $dados['solicitante'];
		$response['setor'] = $dados['setor'];
		$response['problema'] = $dados['problema'];
		$response['resolucao'] = $dados['resolucao'];
		$response['horai'] = $dados['horai'];
		$response['horat'] = $dados['horat'];

	}

	else{
		$response = array("success" => false);
	}

	echo json_encode($response);	

?>
