<?php

defined('BASEPATH') OR exit('No direct script access allowed');

$active_group = 'app';
$query_builder = TRUE;

$db['app'] = array(
    'dsn' => CONF_DB_APP_DSN,
    'hostname' => CONF_DB_APP_HOST,
    'username' => CONF_DB_APP_USER,
    'password' => CONF_DB_APP_PASSWORD,
    'database' => CONF_DB_APP_NAME,
    'dbdriver' => CONF_DB_APP_DRIVER,
    'dbprefix' => '',
    'pconnect' => FALSE,
    'db_debug' => (ENVIRONMENT !== 'production'),
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => 'utf8',
    'dbcollat' => 'utf8_general_ci',
    'swap_pre' => '',
    'encrypt' => FALSE,
    'compress' => FALSE,
    'stricton' => FALSE,
    'failover' => array(),
    'save_queries' => TRUE
);
