<br/><br/><br/><br/><br/>
<fieldset>
<br/>
<form name="frm_login" id="frm_login" method="POST" action="" onreset="location.href='index.php'">
<table border="0" cellspacing="4" cellpadding="4" width="80%" align="center">
	<tr>
		<td align="right" width="45%">LOGIN:&nbsp;</td>
		<td align="left"><input type="text" name="login" id="login" value="" class="required"></td>
	</tr>
	<tr>
		<td align="right">SENHA:&nbsp;</td>
		<td align="left"><input type="password" name="senha" id="senha" value="" class="required"></td>
	</tr>
	<tr><td colspan="2">&nbsp;</td></tr>
	<? if($global_obj_sessao->get_erro()!=""){ ?>
		<tr><td colspan="2" class="erro"><?=$global_obj_sessao->get_erro()?></td></tr>
	<? }else{ ?>
	<tr><td colspan="2">&nbsp;</td></tr>
	<? } ?>
	<tr>
		<td colspan="2" align="center">
			<input type="submit" name="btn_login" value="ENTRAR" class="botao"/>
			<input type="reset" name="btn_reset" value="LIMPAR" class="botao"/>
		</td>
	</tr>
</table>
</form>
<br/>
</fieldset>
<script type="text/javascript">
	var frm = new Validation('frm_login');
	//alert(frm);
</script>
