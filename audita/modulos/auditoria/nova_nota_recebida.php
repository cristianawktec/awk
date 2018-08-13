<?php
/*
 * carrega a classe a ser instanciada quando chamada
 */
function __autoload($classe){
	$pontos = array("./", "../", "../../");
    foreach($pontos AS $ponto){
		if(file_exists("{$ponto}class/{$classe}.class.php")){
			//echo "{$ponto}class/{$classe}.class.php\n";
			include_once "{$ponto}class/{$classe}.class.php";
		}
	}
}
//echo "<pre>"; print_r($_GET); echo "</pre>"; //exit;
$requisicao = null;
$conn = connection::init();

//echo $_POST['id_empenho']." - ".$_POST['id_requisicao']."<br>";
$conn->query("SELECT a.id_requisicao, a.ds_requisicao, to_char(a.dt_requisicao, 'DD/MM/YYYY') AS dt_requisicao,
			b.id_empenho, b.ds_empenho, b.ds_cnpj_unidade_orcamentaria, c.id_fornecedor, c.nm_fornecedor, c.ds_cnpj, c.ds_email1, c.ds_email2,
			d.id_notafiscal, d.nr_notafiscal, to_char(d.dt_notafiscal, 'DD/MM/YYYY') AS dt_notafiscal, d.vl_notafiscal, e.nm_unidade, d.id_status_nota
			FROM requisicoes AS a JOIN empenhos AS b ON (a.id_empenho=b.id_empenho AND a.id_unidade=b.id_unidade)
			JOIN fornecedores AS c ON (b.id_fornecedor=c.id_fornecedor)
			JOIN notas_fiscais AS d ON (d.id_requisicao=a.id_requisicao AND d.id_fornecedor=b.id_fornecedor)
			JOIN unidades_beneficiadas AS e ON (a.id_unidade=e.id_unidade)
			WHERE a.id_requisicao =".$_GET['id_requisicao']." AND a.id_empenho = ".$_GET['id_empenho']." AND d.nr_notafiscal = ".$_GET['nr_notafiscal']);
$requisicao = $conn->fetch_row();

$itens = null;
$sql = "SELECT DISTINCT d.id_item_contratado, e.nm_produto, a.qt_produto_requisicao, f.nm_unidade_medida,
		d.vl_item_contratado, h.qt_produto_recebido, h.vl_produto_recebido
		FROM items_requisicao AS a
		JOIN requisicoes AS b ON (a.id_requisicao=b.id_requisicao AND a.id_empenho=b.id_empenho)
		JOIN empenhos AS c ON (a.id_empenho=c.id_empenho AND b.id_unidade=c.id_unidade)
		JOIN items_contratados AS d ON (a.id_item_contratado = d.id_item_contratado AND a.id_empenho=d.id_empenho)
		JOIN produtos AS e USING (id_produto)
		JOIN tipo_unidade_medida AS f USING (id_unidade_medida)
		JOIN notas_fiscais AS g ON (g.id_requisicao=b.id_requisicao)
		JOIN items_recebidos AS h ON (g.id_requisicao = h.id_requisicao AND h.id_notafiscal = g.id_notafiscal AND h.id_item_contratado = d.id_item_contratado)
		WHERE b.id_requisicao =".$_GET['id_requisicao']." AND c.id_empenho = ".$_GET['id_empenho']." AND g.nr_notafiscal = ".$_GET['nr_notafiscal'];
//echo "<br>sql: ".$sql; exit;
$conn->query($sql);
$itens = $conn->get_tupla();
//echo "<pre>"; print_r($itens); echo "</pre>"; exit;


connection::close();

$botao_enviar = "Recebimento Nota Fiscal";

?>
<link href="../../css/audita.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../js/prototype.js"></script>
<form target="_self" enctype="multipart/form-data" method="post" name="frm_nota" id="frm_nota" onsubmit="fechar_janela()" onreset="" action="./mail_nota_recebida.php">
<input type="hidden" name="id_usuario" id="id_usuario" value="">
<input type="hidden" name="id_requisicao" id="id_requisicao" value='<?php echo $requisicao['id_requisicao']?>'>
<input type="hidden" name="id_notafiscal" id="id_notafiscal" value='<?php echo $requisicao['id_notafiscal']?>'>
<input type="hidden" name="dados_requisicao" id="dados_requisicao" value='<?php echo formata::encodeJSON($requisicao)?>'>
<input type="hidden" name="dados_itens" id="dados_itens" value='<?php echo formata::encodeJSON($itens)?>'>
<table border="0" width="100%" class="orgTableJanela">
<tr>
	<td>BENEFICI�RIO:</td>
	<td><?php echo $requisicao['nm_unidade']?></td>
</tr>
<tr>
	<td>CNPJ:</td>
	<td><?php echo $requisicao['ds_cnpj']?></td>
</tr>
<tr>
	<td>CNPJ UNID. OR�.:</td>
	<td><?php echo $requisicao['ds_cnpj_unidade_orcamentaria']?></td>
</tr>
<tr>
	<td>FORNECEDOR:</td>
	<td><?php echo $requisicao['nm_fornecedor']?></td>
</tr>
<tr>
	<td width="20%">REQUISI��O:</td>
	<td><?php echo $requisicao['ds_requisicao']?></td>
</tr>
<tr>
	<td width="20%">DATA REQUISI��O:</td>
	<td><?php echo $requisicao['dt_requisicao']?></td>
</tr>
<tr>
	<td>N� NOTA FISCAL:</td>
	<td><?php echo $requisicao['nr_notafiscal']?></td>
</tr>
<tr>
	<td>DATA DA NOTA FISCAL:</td>
	<td><?php echo $requisicao['dt_notafiscal']?></td>
</tr>
</table>
<br>
<table border="0" width="100%" class="orgTable">
<tr class="cab">
    <th width="6%">Item</th>
    <th width="30%">Produto</th>
    <th width="6%">Qt</th>
    <th width="10%">Qt Recebida</th>
    <th>Unidade</th>
    <th width="12%">Valor Unit�rio</th>
    <th width="10%">Valor</th>
</tr>
<?php foreach($itens AS $item){ ?>
<tr class="lin">
    <td class="cen"><?php echo $item['id_item_contratado']?></td>
    <td><?php echo $item['nm_produto']?></td>
    <td class="cen"><?php echo $item['qt_produto_requisicao']?></td>
    <td class="cen"><?php echo $item['qt_produto_recebido']?></td>
    <td><?php echo $item['nm_unidade_medida']?></td>
    <td class="cen"><?php echo str_replace(".", ",", $item['vl_item_contratado'])?></td>
    <td class="cen"><?php echo str_replace(".", ",", $item['vl_produto_recebido'])?></td>
</tr>
<?php } ?>
<tr class="cab">
    <td colspan="8">VALOR TOTAL:&nbsp;&nbsp;&nbsp;<?php echo str_replace(".", ",", $requisicao['vl_notafiscal'])?></td>
</tr>
</table>
<hr>
<?php if($requisicao['id_status_nota'] >= 4){?>
<p class="erro">Aten��o! J� foi dado o recebimento da Nota Fiscal.<br>Se desejar enviar o email para o fornecedor novamente, clique no bot�o <b><i>reenviar o email</i></b>.</p>
<?php
$botao_enviar = "Reenviar Email";
}?>
<p align="center">
    <input type="submit" name="btn_print" id="btn_print" class="botao" Value="<?php echo  $botao_enviar?>">&nbsp;
    <input type="button" name="btn_fechar" class="botao" Value="Fechar" onclick="javascript:fechar_janela()"></p>
</form>
<script type="text/javascript">
function fechar_janela(){
   parent.globalWin.hide();
}
</script>
