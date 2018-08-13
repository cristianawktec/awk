<?php

/**
 * Corpo de Bombeiros Militar de Santa Catarina
 *
 * Projeto COBOM Sistema de Gerenciamento de Atividades Tecnicas
 *
 * @categoria  Class
 * @pacote     ClassSessaoCobom
 * @autor      Edson Orivaldo Lessa Junior <edsonagem@cb.sc.gov.br>
 * @creditos   Agem Informatica
 * @versao     1.0
 * @data       11/07/2005 as 14:30:05
 * @atualiza   19/11/2005 as 22:41:50
 * @arquivo    lib/class/class_sessao_cobom.php
 */

 /**
  * Variaveis utilizadas:
  * $this->err_msg_ses - Armazena a mensagem de um erro que encerrou um metodo
  */

class sessao {

	/*
	 *  INICIO DA SESS�O
	 */
    function __construct() {
        // Instancia o objeto de acesso ao BD
        $this->bd = new BD (BD_HOST, BD_USER, BD_PASS, BD_NOME);

        // Para o sistema caso o banco nao esteja disponivel
        if (!$this->bd->check_server()) {
            bra_send_msg ("Erro ao conectar com o banco de dados.\n\n".$this->bd->get_msg());
           $this->err_msg_ses= "Erro ao conectar com o banco de dados.\n\n".$this->bd->get_msg();
           http_redir (PAGINA_BD_NAO_DISPONIVEL);
        }

        // Para o sistema caso esteja como em manutencao
        if (SISTEMA_EM_MANUTENCAO)
            http_redir (PAGINA_EM_MANUTENCAO);

        if (CONF_REQUIRE_SSL)
            if (!isset($_SERVER['HTTPS']))
                encerra (MSG_SSL_REQUIRED);

        // A sessao ainda nao foi iniciada
        $this->started = false;
    }

    public function started() {
        return $this->started;
    }

    /*
     *  Retorna o Login
     */

    function is_logged_in () {
        if (isset ($_SESSION[CONF_SESS_UID])) {
            return  $_SESSION[CONF_SESS_UID];
        }
        return false;
    }

    /*
     *  Retorna a matricula
     */

    function is_mtr_in () {
        if (isset ($_SESSION[CONF_SESS_MTR])) {
            return  $_SESSION[CONF_SESS_MTR];
        }
        return false;
    }

    /*
     * Retorna o perfil
     */

    function is_perfiled_in () {
        if (isset ($_SESSION[CONF_SESS_PER])) {
            return  $_SESSION[CONF_SESS_PER];
        }
        return false;
    }


	/*
	 * Retorna o nome do usuario
	 */

    function is_user_in () {
        if (isset ($_SESSION[CONF_SESS_USER])) {
            return  $_SESSION[CONF_SESS_USER];
        }
        return false;
    }

    /*
     * Retorna mensagem de erro
     */

    function get_erro() {
      if (@$this->err_msg_ses!="") {
        return $this->err_msg_ses;
      } else {
        return "";
      }
    }

	/*
	 * Verifica as permiss�es do usu�rio
	 */

    function perm_login ($strperfil,$strrotina) {
        global $global_consulta;
        global $global_inclusao;
        global $global_alteracao;
        global $global_exclusao;
        $sql = "SELECT ch_consultar,ch_inserir,ch_alterar,ch_excluir FROM ".TBL_PERFILAMENTO." WHERE id_rotina = '$strrotina' AND id_perfil='$strperfil'";
        echo $sql; exit;
        if ($this->bd->query($sql)) {
            if ($this->bd->num_rows()>0) {
                $reg=$this->bd->fetch_row();
                $global_consulta  =$reg["ch_consultar"];
                $global_inclusao  =$reg["ch_inserir"];
                $global_alteracao =$reg["ch_alterar"];
                $global_exclusao  =$reg["ch_excluir"];
                if ($global_consulta=="N") {
                  $this->err_msg_ses="Usuario sem acesso a Consulta";
                  return false;
                } else { return true; }
            } else {
              $this->err_msg_ses="Usuario sem acesso a Consulta";
              return false;
            }
        } else {
          $this->err_msg_ses="Usuario sem acesso a Consulta";
          return false;
        }
        return false;
    }

	/*
	 * Verifica se o usuario existe
	 */

    function get_id_by_login($str_login,$str_pass) {
        $str_login = $this->bd->escape_string ($str_login);
        $sql = "SELECT id_mtr_usuario, nm_login, id_perfil, nm_usuario  FROM ".TBL_USUARIO." WHERE nm_login = '$str_login'";
       //echo $sql; exit;

        if ($this->bd->query($sql)) {

            if ($this->bd->num_rows()) {
                return $this->bd->fetch_row();
            } else {
              $this->err_msg_ses= "USU�RIO N�O ENCONTRADO NA BASE DO CBMSC";
            }
        }
        return false;
    }


	/*
	 * Fun��o que inicia a sess�o
	 */

    function start(){
        if ($this->started())
            return true;

        // Salva o indicador de estado
        $this->started = true;

        // Configura a sessao e a inicia
        return session_start (); // Inicia a sessao OK
    }

    /*
     *  Carrega as rotinas
     */
    function load ($load_rotina=0) {
        global $global_obj_ctrl_usuarios;
        global $global_obj_ctrl_eventos;

        // Verifica se ha chance de haver uma sessao
        if (!$this->tem_cookie_sessao())
            encerra(MSG_ERR_NOT_LOGGED_IN);

        // O SESSION_ID parece valido, vamos iniciar a sessao
        $this->start();

        // Se o usuario fez login carrega o objeto de usuario atual
        $sessao_usr=$this->is_logged_in();
        $sessao_per=$this->is_perfiled_in();
        if ($sessao_usr) {
            // Carrega o objeto do usuario atual
            $this->obj_usuario = $sessao_usr;
            if (!$this->obj_usuario) {
              encerra (MSG_ERR_INTERNAL);
              return false;
            }
//             if ($load_rotina!=0) {
//               if (!$this->perm_login($sessao_per,$load_rotina)) {
//                 $global_obj_ctrl_eventos->reg_evento (MSG_USER_AUTH_ERR_DISABLED_USER, EVENT_INFO, $userlogin, null);
//                 http_redir (PAGINA_CONS);
//                 return false;
//               }
//            }

            return true;
        }
        else {
            /**
             * Logout por sessao expirada:
       * Presume-se que uma sessao valida expirou qunado o usuario tenta
             * fazer acesso com um identificador de sess�o que tinha formato
             * valido mas nao existe mais no servidor. Neste caso, remove
             * o cookie de sessao e redireciona a tela de login.
             */
            //$this->logout();
            http_redir (PAGINA_SESS_EXPIROU);
            return false;
        }

        /**
         * Verificar se tem permissao para pagina atual,
         * caso o parametro tenha sido informado.
         */
        if ($script_id != null) {
            echo $script_id;
        }

    }

    function tem_cookie_sessao() {
      return true;
    }

    /*
     *  Fecha a sess�o
     */
    function logout () {
        global $global_obj_ctrl_eventos;
                if ($this->start()) {
                    if ($this->load()) {
                        // Registra o logout do usuario
                        $global_obj_ctrl_eventos->reg_evento (MSG_USER_LOGGED_OUT, EVENT_INFO, $this->obj_usuario, null);


                    }
        // Encerra a sessao
                    session_destroy();
                    session_unset();
                    return true;
                }
        return false;

        if ($this->tem_cookie_sessao()) {
            if (!$this->started()) {
                if ($this->start()) {
                    if ($this->load()) {
                        // Registra o logout
                        $global_obj_ctrl_eventos->reg_evento (MSG_USER_LOGGED_OUT, EVENT_INFO, $this->obj_usuario, null);

                    }
        // Encerra a sessao
                    session_destroy();
                    session_unset();
                    cookie_delete (CONF_SESSION_NAME); // Exclui
                    return true;
                }
            }$this->bd->fetch_row();
            cookie_delete (CONF_SESSION_NAME); // Exclui
            return true;
        }
        return true;

    }

    function authenticate($userlogin, $passwd, $rotina) {//echo "<br>".$userlogin."<br>".$passwd."<br>".$rotina;
	  // passando a rotina para 5 ainda nao implementado para dlf;
	  $rotina="5";
        global $global_obj_ctrl_eventos;
        global $global_obj_ctrl_usuarios;
        $userlogin = $userlogin;
        if (!strlen($userlogin)) {
           $global_obj_ctrl_eventos->reg_evento(MSG_USER_AUTH_ERR_BLANK_LOGIN, EVescape_stringENT_INFO, null, null);
            return false;
        }

        // Tenta carregar o usuario a autenticar
        $id = $this->get_id_by_login ($userlogin, $passwd);
        // Aborta se o login nao existe. Registra no LOG
        if (!is_array($id)) {
          $global_obj_ctrl_eventos->reg_evento(MSG_USER_AUTH_ERR_NO_LOGIN, EVENT_WARN, null, $userlogin);
          return false;
        }

        // Carrega o usuario do ID obtido
        $obj_usuario = $id[CONF_SESS_UID];
        $obj_matricula= $id[CONF_SESS_MTR];
        $obj_perfil = $id[CONF_SESS_PER];
        $obj_nome = $id[CONF_SESS_USER];

        // Aborta se o ID nao for valido (em principio nao e possivel ser invalido)
       if ((!$obj_usuario)||(!$obj_perfil) || (!$obj_matricula)) {
            return false;
        }

        // Verifica se o usuario tem permissao de acesso
//        if (!$this->perm_login($obj_perfil,$rotina)) {
//           if ($rotina!=5) {
//             $global_obj_ctrl_eventos->reg_evento (MSG_USER_AUTH_ERR_DISABLED_USER, EVENT_INFO, $userlogin, null);
//             $this->err_msg_ses= "USU�RIO SEM ACESSO A PAGINA SOLICITADA";
//           }
//           return false;
//         }

        // O usu�rio e valido e tem permissao. Inicia a sessao
        $this->start();

        // Salva um cookie com o login do usuario
        //$this->set_cookie_last_login($userlogin);

        // Registra o usuario autenticado na sessao
        $_SESSION[CONF_SESS_UID] = $obj_usuario;
        $_SESSION[CONF_SESS_MTR] = $obj_matricula;
        $_SESSION[CONF_SESS_PER] = $obj_perfil;
        $_SESSION[CONF_SESS_USER] = $obj_nome;

        // Registra o login no log de eventos
        $global_obj_ctrl_eventos->reg_evento (MSG_USER_LOGGED_IN, EVENT_INFO, $obj_usuario, null);

        // Retorna TRUE na operacao de login
        return true;
    }
}

?>
