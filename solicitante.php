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

				var dados = $('#cadSolicitante').serialize();

				if ($("input[name=id]").val() != "") {
					var r=confirm("Alterar o registro selecionado?");

					if (r==false) {
						return false;
					}
				}

				$.ajax({

					type: 'POST',
					dataType: 'json',
					url: 'solicitante_save.php',
					async: true,
					data: dados,
					success: function(response) {
						$('#cadSolicitante input[id=id]').val('');
						$('#cadSolicitante input[id=nome]').val('');
						$("select#selSetor").val('');
						location.href = 'solicitante.php';
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
				var left = ($(window).width() / 4) - ($(id).width() / 4);
				var top = ($(window).height() / 4) - ($(id).height() / 4);
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
						url: 'solicitante_busca.php',
						async: true,
						data: { id: valor},
						success: function(response){
			                $("input[name=id]").val(valor);
			                $("input[name=nome]").val(response.nome);	    
            				$("select[name=selSetor]").val(response.idsetor);
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
				var left = ($(window).width() / 3.5) - ($(id).width() / 3.5);
				var top = ($(window).height() / 3.5) - ($(id).height() / 3.5);
				$(id).css({'top': top, 'left': left});
				$(id).show();
				$("input[id=nome]").focus();
			
			});

			$("#mascara").click(function() {
				$(this).hide();
				$(".window").hide();
				$('#cadSolicitante input[id=id]').val('');
				$('#cadSolicitante input[id=nome]').val('');			
			});

			$('.fechar').click(function(ev) {
				ev.preventDefault();
				$("#mascara").hide();
				$(".window").hide();
				$('#cadSolicitante input[id=id]').val('');
				$('#cadSolicitante input[id=nome]').val('');
			});

		});
	</script>

			<div id="content" class="container_16 clearfix">
				<div class="grid_4">
					<h2>Solicitantes</h2>					
				</div>
				
				<div class="window grid_7" id="editar">
					<a href="#" class="fechar">X Fechar</a>
					<h4>Solicitante</h4>

					<form action="" method="POST" id="cadSolicitante">
							<p>
								<label for="title">Solicitante</label>
								<input type="hidden" id="id" name="id"/>
								<input type="text" id="nome" maxlength=100 name="nome"/>
							</p>
							<p>
								<label>Setor</label>
								<select name="selSetor">
									<option value="">Escolha um setor:</option>
									<?php
										$sql = "SELECT * FROM setor WHERE data_exclusao IS NULL ORDER BY nome ASC";
										$res = pg_query($sql);							
					
										if(pg_num_rows($res) > 0){
											while($row = pg_fetch_array($res)){
												/*if($idsetor == $row['idsetor']){?>									
													<option value="<?php echo $row['idsetor'];?>" selected><?php echo $row["nome"];?></option>
										<?php
												}
												else{
										*/?>
													<option value="<?php echo $row['idsetor'];?>"><?php echo $row["nome"];?></option>
											<?php
												
											}
										}
										?>
								</select>
							</p>
					
											
							<p class="submit">
								<input type="reset" value="Limpar" />
								<input type="submit" value="Salvar" id="salvar"/>
							</p>
						
						
					</form>
				</div>

				<a href='#editar' rel='popup' class='add' id='salvar'><img src="images/1460591802_199_CircledPlus.png"></a>

				<div class="grid_16">
					<table id="example" class="display" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th>Solicitante</th>
								<th>Setor</th>
								<th>Ações</th>	
								<th></th>
							</tr>
						</thead>
				
						<tbody>
							<?php
							$sql = "SELECT
										s.idsolicitante,
										s.nome,
										st.nome AS setor 
									FROM 
										solicitante s
									LEFT JOIN
											setor st
										ON
											st.idsetor = s.idsetor
									WHERE 
										s.data_exclusao IS NULL ORDER BY nome ASC";
							

							$res = pg_query($sql);
					
			
							if(pg_num_rows($res) > 0){	 
							   
								while($row = pg_fetch_array($res)){
									$id = $row['idsolicitante'];
									$nome = $row['nome'];
									$setor = $row['setor'];
		
								  ?>
							<tr>
								<td><?php echo $nome;?></td>
								<td><?php echo $setor;?></td>
								<td><a href='#editar' rel='modal' class='salvar' id='salvar' name='salvar' title='Editar' valor='<?php echo $id?>'> Editar</a></td>
								<td><a href="solicitante_del.php?idsolicitante=<?php echo $id?>" onClick="return valida_exc()" class="delete">Excluir</a></td>
							</tr>
							 
							<?php       
								}
						 		}
							else{
							 echo "<tr><td colspan ='4'>Nenhum registro encontrado no banco de dados!</td></tr>";
							}
							?>

						</tbody>

						<tfoot>
							<tr>
								<th>Solicitante</th>
								<th>Setor</th>
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
