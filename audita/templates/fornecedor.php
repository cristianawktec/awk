<?php
?>
<form target="_self" enctype="multipart/form-data" method="post" name="frm_fornecedor" id="frm_fornecedor" onsubmit="" onreset="" action="./modulos/fornecedor/lista_empenho.php?>">
<input type="text" value="./index.php?acesso=<?php echo $_GET['acesso']?>">
<fieldset class="login">
<br>
<table>
<?php if($erro_sessao){?><tr class="erro"><th colspan="2" style="text-align:center;"><?php echo $erro_sessao?></th></tr><?php }?>
<tr>
	<th>CNPJ:</th>
	<td><input type="text" name="fornecededor_cnpj" id="fornecededor_cnpj" value="" onblur="cpfcnpj(this)">&nbsp;&nbsp;(Somente Numeros)</td>
</tr>
<tr>
	<th>SENHA:</th>
	<td><input type="password" name="fornecededor_password" id="fornecededor_password" value="" ></td>
</tr>
</table>
<p><input type="submit" name="btn_login" id="btn_login" class="botao" Value="OK">&nbsp;<input type="reset" name="btn_limpar" class="botao" Value="Limpar"></p>
<hr>
<p><a href="fornpass.php?e=1">Quero gerar uma nova senha</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="fornpass.php?e=2">Esqueci minha senha</a></p>
</fieldset>
</form>
