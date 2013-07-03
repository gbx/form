<?php 

/**
 * Kirby Form Bootstrapper
 * 
 * Include this file to load all essential 
 * files to initiate a new Kirby Form object
 * 
 * @package   Kirby Form
 * @author    Bastian Allgeier <bastian@getkirby.com>
 * @link      http://getkirby.com
 * @copyright Bastian Allgeier
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */

// check for an existing toolkit
if(!defined('KIRBY_TOOLKIT_ROOT')) die('The Kirby Toolkit is required for the Form Builder plugin');

// avoid loading it twice
if(defined('KIRBY_FORM_ROOT')) return;

// define the current location of the form builder plugin
define('KIRBY_FORM_ROOT',     __DIR__);
define('KIRBY_FORM_ROOT_LIB', KIRBY_FORM_ROOT . DS . 'lib');

/**
 * Overwritable constants
 * Define those before including the bootstrapper to set your
 * own locations for buttons and fields
 */
if(!defined('KIRBY_FORM_ROOT_DEFAULT_FIELDS'))  define('KIRBY_FORM_ROOT_DEFAULT_FIELDS',  KIRBY_FORM_ROOT . DS . 'fields');
if(!defined('KIRBY_FORM_ROOT_DEFAULT_BUTTONS')) define('KIRBY_FORM_ROOT_DEFAULT_BUTTONS', KIRBY_FORM_ROOT . DS . 'buttons');

if(!defined('KIRBY_FORM_ROOT_CUSTOM_FIELDS'))   define('KIRBY_FORM_ROOT_CUSTOM_FIELDS',   false);
if(!defined('KIRBY_FORM_ROOT_CUSTOM_BUTTONS'))  define('KIRBY_FORM_ROOT_CUSTOM_BUTTONS',  false);

// initialize the autoloader
$autoloader = new Kirby\Toolkit\Autoloader();

// set the base root where all classes are located
$autoloader->root = KIRBY_FORM_ROOT_LIB;

// set the global namespace for all classes
$autoloader->namespace = 'Kirby\\Form';

// start autoloading
$autoloader->start();

// kill the first one to add a new autoloader
// for all field classes
unset($autloader);

// initialize the autoloader
$autoloader = new Kirby\Toolkit\Autoloader();

// set the base root where all classes are located
$autoloader->root = array(
  KIRBY_FORM_ROOT_CUSTOM_FIELDS,
  KIRBY_FORM_ROOT_DEFAULT_FIELDS,
);

// active loading in separate class folders
$autoloader->classfolder = true;

// set the global namespace for all classes
$autoloader->namespace = 'Kirby\\Form\\Field';

// start autoloading
$autoloader->start();

// load the form class
require_once(KIRBY_FORM_ROOT . DS . 'form.php');