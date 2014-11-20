<?php
/**
 * the use statement is to tell the autoloader which class we want to use since there might be multipale classes with
 * the same name
 * also we can use aliases
 */
use Elibyy\Admin\User as AdminUser;
use Elibyy\General\User;

require_once 'autoload.php';
//if we added use we can use it with short name
$user = new User();
//or we can use it with FQDN
$user = new \Elibyy\General\User();
//example using aliases
$user = new AdminUser();