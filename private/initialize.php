<?php

ob_start(); // turn on output buffering

session_start(); //start an session

define("_PRIVATE", dirname(__FILE__));
define("COMMON", dirname(_PRIVATE));
define("PUBLIC", COMMON . '/public');
define("SHARED", _PRIVATE . '/shared');
define("WWW_ROOT", '/DisasterMgt');




//using require_once to add function.php (due to avoid function redeclare error)
require_once 'function.php';
require_once 'database.php';
require_once 'query_function.php';
require_once 'validate.php';
require_once 'auth.php';

//this is using in every sql query with global scope
$db = db_connect();