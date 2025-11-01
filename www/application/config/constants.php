<?php

defined('BASEPATH') or exit('No direct script access allowed');

defined('SHOW_DEBUG_BACKTRACE') or define('SHOW_DEBUG_BACKTRACE', TRUE);
defined('FILE_READ_MODE') or define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') or define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE') or define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE') or define('DIR_WRITE_MODE', 0755);
defined('FOPEN_READ') or define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE') or define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE') or define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb');
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE') or define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b');
defined('FOPEN_WRITE_CREATE') or define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE') or define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT') or define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT') or define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');
defined('EXIT_SUCCESS') or define('EXIT_SUCCESS', 0);
defined('EXIT_ERROR') or define('EXIT_ERROR', 1);
defined('EXIT_CONFIG') or define('EXIT_CONFIG', 3);
defined('EXIT_UNKNOWN_FILE') or define('EXIT_UNKNOWN_FILE', 4);
defined('EXIT_UNKNOWN_CLASS') or define('EXIT_UNKNOWN_CLASS', 5);
defined('EXIT_UNKNOWN_METHOD') or define('EXIT_UNKNOWN_METHOD', 6);
defined('EXIT_USER_INPUT') or define('EXIT_USER_INPUT', 7);
defined('EXIT_DATABASE') or define('EXIT_DATABASE', 8);
defined('EXIT__AUTO_MIN') or define('EXIT__AUTO_MIN', 9);
defined('EXIT__AUTO_MAX') or define('EXIT__AUTO_MAX', 125);

/**
 * Configurações iniciais do app. 
 */
define('CONF_IN_APP_TIME', 'America/Sao_Paulo');
define('CONF_IN_APP_HOST', filter_input(INPUT_SERVER, 'HTTP_HOST'));
define('CONF_IN_APP_BASE', 'http://' . CONF_IN_APP_HOST);

/*
 * Configurações iniciais do banco de dados.
 */
define('CONF_DB_APP_TYPE', 'mysql');
define('CONF_DB_APP_DRIVER', 'pdo');
define('CONF_DB_APP_HOST', 'db');
define('CONF_DB_APP_USER', 'root');
define('CONF_DB_APP_PASSWORD', 'root');
define('CONF_DB_APP_NAME', 'business-control');
define('CONF_DB_APP_DSN', CONF_DB_APP_TYPE . ':host=' . CONF_DB_APP_HOST . ';dbname=' . CONF_DB_APP_NAME);

/*
 * Configurações das mensagens do sistema.
 */
define('CONF_MESSAGE_LOGIN', ['type' => 'success', 'message' => '<strong>Sucesso!</strong> Você eftuou o login com sucesso, seja bem-vindo!']);
define('CONF_MESSAGE_LOGOUT', ['type' => 'success', 'message' => '<strong>Sucesso!</strong> Você efetuou o logout com sucesso, obrigado por usar o Business Control!']);
define('CONF_MESSAGE_VALIDATION', '<strong>Atenção!</strong> Ocorreram erros na validação dos campos.');
define('CONF_MESSAGE_UNLOGGED', ['type' => 'warning', 'message' => '<strong>Atenção!</strong> Ação não permitida. Você tentou acessar uma área restrita sem estar logado.']);
define('CONF_MESSAGE_UNAUTHORIZED', ['type' => 'warning', 'message' => '<strong>Atenção!</strong> Ação não permitida. Você não possui nível de acesso para esta tela.']);
define('CONF_MESSAGE_FIRST_ACCESS', ['type' => 'info', 'message' => '<strong>Informação!</strong> Como é seu primeiro acesso, você deve primeiramente cadastrar uma nova senha para você.']);
define('CONF_MESSAGE_INSERT_SUCCESS', ['type' => 'success', 'message' => '<strong>Sucesso!</strong> O registro foi cadastrado no sistema.']);
define('CONF_MESSAGE_INSERT_ERROR', ['type' => 'warning', 'message' => '<strong>Atenção!</strong> Ocorreu um erro ao cadastrar o registro, tente novamente. Caso o erro persista, contate o administrador do sistema.']);
define('CONF_MESSAGE_DUPLICATED_ERROR', ['type' => 'warning', 'message' => '<strong>Atenção!</strong> Este registro já está cadastrado e não pode ser inserido novamente.']);
define('CONF_MESSAGE_UPDATE_SUCCESS', ['type' => 'success', 'message' => '<strong>Sucesso!</strong> O registro foi atualizado no sistema.']);
define('CONF_MESSAGE_UPDATE_ERROR', ['type' => 'danger', 'message' => '<strong>Erro!</strong> Ocorreu um erro ao atualizar o registro, tente novamente. Caso o erro persista, contate o administrador do sistema.']);
define('CONF_MESSAGE_UPDATE_INVALID', ['type' => 'warning', 'message' => '<strong>Atenção!</strong> Você está tentando atualizar um registro que não existe no sistema.']);
define('CONF_MESSAGE_DELETE_SUCCESS', ['type' => 'success', 'message' => '<strong>Sucesso!</strong> O registro foi deletado do sistema.']);
define('CONF_MESSAGE_DELETE_ERROR', ['type' => 'danger', 'message' => '<strong>Erro!</strong> Ocorreu um erro ao deletar o registro, tente novamente. Caso o erro persista, contate o administrador do sistema.']);
define('CONF_MESSAGE_DELETE_EMPTY', ['type' => 'warning', 'message' => '<strong>Atenção!</strong> Você deve primeiramente informar o código do registro que está tentando deletar.']);
define('CONF_MESSAGE_DELETE_INVALID', ['type' => 'warning', 'message' => '<strong>Atenção!</strong> Você está tentando deletar um registro que não existe no sistema.']);
define('CONF_MESSAGE_DATE_INVALID', 'Data/hora informada é inválida.');
define('CONF_MESSAGE_DATE_INVALID_COMPARE', 'Data/hora final deve ser maior do que a data/hora inicial.');
