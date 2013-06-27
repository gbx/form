<?php

$dir = __DIR__;

if(!defined('TEST_ROOT'))     define('TEST_ROOT',     dirname($dir));
if(!defined('TEST_ROOT_ETC')) define('TEST_ROOT_ETC', TEST_ROOT . DIRECTORY_SEPARATOR . 'etc');
if(!defined('TEST_ROOT_LIB')) define('TEST_ROOT_LIB', $dir);
if(!defined('TEST_ROOT_TMP')) define('TEST_ROOT_TMP', TEST_ROOT_ETC . DIRECTORY_SEPARATOR . 'tmp');

// include the Kirby Toolkit
require_once(dirname(dirname(TEST_ROOT)) . DIRECTORY_SEPARATOR . 'toolkit' . DIRECTORY_SEPARATOR . 'bootstrap.php');

// include the Kirby Form bootstrapper file
require_once(dirname(TEST_ROOT) . DIRECTORY_SEPARATOR . 'bootstrap.php');
