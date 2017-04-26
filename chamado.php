<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<?php
		require("head.php");
		require("cabecalho.php");
		
		if (isset($_GET['retorno'])){
			switch ($_GET['retorno']) {
				case 1:
					echo '<script language="Javascript">
					    alert("Registro excluído com sucesso!");
					  </script>';
					break;
				case 2:
					echo '<script language="Javascript">
					    alert("Registro nao pode ser excluído!");
					  </script>';
					break;
				case 3:
					echo '<script language="Javascript">
					    alert("Registro alterado com sucesso!");
					  </script>';
					break;
				case 4:
					echo '<script language="Javascript">
					    alert("Não foi possível alterar! Verifique os dados e tente novamente.");
					    history.back();
					  </script>';
					break;
				case 5:
					echo '<script language="Javascript">
					    alert("Registro salvo com sucesso!");
					  </script>';
					break;
				case 6:
					echo '<script language="Javascript">
					    alert("Não foi possível salvar! Verifique os dados e tente novamente.");
					    history.back();
					  </script>';
					break;
			}
		}

		$dataUm = "";
		$dataDois = "";
		
		$sqlLista = "SELECT
					 c.idchamado,
					 a.nome as atendente, 
					 s.nome as solicitante, 
					 st.nome as setor,
					 c.problema,
					 c.resolucao,
					 c.horai,
					 c.horat
				FROM 
					chamado c 
					left join atendente a on a.idatendente = c.idatendente 
					left join solicitante s on s.idsolicitante = c.idsolicitante 
					left join setor st on st.idsetor = c.idsetor
				WHERE c.data_exclusao IS NULL";
		
		if (isset($_GET['listar'])) {
			$dataUm = $_POST["dataUm"];
			$dataDois = $_POST["dataDois"];
			
			if ($dataUm != "" && $dataDois != ""){
				$sqlLista .= " AND horai BETWEEN '$dataUm' AND '$dataDois'";
			}
			
			if (($dataUm == "" && $dataDois != "")||($dataUm != "" && $dataDois == "")){
				echo "<script>alert('Para filtrar preecha os dois campos');</script>";
			}
		}
				
		
	?>
	
			<script type="text/javascript" language="javascript">
    function valida_exc() {
        var retorno = confirm('Confirma exclusao do registro?');

        return (retorno);
    }


	$(document).ready(function() {

		$('#example').DataTable({
			"order": [1, "desc"],
			"language": {
				"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Portuguese-Brasil.json"
			}
		});

		
		$('#salvar').click(function() {
			var dados = $('#cadChamado').serialize();

			if ($("input[name=id]").val() != "") {
				var r=confirm("Alterar o registro selecionado?");

				if (r==false) {
					return false;
				}
			}

			$.ajax({
				type: 'POST',
				dataType: 'json',
				url: 'chamado_save.php',
				async: true,
				data: dados,
				success: function(response) {
					$('#cadChamado input[id=id]').val('');
					$("select#selAtendente").val('');
					$("select#selSolicitante").val('');
					$("select#selSetor").val('');
					$('#cadChamado input[id=resolucao]').val('');
					$('#cadChamado input[id=problema]').val('');
					$('#cadChamado input[id=horai]').val('');
					$('#cadChamado input[id=horat]').val('');
					location.href = 'chamado.php';
				}
			});

			return false;
		}); 

		$("a[rel=popup]").click(function(ev) {
		
			ev.preventDefault();
			var id = $(this).attr("href");
			var alturaTela = $(document).height();
			var larguraTela = $(window).width();
			$('#mascara').css({'width': larguraTela, 'height': alturaTela});
			$('#mascara').fadeIn(500);
			$('#mascara').fadeTo("slow", 0.8);
			var left = ($(window).width() / 3) - ($(id).width() / 2);
			var top = ($(window).height() / 3) - ($(id).height() / 2);
			$(id).css({'top': top, 'left': left});
			$(id).show();
			$("input[id=nome]").focus();
	
		});
		
		$("#example").on('click','a[rel=modal]',function(ev) {
			valor = $(this).attr("valor");
		
			if (valor != null) {
				$.ajax({
					type: 'POST',
					dataType: 'json',
					url: 'chamado_busca.php',
					async: true,
					data: { id: valor},
					success: function(response){
	                    $('#cadChamado input[id=id]').val(valor);
						$("#cadChamado select[name=selAtendente]").val(response.idatendente);
						$("#cadChamado select[name=selSolicitante]").val(response.idsolicitante);
						$("#cadChamado select[name=selSetor]").val(response.idsetor);
						$('#cadChamado textarea[id=resolucao]').val(response.resolucao);
						$('#cadChamado textarea[id=problema]').val(response.problema);
						$('#cadChamado input[id=inicio]').val(response.horai);
						$('#cadChamado input[id=termino]').val(response.horat);	                    
					}
				});
				
			}
			ev.preventDefault();
			var id = $(this).attr("href");
			var alturaTela = $(document).height();
			var larguraTela = $(window).width();
			$('#mascara').css({'width': larguraTela, 'height': alturaTela});
			$('#mascara').fadeIn(500);
			$('#mascara').fadeTo("slow", 0.8);
			var left = ($(window).width() / 3) - ($(id).width() / 2);
			var top = ($(window).height() / 3) - ($(id).height() / 2);
			$(id).css({'top': top, 'left': left});
			$(id).show();
			$("input[name=selSolicitante]").focus();
			
		});

		$("#mascara").click(function() {
			$(this).hide();
			$(".window").hide();
			$('#cadChamado input[id=id]').val('');
			$("select#selAtendente").val('');
			$("select#selSolicitante").val('');
			$("select#selSetor").val('');
			$('#cadChamado input[id=resolucao]').val('');
			$('#cadChamado input[id=problema]').val('');
			$('#cadChamado input[id=horai]').val('');
			$('#cadChamado input[id=horat]').val('');			
		});

		$('.fechar').click(function(ev) {
			ev.preventDefault();
			$("#mascara").hide();
			$(".window").hide();
			$('#cadChamado input[id=id]').val('');
			$("select#selAtendente").val('');
			$("select#selSolicitante").val('');
			$("select#selSetor").val('');
			$('#cadChamado input[id=resolucao]').val('');
			$('#cadChamado input[id=problema]').val('');
			$('#cadChamado input[id=horai]').val('');
			$('#cadChamado input[id=horat]').val('');
		});

	});
</script>
			<div id="content" class="container_16 clearfix">
				<div class="grid_4">
					<h2>Chamados</h2>
					
				</div>
				
				<div class="window" id="editar">
					<a href="#" class="fechar">X Fechar</a>
					<form action="" method="POST" id="cadChamado">
						<div class="grid_16">
							<h2>Adicionar novo chamado</h2>
							<input type="hidden" id="id" name="id"/>
						</div>

						<div class="grid_5">
							<p>
								<label for="title">Atendente</label>					
								<?php
									echo "						
										<select name='selAtendente'>
											<option value='' >Escolha um atendente:</option>";
			
											$sql = "SELECT * FROM atendente WHERE data_exclusao IS NULL ORDER BY nome ASC";
											$res = pg_query($sql);							

											if(pg_num_rows($res) > 0){
												while($row = pg_fetch_array($res)){
				
													$idAtendente = $row['idatendente'];
													$nomeAtendente = $row['nome'];
					
													echo "<option value='$idAtendente'>$nomeAtendente</option>";
												}
											}
			
									echo "</select>";					
								;?>					
							</p>
						</div>
					
					<div class="grid_5">
						<p>
							<label for="title">Solicitante</label>					
							<?php
								echo "						
									<select name='selSolicitante'>
										<option value=''>Escolha um solicitante:</option>";
			
										$sql = "SELECT * FROM solicitante WHERE data_exclusao IS NULL ORDER BY nome ASC";
										$res = pg_query($sql);							

										if(pg_num_rows($res) > 0){
											while($row = pg_fetch_array($res)){
				
												$idSolicitante = $row['idsolicitante'];
												$nomeSolicitante = $row['nome'];
					
												echo "<option value='$idSolicitante'>$nomeSolicitante</option>";
											}
										}
			
								echo "</select>";					
							;?>					
						</p>
					</div>
					
					<div class="grid_5">
						<p>
							<label for="title">Setor</label>					
							<?php
								echo "						
									<select name='selSetor'>
										<option value=''>Escolha um setor:</option>";
			
										$sql = "SELECT * FROM setor WHERE data_exclusao IS NULL ORDER BY nome ASC";
										$res = pg_query($sql);							

										if(pg_num_rows($res) > 0){
											while($row = pg_fetch_array($res)){
				
												$idSetor = $row['idsetor'];
												$nomeSetor = $row['nome'];
					
												echo "<option value='$idSetor'>$nomeSetor</option>";
											}
										}
		
								echo "</select>";					
							;?>					
						</p>
					</div>			
					
					<div class="grid_15">
						<p>
							<label>Problema</label>
							<textarea rows=4 cols=80 name='problema' id='problema'></textarea>
						</p>
					</div>
						
					<div class="grid_15">
						<p>
							<label>Resolução</label>
							<?php echo "<textarea rows=4 cols=80 name='resolucao' id='resolucao'></textarea>";?>
						</p>
					</div>
				
					<div class="grid_7">	
						<p class="grid_16">
							<tr>
								<td>
									<label>In&iacute;cio</label>
									<input type='text' id='inicio' name='inicio' size='20'>
									<input type="reset" id="bt_inicio" value=" ... ">

									<script type="text/javascript">
										Calendar.setup({
											inputField	 :	"inicio",
											ifFormat	   :	"%d/%m/%Y %H:%M:%S",
											showsTime	  :	true,
											button		 :	"bt_inicio",
											singleClick	:	true,
											step		   :	1,
											disableFunc: function(date) {
												var now= new Date();
												return (date.getTime() > now.getTime());
											}
										});
									</script>			
								</td>
							</tr>
						</p>
					</div>
					<div class="grid_7 listar">
						<p class="grid_16">
							<tr>
								<td>
									<label>T&eacute;rmino</br></label>
									<input type='text' id='termino' name='termino' size='20'>
									<input type="reset" id="bt_termino" value=" ... ">

									<script type="text/javascript">
										Calendar.setup({
											inputField	 :	"termino",
											ifFormat	   :	"%d/%m/%Y %H:%M:%S",
											showsTime	  :	true,
											button		 :	"bt_termino",
											singleClick	:	true,
											step		   :	1,
											disableFunc: function(date) {
												var now= new Date();
												return (date.getTime() > now.getTime());
											}
										});
									</script>			
								</td>
							</tr>	
						</p>	


					</div>

					<div class="grid_15">
						<p>
							<input type="reset" value="Reset" />
							<input type="submit" value="Salvar" id="salvar" />
						</p>
					</div>

					</form>
				</div>
				
				<a href='#editar' rel='popup' class='add' id='salvar'><img src="images/1460591802_199_CircledPlus.png"></a>

					<div class="grid_16">
						<form action="chamado.php?listar=true" method="post" name="formulario" >
							<div class="grid_4">
								<p class="grid_16">	
									<tr>
										<td>
											<label>Data 1:</label>
											<?php echo "<input type='text' id='dataUm' name='dataUm' size='20' value='$dataUm'>";?>
											<input type="reset" id="bt_dataUm" value=" ... ">

											<script type="text/javascript">
												Calendar.setup({
													inputField	 :	"dataUm",
													ifFormat	   :	"%d/%m/%Y %H:%M:%S",
													showsTime	  :	true,
													button		 :	"bt_dataUm",
													singleClick	:	true,
													step		   :	1,
													disableFunc: function(date) {
														var now= new Date();
														return (date.getTime() > now.getTime());
													}
												});
											</script>			
										</td>
									</tr>
								</p>
							</div>
		
							<div class="grid_4 listar">
								<p class="grid_16">	
									<tr>
										<td>
											<label>Data 2:</label>
											<?php echo "<input type='text' id='dataDois' name='dataDois' size='20'>";?>
											<input type="reset" id="bt_dataDois" value=" ... ">

											<script type="text/javascript">
												Calendar.setup({
													inputField	 :	"dataDois",
													ifFormat	   :	"%d/%m/%Y %H:%M:%S",
													showsTime	  :	true,
													button		 :	"bt_dataDois",
													singleClick	:	true,
													step		   :	1,
													disableFunc: function(date) {
														var now= new Date();
														return (date.getTime() > now.getTime());
													}
												});
											</script>
											<input type="reset" value="Limpar" class="listar"/>	
											<input type="submit" value="Listar"/>		
										</td>
									</tr>
								</p>
							</div>
						</form>
					</div>	
				
				<div class="grid_16"></br>
					<table id="example" class="display" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th>Atendente</th>
								<th>Solicitante</th>
								<th>Setor</th>								
								<th>Problema</th>
								<th>Resolução</th>
								<th>Horário Início</th>
								<th>Horário Término</th>
								<th>Ações</th>
								<th></th>
							</tr>
						</thead>
				
						<tbody>
							<?php
							
							

							$res = pg_query($sqlLista);
					
			
							if(pg_num_rows($res) > 0){	 
							   
								while($row = pg_fetch_array($res)){
									$id = $row["idchamado"];
									$nomeAtendente = $row["atendente"];
									$nomeSolicitante = $row["solicitante"]; 
									$nomeSetor = $row["setor"];
									$problema = $row["problema"];
									$resolucao = $row["resolucao"];
									$horai = date("d/m/Y H:i:s", strtotime($row['horai']));
									$horat = "";
									
									if ($row['horat'] != ""){
										$horat = date("d/m/Y H:i:s", strtotime($row['horat'])); 
									}  
									
									echo 
									"<tr>
										<td>$nomeAtendente</td>
										<td>$nomeSolicitante</td>
										<td>$nomeSetor</td>
										<td>$problema</td>
										<td>$resolucao</td>
										<td>$horai</td>
										<td>$horat</td>
										<td><a href='#editar' rel='modal' class='salvar' id='salvar' name='salvar' title='Editar' valor='$id'> Editar</a></td>
										<td><a href='chamado_del.php?idchamado=$id' onClick='return valida_exc()' class='delete'>Excluir</a></td>
									</tr>";
							 
							      
								}
						 	}
							else{
							 echo "<tr><td colspan ='10'>Nenhum registro encontrado no banco de dados!</td></tr>";
							}
							?>

						</tbody>

						<tfoot>
							<tr>
								<th>Atendente</th>
								<th>Solicitante</th>
								<th>Setor</th>								
								<th>Problema</th>
								<th>Resolução</th>
								<th>Horário Início</th>
								<th>Horário Término</th>
								<th>Ações</th>
								<th></th>
							</tr>
						</tfoot>
					</table>
				</div>
			</div>
		
			<div id="foot">
				<a href="#">Contact Me</a>				
			</div>	
			<div id="mascara"></div>
		
	</body>
</html>
