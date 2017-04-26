<?php

session_start();                                                                                                                                             
if (!isset ($_SESSION["login"]))
    header("Location: index.php?erro=1");

require_once ('recepcao_cabecalho.php');

?>

<script type="text/javascript" language="javascript">
    function valida_exc() {
        var retorno = confirm('Confirma exclusao do registro?');

        return (retorno);
    }

	jQuery.fn.dataTableExt.oSort['custom_euro_date-asc'] = function(x, y) {
		var xVal = getCustomEuroDateValue(x);
		var yVal = getCustomEuroDateValue(y);
	 
		if (xVal < yVal) {
		    return -1;
		} else if (xVal > yVal) {
		    return 1;
		} else {
		    return 0;
		}
	}
	 
	jQuery.fn.dataTableExt.oSort['custom_euro_date-desc'] = function(x, y) {
		var xVal = getCustomEuroDateValue(x);
		var yVal = getCustomEuroDateValue(y);
	 
		if (xVal < yVal) {
		    return 1;
		} else if (xVal > yVal) {
		    return -1;
		} else {
		    return 0;
		}
	}
	 
	function getCustomEuroDateValue(strDate) {
		var frDatea = $.trim(strDate).split(' ');
		var frTimea = frDatea[1].split(':');
		var frDatea2 = frDatea[0].split('/');
		 
		var x = (frDatea2[2] + frDatea2[1] + frDatea2[0] + frTimea[0] + frTimea[1] + frTimea[2]);
		x = x * 1;
	 
		return x;
	}

	$(document).ready(function() {

		$('#chaves').DataTable({
			"order": [1, "desc"],
			"aoColumns": [
				{},
				{ "sType": "custom_euro_date" },
				{},
				{},
				{},
				null
			]
		});

		$("input[name=data_hora_retirada]").datetimepicker({
			format:'d/m/Y H:i:s',
			lang:'pt-BR',
			step:5,
			validateOnBlur:true
		});

		$("input[name=data_hora_devolucao]").datetimepicker({
			format:'d/m/Y H:i:s',
			lang:'pt-BR',
			step:5,
			validateOnBlur:true
		});

		$('#salvar').click(function() {
			var dados = $('#cadChave').serialize();
		
			if ($("input[name=id]").val() != "") {
				var r=confirm("Alterar o registro selecionado?");

				if (r==false) {
					return false;
				}
			}

			$.ajax({
				type: 'POST',
				dataType: 'json',
				url: 'recepcao_chave_salvar.php',
				async: true,
				data: dados,
				success: function(response) {
					location.reload();
				}
			});
			return false;
		}); 

		$("a[rel=popup]").click(function(ev) {
			$("input[name=data_hora_devolucao]").prop('disabled', true);
			$("input[name=responsavel_devolucao]").prop('disabled', true);
			ev.preventDefault();
			var id = $(this).attr("href");
			var alturaTela = $(document).height();
			var larguraTela = $(window).width();
			$('#mascara').css({'width': larguraTela, 'height': alturaTela});
			$('#mascara').fadeIn(500);
			$('#mascara').fadeTo("slow", 0.8);
			var left = ($(window).width() / 2) - ($(id).width() / 2);
			var top = ($(window).height() / 2) - ($(id).height() / 2);
			$(id).css({'top': top, 'left': left});
			$(id).show();
			$("input[name=sala]").focus();
			$("input[name=data_hora_retirada]").val("<?php echo date("d/m/Y H:i:s"); ?>");
		
		});
		
		$("#chaves").on('click','a[rel=modal]',function(ev) {
			valor = $(this).attr("valor");
		
			$("input[name=data_hora_devolucao]").prop('disabled', true);
			$("input[name=responsavel_devolucao]").prop('disabled', true);
			
			if (valor != null) {
				$.ajax({
					type: 'POST',
					dataType: 'json',
					url: 'recepcao_chave_buscar.php',
					async: true,
					data: { id: valor},
					success: function(response) {
	                    $("input[name=id]").val(valor);
	                    $("input[name=sala]").val(response.sala);
	                    $("input[name=data_hora_retirada]").val(response.data_hora_retirada);
	                    $("input[name=responsavel_retirada]").val(response.responsavel_retirada);
	                    $("input[name=data_hora_devolucao]").val(response.data_hora_devolucao);
	                    $("input[name=responsavel_devolucao]").val(response.responsavel_devolucao);
						$("input[name=sala]").prop('disabled', true);
						$("input[name=data_hora_retirada]").prop('disabled', true);
						$("input[name=responsavel_retirada]").prop('disabled', true);
						$("input[name=data_hora_devolucao]").prop('disabled', false);
						$("input[name=responsavel_devolucao]").prop('disabled', false);
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
			var left = ($(window).width() / 2) - ($(id).width() / 2);
			var top = ($(window).height() / 2) - ($(id).height() / 2);
			$(id).css({'top': top, 'left': left});
			$(id).show();
			$("input[name=sala]").focus();
			if ($("input[name=data_hora_retirada]").val() == "") {
				$("input[name=data_hora_retirada]").val("<?php echo date("d/m/Y H:i:s"); ?>");
			}
		});

		$("#mascara").click(function() {
			$(this).hide();
			$(".window").hide();
		});

		$('.fechar').click(function(ev) {
			ev.preventDefault();
			$("#mascara").hide();
			$(".window").hide();
			$('#cadTelefone input[type=text]').each(function(){
				$(this).val('');
			});
		});
	});
</script>

<table border="0" width="100%" cellpading="0" cellspacing="0">
    <tr>
		<td colspan="3" class='td-titulo'>Chaves</td>
	</tr>
</table>

<div class="window" id="editar">
	<a href="#" class="fechar">X Fechar</a>
	<h4>Telefone</h4>
	<form id="cadChave" action="" method="POST">
		<input type="hidden" name="id" id="id" />
		<label>Data / Hora - Retirada:</label><input type="text" size="18" name="data_hora_retirada" id="data_hora_retirada" />
		<label>Sala:</label><input type="text" size="40" maxlength="100" name="sala" id="sala" />
		<label>Responsável - Retirada:</label> <input type="text" size="40"name="responsavel_retirada" id="responsavel_retirada" />
		<label>Data / Hora - Devolu&ccedil;&atilde;o:</label><input type="text" size="18" name="data_hora_devolucao" id="data_hora_devolucao" />
		<label>Responsável - Devolu&ccedil;&atilde;o:</label> <input type="text" size="40"name="responsavel_devolucao" id="responsavel_devolucao" />
		<br/><br/>
		<input type="button" value="Salvar" id="salvar" />
	</form>
</div>

<?php if ($_acesso == 's') echo "<a href='#editar' rel='popup'><h3>Incluir Registro</h3></a>"; ?>


<table id="chaves" class="display" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>Sala</th>
            <th>Data / Hora - Retirada</th>
            <th>Responsável - Retirada</th>
            <th>Data / Hora - Devolu&ccedil;&atilde;o</th>
            <th>Responsável - Devolu&ccedil;&atilde;o</th>
            <th></th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <th>Sala</th>
            <th>Data / Hora - Retirada</th>
            <th>Responsável - Retirada</th>
            <th>Data / Hora - Devolu&ccedil;&atilde;o</th>
            <th>Responsável - Devolu&ccedil;&atilde;o</th>
            <th></th>
        </tr>
    </tfoot>
    <tbody>
		<?php
		    require_once ('recepcao_conecta.php');
		
		    $sql = "select 
		    		idchave,
		    		sala,
		    		data_hora_retirada,
		    		responsavel_retirada,
		    		data_hora_devolucao,
		    		responsavel_devolucao
		    	from 
		    		chave
		    	where 
		    		data_exclusao is null 
		    	order by 
		    		data_hora_devolucao,
		    		data_hora_retirada";
		    
		    $result = pg_query($conect, $sql)
		    or die("Nao foi possivel conectar no banco de dados!");
		
	        $dia = date("d");
	        $mes = date("m");
		    $ano = date("Y");
			$hoje = (mktime(0, 0, 0, $mes, $dia, $ano, 0));

		    while ( $linha = pg_fetch_array ( $result ) ) {
		        $idchave = $linha['idchave'];
		        $sala = $linha['sala'];
		        $data_hora_retirada = $linha['data_hora_retirada'];
		        $responsavel_retirada = $linha['responsavel_retirada'];
		        $data_hora_devolucao = $linha['data_hora_devolucao'];
		        $responsavel_devolucao = $linha['responsavel_devolucao'];

				$datetmp = explode(" ", $data_hora_retirada);
				$datetmp = explode("/", $datetmp[0]);
				
		        $dia_retir = $datetmp[0];
		        $mes_retir = $datetmp[1];
			    $ano_retir = $datetmp[2];
				$data_retir = mktime(0, 0, 0, $mes_retir, $dia_retir, $ano_retir, 0);
			
				if ((($hoje - $data_retir) / 60 / 60 / 24) > 0 && $data_hora_devolucao == '')
					$alerta = "style='color: #ff0000; font-weight:bold;'";
				else
					$alerta = "";
		
		        echo "<tr $alerta>
		                <td align='center'>
		                    $sala
		                </td>
		                <td align='center'>
		                    $data_hora_retirada
		                </td>
		                <td align='center'>
		                    $responsavel_retirada
		                </td>
		                <td align='center'>
		                    $data_hora_devolucao
		                </td>
		                <td align='center'>
		                    $responsavel_devolucao
		                </td>
		                <td align='center' width='40'>";
		                
		       	if ($_acesso == 's') 
		       		echo "<a href='#editar' rel='modal' title='Editar' valor='$idchave'><img src='imagens/editar.png' width='18' height='18' border='0'></a>
		                <a href='recepcao_chave_excluir.php?id=$idchave' title='Excluir' onClick='return valida_exc()'><img src='imagens/excluir.png' width='18' height='18' border='0'></a>";
	
		        echo "</td>
		            </tr>";
		    }
		?>
    </tbody>
</table>
<div id="mascara"></div>
<?php
    require_once ('recepcao_rodape.php');
?>
