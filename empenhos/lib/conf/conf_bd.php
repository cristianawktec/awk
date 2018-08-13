<?php
/**
 * Configuracoes do Banco de Dados
 */
    //define ('BD_HOST'  						,'10.193.255.1');
    define ('BD_HOST'  						,'empenhos.postgresql.dbaas.com.br');
    define ('BD_USER'  						,'empenhos');
    define ('BD_PASS'  						,'empenhos18');
    define ('BD_PORT'  						,'5432');


/**
 *  Define o Schema (colocar o nome e depois o ponto ex: "fns.")
 */

   define ('SCHEMA'     					, '');

/**
 * Bases do Banco de Dados (9)
 */
    define ('BD_NOME'        				,'empenhos');

/**
 * Numa requisição em que o limite nao e definido,
 * qual deve ser o limite padrao?
 */
    define ('BD_SQL_LIMIT_MAX'				,1000);

/**
 * Acessos
 * Definindo as Constantes da Sessão
 */
    define ('CONF_SESS_UID'                 ,'nm_login');
    define ('CONF_SESS_MTR'                 ,'id_mtr_usuario');
    define ('CONF_SESS_PER'                 ,'id_perfil');
    define ('CONF_SESS_USER'                ,'nm_usuario');

/**
 * Configuracoes das Tabelas
 *
 * Nomes das Tabelas
 *
 */

   /**
    * Tabelas
    */

    define ('TBL_USUARIO',              SCHEMA.'usuarios');
    define ('TBL_PERFIL',               SCHEMA.'perfil');
    define ('TBL_UNIDADE',              SCHEMA.'unidade_operacional');
    define ('TBL_EMPENHO',              SCHEMA.'empenhos');
    define ('TBL_EMP_DEVOLUCAO',        SCHEMA.'empenhos_devolucoes');
    define ('TBL_EMP_RECEBIMENTO',      SCHEMA.'empenhos_recebimentos');
    define ('TBL_BANCOS',               SCHEMA.'bancos');
    define ('TBL_POSTO',                SCHEMA.'posto_graduacao');
    define ('TBL_TIPO_SITUACAO',        SCHEMA.'tp_situacao_empenho');

?>
