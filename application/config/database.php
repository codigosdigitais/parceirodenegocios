<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');


/*
$active_group = $_SERVER['HTTP_HOST'] == 'server02:8081' ? 'localhost' : 'default';
$ip           = ip2long($_SERVER['SERVER_ADDR']);
$ipHigh       = ip2long('192.168.0.255');
$ipLow        = ip2long('192.168.0.0');
$local        = array(
    '127.0.0.1',
    '::1'
);

if (($ip <= $ipHigh && $ipLow <= $ip) || in_array($_SERVER['SERVER_ADDR'], $local)) {
    $active_group = 'localhost';
} else {
    $active_group = 'default';
}

# Define
$active_record               = TRUE;
*/

$active_group = 'default';

# Online
$db['default']['hostname']   = 'localhost';
$db['default']['username']   = 'parceiro_site1';
$db['default']['password']   = 'p4Rc3Ir055';
$db['default']['database']   = 'parceiro_site';
$db['default']['dbdriver']   = 'mysqli';
$db['default']['dbprefix']   = '';
$db['default']['pconnect']   = TRUE;
$db['default']['db_debug']   = FALSE;
$db['default']['cache_on']   = FALSE;
$db['default']['cachedir']   = '';
$db['default']['char_set']   = 'utf8';
$db['default']['dbcollat']   = 'utf8_general_ci';
$db['default']['swap_pre']   = '';
$db['default']['autoinit']   = TRUE;
$db['default']['stricton']   = FALSE;

# Local Host
$db['localhost']['hostname'] = 'localhost';
$db['localhost']['username'] = 'root';
$db['localhost']['password'] = '';
$db['localhost']['database'] = 'sistemajc';
$db['localhost']['dbdriver'] = 'mysql';
$db['localhost']['dbprefix'] = '';
$db['localhost']['pconnect'] = TRUE;
$db['localhost']['db_debug'] = FALSE;
$db['localhost']['cache_on'] = FALSE;
$db['localhost']['cachedir'] = '';
$db['localhost']['char_set'] = 'utf8';
$db['localhost']['dbcollat'] = 'utf8_general_ci';
$db['localhost']['swap_pre'] = '';
$db['localhost']['autoinit'] = TRUE;
$db['localhost']['stricton'] = FALSE;



