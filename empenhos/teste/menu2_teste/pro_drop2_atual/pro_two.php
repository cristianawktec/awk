<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml2/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title> Ebombeiro</title>
<style type="text/css">


.preload2 {background: url(prodrop2/button4.gif);}
.menu2 {padding:0 0 0 0px; margin:0; list-style:none; height:40px; background:#fff url(prodrop2/button1a.gif) repeat-x; position:relative; font-family:arial, verdana, sans-serif; }
.menu2 li.top {display:block; float:left; position:relative;} 
.menu2 li a.top_link {display:block; float:left; height:80px; line-height:33px; color:#bbb; text-decoration:none; font-size:11px; font-weight:bold; padding:0 0 0 12px; cursor:pointer;}
.menu2 li a.top_link span {float:left; display:block; padding:0 24px 0 12px; height:40px;}
.menu2 li a.top_link span.down {float:left; display:block; padding:0 24px 0 12px; height:40px; background:url(prodrop2/down.gif) no-repeat right top;}
.menu2 li a.top_link:hover {color:#fff; background: url(prodrop2/button4.gif) no-repeat;}
.menu2 li a.top_link:hover span {background:url(prodrop2/button4.gif) no-repeat right top;}
.menu2 li a.top_link:hover span.down {background:url(prodrop2/button4a.gif) no-repeat right top;}

.menu2 li:hover > a.top_link {color:#fff; background: url(prodrop2/button4.gif) no-repeat;}
.menu2 li:hover > a.top_link span {background:url(prodrop2/button4.gif) no-repeat right top;}
.menu2 li:hover > a.top_link span.down {background:url(prodrop2/button4a.gif) no-repeat right top;}


.menu2 table {border-collapse:collapse; width:0; height:0; position:absolute; top:0; left:0;}

/* Default link styling */

/* Style the list OR link hover. Depends on which browser is used */

.menu2 a:hover {visibility:visible;}
.menu2 li:hover {position:relative; z-index:200;}

/* keep the 'next' level invisible by placing it off screen. */
.menu2 ul, 
.menu2 :hover ul ul, 
.menu2 :hover ul :hover ul ul,
.menu2 :hover ul :hover ul :hover ul ul,
.menu2 :hover ul :hover ul :hover ul :hover ul ul {position:absolute; left:-9999px; top:-9999px; width:0; height:0; margin:0; padding:0; list-style:none;}

.menu2 :hover ul.sub {left:2px; top:40px; background: #fff; padding:3px 0; border:1px solid #4ab; white-space:nowrap; width:135px; height:auto;}
<!-- width modifica o tamanho do quadrado referente aos submenus mas só um nível -->
.menu2 :hover ul.sub li {display:block; height:20px; position:relative; float:left; width:135px;}
.menu2 :hover ul.sub li a {display:block; font-size:11px; height:20px; width:90px; line-height:20px; text-indent:5px; color:#000; text-decoration:none; border:3px solid #fff; border-width:0 0 0 3px;}
.menu2 :hover ul.sub li a.fly {background:#fff url(prodrop2/arrow.gif) 100px 7px no-repeat;}
.menu2 :hover ul.sub li a:hover {background:#4ab; color:#fff; width:129px;}
.menu2 :hover ul.sub li a.fly:hover {background:#4ab url(prodrop2/arrow_over.gif) 80px 7px no-repeat; color:#fff;}
.menu2 :hover ul li:hover > a.fly {background:#4ab url(prodrop2/arrow_over.gif) 80px 7px no-repeat; color:#fff;} 

.menu2 :hover ul :hover ul,
.menu2 :hover ul :hover ul :hover ul,
.menu2 :hover ul :hover ul :hover ul :hover ul,
.menu2 :hover ul :hover ul :hover ul :hover ul :hover ul
{left:90px; top:-4px; background: #fff; padding:3px 0; border:1px solid #4ab; white-space:nowrap; width:135px; z-index:200; height:auto;}
</style>
</head>

<?
	$menu['Geral']['P&aacute;gina inicial'] = '';
	$menu['Geral']['Cadastros']['Logradouros'] = '';
	$menu['Geral']['Cadastros']['Praias'] = '';
	$menu['Geral']['Cadastros']['Efetivos'] = '';
	$menu['Geral']['Cadastros']['Equipamentos'] = '';
	$menu['Geral']['Cadastros']['Materiais'] = '';
	$menu['Geral']['Cadastros']['Unidade operacional'] = '';
	$menu['Geral']['Per&iacute;cia']['Per&iacute;cia n&atilde;o realizada'] = '';
	$menu['Geral']['Sair'] = '';
	$menu['Ocorr&ecirc;ncias']['Atendimento'] = '';
	$menu['Ocorr&ecirc;ncias']['Pendentes'] = '';
	$menu['Ocorr&ecirc;ncias']['Pendentes']['Inc&ecirc;ndio']= '';
	$menu['Ocorr&ecirc;ncias']['Pendentes']['Busca e salvamento']= '';
	$menu['Ocorr&ecirc;ncias']['Pendentes']['APH']= '';
	$menu['Ocorr&ecirc;ncias']['Pendentes']['Produto perigoso']= '';
	$menu['Ocorr&ecirc;ncias']['Pendentes']['Atividade comunit&aacute;ria']= '';
	$menu['Ocorr&ecirc;ncias']['Pendentes']['Ve&iacute;culos envolvidos']= '';
	$menu['Ocorr&ecirc;ncias']['Pendentes']['Recursos materiais']= '';
	$menu['Ocorr&ecirc;ncias']['Em andamento']= '';
	$menu['Ocorr&ecirc;ncias']['Finalizadas']= '';
	$menu['Ocorr&ecirc;ncias']['Ocorr&ecirc;ncia de praia']= '';
	$menu['Atividade t&eacute;cnica']['Geral']= '';
	$menu['Guarni&ccedil;&atilde;o']['Escala']= '';
	$menu['Ajuda']['Cadastros']= '';
	//echo "<pre>"; print_r($menu); echo "</pre>";

?>

<body>
<center>
<img src="barrasigat.jpg">
</center>
<table align="center" width="780" border="0">

	<? /***/ ?>
	<tr>
		<td>
			<ul class="menu2">
				<? if ($menu) foreach ($menu as $menu1 => $arr) if (!$arr) { ?> 
						<li class="top"><a href="" id="home" class="top_link"><span><?=$menu1?></span></a></li>
					<? } else { ?>
					<li class="top"><a href="" id="home" class="top_link"><span class="down"><?=$menu1?></span></a>
						<ul class="sub">
							<? if ($arr) foreach ($arr as $menu2 => $arr2) if (!$arr2) { ?>
								<li><a href=""><?=$menu2?></a></li>
							<? } else { ?>
								<li><a href="" class="fly"><?=$menu2?></a>
										<ul>
											<? if ($arr2) foreach ($arr2 as $menu3 => $valor) { ?>
												<li><a href=""><?=$menu3?></a></li>
											<? } ?>
										</ul>
								</li>
							<? } ?>
						</ul>
					</li>
				<? } ?>
			</ul>
		</td>
	</tr>
    <tr>
	<? /***/ ?>

<? /*** / ?>

        <td>


<span class="preload2"></span>

<ul class="menu2">
	<li class="top"><a href="http://www.cssplay.co.uk" id="home" class="top_link"><span class="down">Geral</span></a>
		<ul class="sub">
			<li><a href="../mozilla/">Atendimento</a></li>
		</ul>
	</li>

	<li class="top"><a href="http://www.cssplay.co.uk" id="products" class="top_link"><span class="down">Ocorr&ecirc;ncias</span><!--[if gte IE 7]><!--></a><!--<![endif]-->
		<!--[if lte IE 6]><table><tr><td><![endif]-->
		<ul class="sub">
			<li>
				<a href="../mozilla/">Atendimento</a>
			</li>
			<li>
				<a href="../menu/" class="fly">Pendentes<!--[if gte IE 7]><!--></a>
				<!--<![endif]-->
					<!--[if lte IE 6]><table><tr><td><![endif]-->
					<ul>
						<li><a href="../mozilla/">Inc&ecirc;ndio</a></li>
						<li><a href="../ie/">Busca e salvamento</a></li>
						<li><a href="../opacity/">APH</a></li>
						<li><a href="../opacity/">Produto perigoso</a></li>
						<li><a href="../opacity/">Ativ.Comunit&aacute;ria</a></li>
						<li><a href="../opacity/">Ve&iacute;culos Enviados</a></li>
						<li><a href="../opacity/">Recursos Materiais</a></li>
					</ul>
					<!--[if lte IE 6]></td></tr></table></a><![endif]-->
			</li>
			<li><a href="../mozilla/">Em Andamento</a></li>
			<li><a href="../mozilla/">Finalizadas</a></li>
			<li><a href="../mozilla/">Ocorr&ecirc;ncia de Praia</a></li>
			
		</ul>
		<!--[if lte IE 6]></td></tr></table></a><![endif]-->
	</li>
	<li class="top"><a href="http://www.cssplay.co.uk" id="services" class="top_link"><span class="down">Cadastros</span><!--[if gte IE 7]><!--></a><!--<![endif]-->
		<!--[if lte IE 6]><table><tr><td><![endif]-->
		<ul class="sub">
			<li><a href="../menu/">Logradouros</a></li>
			<li><a href="../layouts/">Praias</a></li>
			<li><a href="../boxes/">Viaturas</a></li>
			<li><a href="../mozilla/">Efetivos</a></li>
			<li><a href="../mozilla/">Materiais</a></li>
			<li><a href="../mozilla/">Unidade Operacional</a></li>
		</ul>
		<!--[if lte IE 6]></td></tr></table></a><![endif]-->
	</li>
	<li class="top"><a href="http://www.cssplay.co.uk" id="contacts" class="top_link"><span class="down">Atividade T&eacute;cnica</span><!--[if gte IE 7]><!--></a><!--<![endif]-->
		<!--[if lte IE 6]><table><tr><td><![endif]-->
		<ul class="sub">
			<li><a href="../layouts/">Geral</a></li>
			
				
		</ul>
		<!--[if lte IE 6]></td></tr></table></a><![endif]-->
	</li>
	<li class="top"><a href="http://www.cssplay.co.uk" id="shop" class="top_link"><span class="down">Per&iacute;cia T&eacute;cnica</span><!--[if gte IE 7]><!--></a><!--<![endif]-->
		<!--[if lte IE 6]><table><tr><td><![endif]-->
		<ul class="sub">
			<li><a href="../ie/">Per&iacute;cia n&atilde;o realizada</a></li>
			
		</ul>
		<!--[if lte IE 6]></td></tr></table></a><![endif]-->
	</li>
	<li class="top"><a href="http://www.cssplay.co.uk" id="privacy" class="top_link"><span class="down">Guarni&ccedil;&atilde;o</span></a>
		<ul class="sub">
			<li><a href="../ie/">Escala</a></li>
			
		</ul>


	</li>
	<li class="top"><a href="http://www.cssplay.co.uk" id="privacy" class="top_link"><span class="down">Relat&oacute;rios</span></a></li>
	<li class="top"><a href="http://www.cssplay.co.uk" id="privacy" class="top_link"><span class="down">Ajuda</span></a></li>

</ul>



        </td>

<? /***/ ?>

    </tr>
</table>

</body>
</html>
