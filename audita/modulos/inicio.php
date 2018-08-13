<?php
   //echo "gets: <pre>"; print_r($_GET); echo "</pre>";
	$modulo_arquivo = null;
	$menu = null;
	$arquivo_rotina = null;
	$m = null;

	if(($sessao) && ($sessao_modulo == $_GET['acesso'])) {

		if($sessao_template == 1 && $_GET['acesso'] != 2){

			/**
			 * Busca as rotinas referentes ao modulo e o perfil de acesso
			 */
			$sql = "SELECT a.id_rotina, id_modulos, nm_rotina, nm_fonte, ch_menu, ch_consultar, ch_inserir, ch_alterar, ch_excluir
				FROM rotinas AS a JOIN perfilamentos AS b USING (id_rotina)
				WHERE a.ch_ativacao = 'S' AND id_modulos = {$modulos[$_GET['acesso']]['id_modulos']} AND b.id_perfil = {$sessao_perfil} AND b.ch_consultar = 'S'
				ORDER BY id_rotina";

			//echo "<br>sql: ".$sql;//exit;
			$conn->query($sql);
			$rotinas = $conn->get_tupla();
			//echo "<pre>"; print_r($rotinas); echo "</pre>";
			if($rotinas){

				//$m[] =  "<a href='index.php?acesso={$_GET['acesso']}'>Menu Principal</a>";

				foreach($rotinas AS $rotina){

				/**
				 *  Prepara os links do menu
				 */
					if($rotina['ch_menu'] == 'S'){
						$m[] =  "<a href='index.php?acesso={$_GET['acesso']}&rotina={$rotina['id_rotina']}'>{$rotina['nm_rotina']}</a>";
					}

				/**
				 *  Verifica se existe a rotina
				 */
					if(array_key_exists('rotina', $_GET)){
						if($_GET['rotina'] == $rotina['id_rotina']){
							$modulo_arquivo = $rotina;
						}
					}
				}

			/**
			 *  Finaliza o menu
			 */
				$menu = implode(" ", $m);

			/**
			 * Adiciona o endereco da rotina
			 */
				if($modulo_arquivo){
					$arquivo_rotina = "./modulos/{$modulos[$_GET['acesso']]['nm_diretorio']}/{$modulo_arquivo['nm_fonte']}";
					echo "modulo: ".$arquivo_rotina;
				}

			} else {

				/**
				 * Caso nao tenha a rotina volta pra tela de login e mostra uma mensagem ou erro
				 */
				$arquivo_rotina = retornoLogin($_GET['acesso']);

			}

		}elseif($sessao_template == 2 && $_GET['acesso'] == 2){

			$arquivo_rotina = "./modulos/fornecedor/lista_empenho.php";

		}else{

			$arquivo_rotina = retornoLogin($_GET['acesso']);

		}


	} else {

	/**
	 * Caso sessao nao foi iniciada
	 */
		$arquivo_rotina = retornoLogin($_GET['acesso']);
	}



		/*
		 *  Funcao que retorna a tela de login
	     */
		function retornoLogin($acs){

			if($acs == 0 || $acs == 1 || $acs == 3){
				$arq = "./templates/login.php";
			}elseif($acs == 2){
				$arq = "./templates/fornecedor.php";
			}

			return $arq;

		}


 if($sessao && ($sessao_template == 1)) { ?>
	<p align="center"><?php echo ucwords(formata::fullLower($_SESSION['nm_usuario']))?>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<?php echo ucwords(formata::fullLower($_SESSION['nm_perfil']))?>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<a href="./index.php?acesso=<?php echo $_GET['acesso']?>&logout=1">SAIR</a></p>
	<?php } else { ?> <p></p>&nbsp;&nbsp; <?php } ?>
<fieldset>
<label><b><a href='index.php?acesso=<?php echo $_GET['acesso']?>'><?php echo $modulos[$_GET['acesso']]['nm_modulo']?></a></b></label>
<hr/>
<?php
if(file_exists($arquivo_rotina)){
    if(false){ //$menu?>
        <pre class='menu_tela'><a href='index.php?acesso=<?php echo $_GET['acesso']?>'>Menu Principal</a>&nbsp;&nbsp;<?php echo $menu?></pre><hr>
    <?php } ?>
<?php echo $arquivo_rotina;
    include($arquivo_rotina);
} else {
?>
<table align="center" class="menu_principal">
<?php $c = 0; if($m != "") foreach($m AS $a){
    if($c == 0){
        $t = "<tr><th id='m'>{$a}</th>";
        $c++;
    } else {
        $t = "<th id='m'>{$a}</th></tr>\n";
        $c = 0;
    }
    echo $t;
 } ?>
 <tr><th colspan="2"><hr></th></tr>
 <tr><th colspan="2" id='p'>Selecione o servi&ccedil;o </th></tr>
</table>
<?php } ?>
</fieldset>
