/*
 *  Data
 *
 */

    data = new Date();
    dia = data.getDate();
    mes = data.getMonth();
    ano = data.getFullYear();

    meses = new Array(12);

    meses[0] = '01';
    meses[1] = '02';
    meses[2] = '03';
    meses[3] = '04';
    meses[4] = '05';
    meses[5] = '06';
    meses[6] = '07';
    meses[7] = '08';
    meses[8] = '09';
    meses[9] = '10';
    meses[10] = '11';
    meses[11] = '12';

/*
 * Medidas da Janela
 */

//Variavel para janela
var globalWin = "";

var largura = window.innerWidth - ((window.innerWidth / 100) * 20);
var altura = window.innerHeight - ((window.innerHeight / 100) * 20);


/*
 * Validar CEP
 */

function cep(element){
    var value = "";

    value = element.value.replace(/\D/gi, "");
    value = value.replace(/^(\d{5})/, "$1-");
    element.value = value;
}

/*
 * Validar Telefone
 */

function telefone(element){

    var value = "";

    value = element.value.replace(/\D/gi, "");
    value = value.replace(/^(\d{2})/, "($1)");
    value = value.replace(/\b(\d{4})/, "$1-");

    element.value = value;
}

//valida telefone
function validarTelefone(element){
        exp = /\(?\d{2}\)?\d{4}-\d{4}/;
        if(!exp.test(element.value))
                alert('Numero de Telefone Invalido!');
}


/*
 *  Validar CNPJ e CPF
 */

function cpfcnpj(campo) { //alert('functio cpfcnpf arquivo audita.js');

	if (campo.value != "") {

		var smascara= campo.value;

		if(document.layers && parseInt(navigator.appVersion) == 4){

			smascara = campo.value.substring(0,2);
			smascara += campo.value.substring (3,6);
			smascara += campo.value.substring (7,10);
			smascara += campo.value.substring (11,15);
			smascara += campo.value.substring (16,18);

		} else {

			smascara = campo.value.replace(".","");
			smascara = smascara.replace(".","");
			smascara = smascara.replace("-","");
			smascara = smascara.replace("/","");
		}

		if (smascara.length > 11) {
			validaCNPJ(smascara,campo);
		} else {
			validaCPF(smascara,campo);
		}
	}
}

function validaCPF(cpf,campo) { //alert('valida cpf arquivo audita.js');
//  cpf = document.validacao.cpfID.value;
  erro = new String;
  var aux="";
  while ((cpf.indexOf('.')>-1) || (cpf.indexOf('/')>-1) || (cpf.indexOf('-')>-1)) {
    if (cpf.indexOf('.')>-1) {
      aux=cpf.replace('.','');
      cpf=aux;
    }
    if (cpf.indexOf('/')>-1) {
      aux=cpf.replace('/','');
      cpf=aux;
    }
    if (cpf.indexOf('-')>-1) {
      aux=cpf.replace('-','');
      cpf=aux;
    }
  }
  if (cpf.length < 11) erro += "Sao necessarios 11 digitos para verificacao do CPF! ";
  var nonNumbers = /\D/;
  if (nonNumbers.test(cpf)) erro += "A verificacao de CPF suporta apenas numeros! ";
  if (cpf == "00000000000" || cpf == "11111111111" || cpf == "22222222222" || cpf == "33333333333" || cpf == "44444444444" || cpf == "55555555555" || cpf == "66666666666" || cpf == "77777777777" || cpf == "88888888888" || cpf == "99999999999"){
    erro += "Numero de CPF invalido!"
  }
  var a = [];
  var b = new Number;
  var c = 11;
  for (i=0; i<11; i++){
    a[i] = cpf.charAt(i);
    if (i < 9) b += (a[i] * --c);
  }
  if ((x = b % 11) < 2) { a[9] = 0 }
  else { a[9] = 11-x }
  b = 0;
  c = 11;
  for (y=0; y<10; y++) b += (a[y] * c--);
  if ((x = b % 11) < 2) { a[10] = 0; } else { a[10] = 11-x; }
  if ((cpf.charAt(9) != a[9]) || (cpf.charAt(10) != a[10])){
    erro +="Digito verificador com problema!";
  }
  if (erro.length > 0){
    alert(erro);
    campo.value="";
    campo.focus();
    return false;
  }
  campo.value=cpf.substr(0,3)+"."+cpf.substr(3,3)+"."+cpf.substr(6,3)+"-"+cpf.substr(9,2);
  return true;
}


function validaCNPJ(CNPJ,campo) {
  erro = new String;
  if ((CNPJ.charAt(2) == ".") || (CNPJ.charAt(6) == ".") || (CNPJ.charAt(10) == "/") || (CNPJ.charAt(15) == "-")){
  //substituir os caracteres que n�o s�o n�meros
    if(document.layers && parseInt(navigator.appVersion) == 4){
      x = CNPJ.substring(0,2);
      x += CNPJ. substring (3,6);
      x += CNPJ. substring (7,10);
      x += CNPJ. substring (11,15);
      x += CNPJ. substring (16,18);
      CNPJ = x;
    } else {
      CNPJ = CNPJ. replace (".","");
      CNPJ = CNPJ. replace (".","");
      CNPJ = CNPJ. replace ("-","");
      CNPJ = CNPJ. replace ("/","");
    }
    if (CNPJ.length != 14) { erro += "� necess�rio preencher corretamente o n�mero do CNPJ! "; }
  }
  var nonNumbers = /\D/;
  if (nonNumbers.test(CNPJ)) {
    erro += "A verifica��o de CNPJ suporta apenas n�meros! ";
  } else {
    var a = [];
    var b = new Number;
    var c = [6,5,4,3,2,9,8,7,6,5,4,3,2];
    for (i=0; i<12; i++){
      a[i] = CNPJ.charAt(i);
      b += a[i] * c[i+1];
    }
    if ((x = b % 11) < 2) { a[12] = 0 } else { a[12] = 11-x }
    b = 0;
    for (y=0; y<13; y++) {
      b += (a[y] * c[y]);
    }
    if ((x = b % 11) < 2) { a[13] = 0; }
    else { a[13] = 11-x; }
    if ((CNPJ.charAt(12) != a[12]) || (CNPJ.charAt(13) != a[13])){
      erro +="D�gito verificador com problema!";
    }
  }
  if (CNPJ=="00000000000000") { erro=""; }
  if (erro.length > 0){
    alert(erro);
    campo.value="";
    campo.focus();
    return false;
  }
  campo.value=CNPJ.substr(0,2)+"."+CNPJ.substr(2,3)+"."+CNPJ.substr(5,3)+"/"+CNPJ.substr(8,4)+"-"+CNPJ.substr(12,2)
  return true;
}


/*
 *  Verifica a Data
 */

function checadata(campo){
	  if(campo.value.length==2){
	    campo.value=campo.value +"/";
	  }
	  if(campo.value.length==5){
	    campo.value=campo.value +"/";
	  }
	}

function checkDate(campo) {
  if (campo.value=="") {
    return true;
  }
      var datas=campo.value.replace("/","");
      datas = datas.replace("/","");
      campo.value=datas;
      if (campo.value.length==6) {
	campo.value=datas.substr(0,2)+"/"+datas.substr(2,2)+"/20"+datas.substr(4,2);
      } else {
	if (campo.value.length==8) {
	  campo.value=datas.substr(0,2)+"/"+datas.substr(2,2)+"/"+datas.substr(4,4);
	}
      }
  if (campo.value.length<8){
    alert("Data Inv�lida");
    campo.value="";
    campo.focus();
  }
  return false;
}

/*
 *  Retorna a maior data
 */ 
function comparaDataMaior(data_1, data_2){
   
    var returnDataMaior;
    
    var Compara01 = parseInt(data_1.split("/")[2].toString() + data_1.split("/")[1].toString() + data_1.split("/")[0].toString());
    var Compara02 = parseInt(data_2.split("/")[2].toString() + data_2.split("/")[1].toString() + data_2.split("/")[0].toString());

    if (Compara01 >= Compara02) {
        returnDataMaior = 'MAIOR';
    } else {
       returnDataMaior = 'MENOR';
    }
    return returnDataMaior;
}

/*
 * Validar Numeros
 */

function FormatNumero(campo) {
  if (campo.type=='text') {
    var textFormat = "";
    var t=0;
    var str=campo.value;
    var dec= new Array;
    for (var j = 0; j < campo.value.length ; j++) {
      if (campo.value.indexOf(",")>(-1)) {
        dec=campo.value.split(",");
        str=dec[0];
      }
    }
    for (var j = 0; j < str.length ; j++) {
      str=str.replace('.','');
    }
    if (str.length != 0) {
      for (var k = str.length-1; k>=0 ; k--) {
        t++;
        if (t % 3 == 0) {
          textFormat = "." + str.substr(k,1) + textFormat;
        } else {
          textFormat =  str.substr(k,1) + textFormat;
        }
      }
      if (textFormat.substr(0,1) == ".") {
        campo.value = textFormat.substr(1,textFormat.length-1);
      } else {
        campo.value = textFormat;
      }
    }
    if (dec.length>0) {
      campo.value+=","+dec[1];
    }
  }
}

function decimal(campo, precisao){

if (campo.value != ""){
	//Tira todo digito alpha
	campo.value = campo.value.replace(/[A-Z]/gi, "");

	var dec = campo.value.split(",");
	var str = ",";

	if (precisao==0) {
		campo.value=dec[0];
		return true;
	}

	if (dec.length>1) {
		for (var i=0; i < precisao;i++) {
			if(dec[1].substr(i,1) != ""){
				str+=dec[1].substr(i,1);
			}else{
				str+="0";
			}
		}

	}else{
    	for(var i=0;i<precisao;i++){
			str+="0";
		}
	}

	campo.value=dec[0]+str;
	return true;
}
}


function checaNE(campo){

	if(campo.value.length==4){
	    campo.value=campo.value +"NE";
	}

}

function validaNE(campo){
	if(campo.value != ""){
		var valor1=campo.value.substr(0,6);
		var valor2=campo.value.substr(6,6);
		while(valor2.length!='6'){
			valor2='0'+valor2;
		}
		campo.value=valor1+valor2;
	}
}

function validanum(dados,flag){
	//alert('validando o numero');
	  value = dados.value.replace(/[A-Z]/gi, "");
	  value = value.replace(/[\\.-]/gi, "");
	  if(flag!='0'){//alert('incrementa 4');[:punct:]/gi
	    while(value.length!=flag){//alert('4');
	      value='0'+value;
	      //alert(dados.value);
	      //formatNumero(value);
		}
	}
	dados.value = value;
}

/*
// funcao para formatar campo moeda

function formatNumero($valor,$decimais=2) {
    if (($valor=="NULL") || ($valor=="")) {
      return "0,00";
    }
    $vl_format= explode(".",$valor);
    if (count($vl_format)<2) {
      $vl_format[1]="00";
    }
    $NUM=0;
    $OUT="";
    for ($NNN=strlen($vl_format[0]); $NNN>-1; $NNN--) {
      $NN1=substr($vl_format[0],$NNN,1);
      //echo "<!--aqui 0:$valor==>$NN1-->\n";
      if ($NN1!='') {
        $NUM=$NUM+1;
        $OUT=$NN1.$OUT;
        if (($NUM==3) && ($NNN>0)) {
          $OUT='.'.$OUT;
          $NUM=0;
        }
      }
    }
    $vl_format[0]=$OUT;
    if (strlen($vl_format[1])<=$decimais) {
      for ($NNN=strlen($vl_format[1]);$NNN<$decimais;$NNN++) {
        $vl_format[1].="0";
      }
    } else {
      $vl_format[1]= substr($vl_format[1],0,$decimais);
    }
    $valor= implode(",",$vl_format);
    return $valor;
  }
*/

/*
 *  Validar Email
 */

function validaemail(dados){
	  if(dados.value=="" || dados.value.indexOf('@')==-1 || dados.value.indexOf('.')==-1 ){
	    alert( "Preencha campo E-MAIL corretamente!" );
	    dados.focus();
	    dados.value="";
	    return false;
	  }
	}


/*
 *  Validar Banco
 */


function validaBanco(element, f){

		var value = "";

		value = element.value.replace(/\D/gi, "");

		if(value != ""){
			if(value.length != f){
				for(;value.length < f;){
					value = '0'+value;
				}
			}

        }

		element.value = value;

    }


/*
 * Fun��es Uteis
 */
function buscaCep(){
	new Ajax.Request("./templates/cep.php", {
		method: 'POST',
		parameters: 'cep='+$('nr_cep_logradouro').value,
		onLoading: Element.insert($('nr_cep_logradouro').name, {after:"<div id='load_"+$('nr_cep_logradouro').name+"' class='loading'><img src='./imagens/loader.gif' width='14' height='14'/></div>"}),
		onSuccess: function(transport){
					//alert(transport.responseText); exit;
					var xml = transport.responseXML;
			
					if(xml.getElementsByTagName('lib')[0].firstChild.data == 1){

						//$('nr_cep_logradouro').value = xml.getElementsByTagName('nr_cep_logradouro')[0].firstChild.data;
						$('nm_logradouro').value = xml.getElementsByTagName('nm_logradouro')[0].firstChild.data;
						$('nm_bairro').value = xml.getElementsByTagName('nm_bairro')[0].firstChild.data;
						$('nm_cidade').value = xml.getElementsByTagName('nm_cidade')[0].firstChild.data;
						$('id_estado').value = xml.getElementsByTagName('id_estado')[0].firstChild.data;

					}else{
						//$('nr_cep_logradouro').value = "";
						$('nm_logradouro').value = "";
						$('nm_bairro').value = "";
						$('nm_cidade').value = "";
						$('id_estado').value = "";
						
					}
					Element.remove($('load_'+$('nr_cep_logradouro').name));
				}
	});
}




/*
 *  Gera um C�digo randomico
 */
function geraCodigo(element, randomico, varchar){
	//alert($('nr_cep_logradouro'));
	new Ajax.Request("./templates/gera_codigo.php", {
		method: 'POST',
		parameters: { 'random' : randomico, 'varchar' : varchar },
		onSuccess: function(transport){
					//alert(transport.responseText); exit;
					var xml=transport.responseXML;
					element.value = xml.getElementsByTagName('codigo')[0].firstChild.data;

				}
	});
}

/*
 *  Gera um C�digo randomico
 */
function geraSequenciaProduto(element){
	new Ajax.Request("./templates/gera_seq_produto.php", {
		method: 'POST',
		onSuccess: function(transport){
					//alert(transport.responseText); exit;
					var xml=transport.responseXML;
					element.value = xml.getElementsByTagName('codigo')[0].firstChild.data;

				}
	});
}


