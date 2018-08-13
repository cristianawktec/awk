<?php

/**
 * Corpo de Bombeiros Militar de Santa Catarina
 *
 * Projeto Sigat Sistema de Gerenciamento de Atividades Tecnicas
 *
 * @categoria  Miscelania
 * @pacote     FuncoesUteis
 * @autor      Cristian (cristian@awktec.com)
 * @creditos   Awk Informatica
 * @versao     1.0
 * @data       25/04/2005 as 15:25:03
 * @atualiza   17/10/2005 as 09:00:14
 * @arquivo    lib/misc/funcoes_uteis.php
 */

function cookie_delete ($cookie) {
    if (headers_sent())
        return false;
    return header ("Set-Cookie: $cookie=deleted; expires=SIGAT, 01-Jan-00 00:00:00 GMT");
    // return setcookie ($cookie, null, 2592000);
}

function switch_date ($data) {
    if (substr($data,4,1) == '-' && substr($data,7,1) == '-') {
        // Formato: 0000-00-00
        return substr($data,8,2).'/'.substr($data,5,2).'/'.substr($data,0,4);
    }
    if (substr($data,2,1) == '/' && substr($data,5,1) == '/') {
        // Formato: 00/00/0000
        return substr($data,6,4).'-'.substr($data,3,2).'-'.substr($data,0,2);
    }
    echo 'false';
    return false;
}

function get_nice_date_time ($datetime) {
    // Entrada: 0000-00-00 00:00:00
    return switch_date ($datetime) . ' ' . substr ($datetime, 11, 5);
}

function request_method_is_get () {
    return ($_SERVER['REQUEST_METHOD'] == 'GET');
}

function request_method_is_post () {
    return ($_SERVER['REQUEST_METHOD'] == 'POST');
}

function get_param ($indice) {
    // Tenta acessar o valor de GET.
    if (isset($_GET[$indice]))
        $val = $_GET[$indice];

    // Tenta acessar o valor de POST. - prioridade maior
    if (isset($_POST[$indice]))
        $val = $_POST[$indice];

    if (isset($val))
        return $val;
    return false;
}

function print_param ($indice) {
    $val = get_param($indice);
    if ($val)
        echo $val;
}

function http_redir ($destino) {
    // Nao faz nada se o cabecalho HTTP ja foi enviado.
    if (headers_sent())
        return false;

    // Redireciona para a pagina solicitada.
    header ('Location: '.$destino);

    // Para o script para nao mostrar mais nada.
    die ();
}

function get_param_post ($indice) {
    if (isset($_POST[$indice]))
        return $_POST[$indice];
    else
        return false;
}

function isset_param_post ($indice) {
    return isset($_POST[$indice]);
}

function isset_param ($indice) {
    return (isset($_GET[$indice]) || isset($_POST[$indice]));
}

function get_ip_cliente () {
    return $_SERVER['REMOTE_ADDR'];
}

function cliente_usa_proxy () {
    return isset($_SERVER['HTTP_X_FORWARDED_FOR']);
}

function get_ip_interno_cliente () {
    if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    return false;
}

function encerra ($str_msg) {
    die (
"<html>
<head>
<title>..:: Sigat Erro ::..</title>

<style>
.txt {
    font-family: Arial,Helvetica,Sans-serif;
    font-size: 10pt;
    color: #333333;
}

table {
    border: solid;
    border-width: 1pt;
    border-color: #BBBBBB;
    background-color: #EEEEEE;
}

a {
    font-family: Arial,Helvetica,Sans-serif;
    font-size: 10pt;
    color: navy;
}

h2 {
    font-family: Arial,Helvetica,Sans-serif;
    font-size: 14pt;
    font-weight: normal;
    color: navy;
}

body {
    background-color: #DDDDDD;
}
</style>

</head>

<body>
<h2><<< A Execuio foi interrompida!!! >>></h2>

<table border=\"0\" width=\"500\" height=\"100\" cellspacing=\"0\" cellpadding=\"4\">
  <tr>
    <td valign=\"top\">
        <p class=\"txt\"><strong>$str_msg</strong></p>
    </td>
  </tr>
</table>
<p><a href=\"".PAGINA_ROOT."\">Voltar a Pagina Inicial</a></p>
</body>
</html>
");
}

/*
 *  Função que converte array para JSON
 */

    function JSONEncoder($campos){

		$aux = null;
		$auxp = null;

		if(is_array($campos)){

			foreach($campos AS $key => $vle){

				if(is_array($vle)){

					foreach($vle AS $k => $v){
						$auxp[$k] = utf8_encode($v);
					}

					$aux[$key] = $auxp;

				}else{

					$aux[$key] = utf8_encode($vle);

				}

			}

		}

		return json_encode($aux);

	}

?>
