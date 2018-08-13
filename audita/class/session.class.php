<?php
/**
 * classe session
 * Gerencia uma se��o com o usu�rio
 */
class session{
    /**
     * m�todo construtor
     * inicializa uma se��o
     */
    function __construct(){
        session_start();
    }

    /**
     * m�todo setLogin()
     * Armazena uma vari�vel na se��o
     * @param  $username   = login do usuario
     * @param  $password   = senha do usu�rio
     */
    function setLogin($username, $password){
		
		//Zera a variavel de sess�o
		$_SESSION = array();

        $sql = sprintf("SELECT id_usuario, nm_usuario, id_perfil, id_unidade, nm_perfil, nm_unidade FROM vw_usuarios WHERE ps_senha = '%s' AND nm_login = '%s'", trim(md5($password)), trim($username));
        //echo "<br>sql usuario:<br>".$sql;
		//inicia a conex�o
        $c = connection::init();
		//executa a query
        $c->query($sql);
        
		//pega o numero de registro
        $n = $c->num_rows();
		//echo $n;
        if($n > 0){
			//pega o registro
			$tupla = $c->fetch_row();
			session::setValue($tupla);
			return true;

		}else{

			//Limpa a sess�o
			//self::freeSession();
			return false;

		}

		connection::close();

    }


    /**
     * m�todo setEmpenho()
     * @param  $fornecededor_cnpj   	= cnpj fornecedor
     * @param  $fornecededor_empenho   	= empenho do fornecedor
     */
    function setEmpenho($fornecededor_cnpj, $fornecededor_empenho){

		//Zera a variavel de sess�o
		$_SESSION = array();


        $sql = sprintf("SELECT a.id_fornecedor, a.nm_fornecedor, a.ds_cnpj, b.id_empenho, b.ds_empenho, c.id_unidade, c.nm_unidade
						FROM fornecedores AS a JOIN empenhos AS b USING (id_fornecedor)
						JOIN unidades_beneficiadas AS c USING (id_unidade)
						WHERE a.ds_cnpj = '%s' AND b.ds_empenho = '%s'", trim($fornecededor_cnpj), trim(strtoupper($fornecededor_empenho)));

        //echo "<br>sql fornecedor:<br>".$sql;
        //inicia a conex�o
        $c = connection::init();
        //executa a query
        $c->query($sql);
        //pega o numero de registro
        $n = $c->num_rows();
		//echo "NUMERO: ".$n;
        if($n > 0){
			//pega o registro
			$tupla = $c->fetch_row();
			session::setValue($tupla);
			return true;

		}else{

			//Limpa a sess�o
			//self::freeSession();
			return false;

		}

		connection::close();

    }


    /**
     * m�todo setFornecedor()
     * @param  $fornecededor_cnpj   	= cnpj fornecedor
     * @param  $fornecededor_password   	= senha do fornecedor
     */
    function setFornecedor($fornecededor_cnpj, $fornecededor_password){

		//Zera a variavel de sess�o
		$_SESSION = array();


        $sql = sprintf("SELECT id_fornecedor, nm_fornecedor, ds_cnpj FROM fornecedores
						WHERE ds_cnpj = '%s' AND ps_senha = '%s'", trim($fornecededor_cnpj), trim($fornecededor_password));

// $sql = "SELECT id_fornecedor, nm_fornecedor, ds_cnpj, ps_senha
// FROM fornecedores
// WHERE ds_cnpj = '08.732.540/0001-71' 
// AND ps_senha ='teste'";
//         echo "<br>sql fornecedor:<br>".$sql;
        //inicia a conex�o
        $c = connection::init();
        //executa a query
        $c->query($sql);
        //pega o numero de registro
        $n = $c->num_rows();
		//echo "NUMERO: ".$n;
        if($n > 0){
			//pega o registro
			$tupla = $c->fetch_row();
			session::setValue($tupla);
			return true;

		}else{

			//Limpa a sess�o
			//self::freeSession();
			return false;

		}

		connection::close();

    }



    /**
     * m�todo setValue()
     * Armazena uma vari�vel na se��o
     * @param  $arrayValues   = array com o Nome da vari�vel e seus valores
     */
    function setValue($arrayValues){
        foreach($arrayValues AS $var => $value){
            //echo "$var => $value<br>";
			$_SESSION[$var] = $value;
		}
    }

    /**
     * m�todo getValue()
     * Retorna uma vari�vel da se��o
     * @param  $var   = Nome da vari�vel
     */
    function getValue($var){
		if(array_key_exists($var, $_SESSION)){
			return $_SESSION[$var];
		}
    }

    /**
     * m�todo freeSession()
     * Destr�i os dados de uma se��o
     */
    function freeSession(){
        $_SESSION = array();
        session_destroy();
    }
}
?>
