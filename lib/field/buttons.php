<?php

namespace Kirby\Form\Field;

use Kirby\Toolkit\F;
use Kirby\Toolkit\L;

// direct access protection
if(!defined('KIRBY')) die('Direct access is not allowed');

/**
 * Form Field Buttons
 * 
 * The Buttons class generates a list of formatting
 * buttons to simplify entering Markdown or in textareas
 * 
 * @package   Kirby Form
 * @author    Bastian Allgeier <bastian@getkirby.com>
 * @link      http://getkirby.com
 * @copyright Bastian Allgeier
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
class Buttons {

  // a list of all installed buttons
  static protected $installed = array();

  // a list of options for the buttonbar
  protected $options = array();

  // the final array of html lines
  protected $html = array();

  /**
   * Constructor
   * 
   * @param array $active A list of keys of active buttons, which should be rendered
   * @param $array $params A list of optional settings for the buttonbar 
   */
  public function __construct($active = array(), $params = array()) {

    $defaults = array(
      'class' => 'form-field-input-buttons',
      'id'    => false,
      'label' => l::get('form.buttons.label', 'Text buttons'),
    );

    // extend the default options
    $this->options = array_merge($defaults, $params);

    // load all available buttons
    $available = $this->load();
     
    if(is_array($active)) {
      foreach($active as $b) {
        $buttons[] = a::get($available, $b);
      }
    } else {
      $buttons = $available;
    }
    
    $attr = array(
      'role'  => 'navigation',
      'class' => $this->options['class'], 
      'id'    => $this->options['id']
    );  

    $this->html[] = '<nav ' . attr($attr) . '>';
    $this->html[] = '<h1 class="is-hidden">' . $this->options['label'] . '</h1>';
    $this->html[] = '<ul>';    

    foreach($buttons as $button) $this->html[] = '<li>' . $button . '</li>';    

    $this->html[] = '</ul>';    
    $this->html[] = '</nav>';    
    
    $this->html = implode(PHP_EOL, $this->html);

  }

  /**
   * Add new buttons
   * 
   * @param mixed $key Either a single key or an array of keys and buttons
   * @param string $value The button html
   * @return array Return all installed buttons
   */
  static public function add($key, $value = null) {
    if(is_array($key)) {
      foreach($key as $k => $v) self::add($k, $v);
      return true;
    }
    self::$installed[$key] = $value;
  }

  /**
   * Remove buttons by key
   * 
   * @param mixed Either a single key or an array of keys
   * @return array   
   */
  static public function remove($key) {
    if(is_array($key)) {
      foreach($key as $k) static::remove($k);
      return;
    }
    unset(static::$installed[$key]);
    return static::$installed;
  }

  /**
   * Resort all installed buttons by key
   * 
   * @param array $keys   
   * @return array
   */
  static public function sort($keys) {

    $original = static::$installed;
    $result   = array();

    foreach($keys as $key) {
      if(isset($original[$key])) {
        $result[$key] = $original[$key];
      }
    }

    return static::$installed = $result;

  }

  /**
   * Load all available buttons
   * 
   * @return array
   */
  protected function load() {

    // load the default buttons
    f::load(KIRBY_FORM_ROOT_DEFAULT_BUTTONS . DS . 'buttons.php');

    // load custom buttons from users
    f::load(KIRBY_FORM_ROOT_CUSTOM_BUTTONS . DS . 'buttons.php');

    return self::$installed;

  }

  /**
   * Makes it possible to simply echo the class to get the button html
   * 
   * @return string
   */
  public function __toString() {
    return $this->html;
  }

}