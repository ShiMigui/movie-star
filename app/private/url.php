<?php
const __PRIVATE = __DIR__ . '/';

session_start();

//Singleton.php
require_once __PRIVATE . 'manager/Database.php';
//gen_token.php
//User.php
//DAO.php
require_once __PRIVATE . 'entity/UserDAO.php';
require_once __PRIVATE . 'manager/Alert.php';
//Cache.php
require_once __PRIVATE . 'manager/Auth.php';

$userDAO = userDAO::getInstance();
$login = Auth::isLogged();