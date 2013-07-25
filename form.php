<?php

namespace Kirby;

use Kirby\Toolkit\A;
use Kirby\Toolkit\Errors;
use Kirby\Toolkit\L;
use Kirby\Toolkit\R;
use Kirby\Toolkit\S;
use Kirby\Form\Content;
use Kirby\Form\Fieldset\Buttons;
use Kirby\Form\Notice;

// direct access protection
if(!defined('KIRBY')) die('Direct access is not allowed');

/**
 * Extended Form Class
 * 
 * @package   Kirby Form
 * @author    Bastian Allgeier <bastian@getkirby.com>
 * @link      http://getkirby.com
 * @copyright Bastian Allgeier
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
class Form extends \Kirby\Toolkit\Form {

  // holds the entire field definition
  public $fields = array();

  // holds all options for the form
  public $options = array();

  // holds all default data for the form
  protected $data = array();
  
  // holds all field names with errors
  protected $errors = array();
    
  /**
   * Constructor
   * 
   * @param array $content
   * @param array $params
   */
  public function __construct($fields = array(), $params = array()) {
    
    // if there's only a single object passed as fields, 
    // make sure to wrap it in an array to make everything else work smoothly.
    if(is_object($fields)) $fields = array($fields);

    $this->fields  = $fields;
    $this->options = array_merge($this->defaults(), $params);
    $this->data    = array_merge((array)$this->options['data'], r::get());
    $this->errors  = new Errors;
    
  }

  /**
   * Returns all default options for the object
   * 
   * @return array
   */
  public function defaults() {
    return array(
      'id'      => null,
      'action'  => null,
      'method'  => 'POST',
      'upload'  => false,
      'class'   => 'form',
      'attr'    => array(),
      'data'    => array(),
      'buttons' => array(),
      'notice'  => false,
      'csfr'    => true, 
      'on'      => array(
        'submit' => function() {},
        'cancel' => function() {}
      )
    );
  }

  /**
   * Returns all passed form errors
   * 
   * @return array
   */
  public function errors() {
    return $this->errors;
  }

  /**
   * Returns a specific error for a certain field
   * 
   * @param string $code The name of the field
   * @return string
   */
  public function error($code = null) {
    return is_null($code) ? $this->errors->first() : $this->errors->get($code);
  }

  /**
   * Raise an error for a certain field
   * 
   * @param string $message
   * @param string $code
   */
  public function raise($message, $code = null) {
    $this->errors()->raise($message, $code);      
  }

  /**
   * Returns the entire data array
   * 
   * @return array
   */
  public function data($key = null, $default = null) {

    // always remove the csfr token first
    unset($this->data['csfr']);

    if(is_null($key)) return $this->data;    
    // return an array of keys
    if(is_array($key)) {        
      $cleaned = array();
      // only add wanted elements to the cleaned array
      foreach($key as $k) $cleaned[$k] = @$this->data[$k];
      return $cleaned;
    }
    
    return a::get($this->data, $key, $default);
  
  }

  /**
   * Returns the notice object
   * 
   * @param  array $params
   * @return object Kirby\Form\Notice
   */
  public function notice($params = array()) {      
    $options = array_merge(array(
      'type'    => 'error',
      'message' => l::get('form.notice.error', 'Something went wrong'),
      'attr'    => array()
    ), (array)$params);
    return ($params === false) ? false : new Notice($options['type'], $options['message'], $options['attr']);
  }

  /**
   * Shortcut to set an error notice for the form
   * 
   * @param string $message
   */
  public function alert($message, $attr = array()) {
    $this->options['notice'] = array(
      'type'    => 'error', 
      'message' => $message,
      'attr'    => $attr
    );
  }

  /**
   * Shortcut to set a success notice for the form
   * 
   * @param string $message
   */
  public function notify($message, $attr = array()) {
    $this->options['notice'] = array(
      'type'    => 'success', 
      'message' => $message, 
      'attr'    => $attr
    );
  }

  /**
   * Returns the content object for the form
   * 
   * @return object Kirby\Form\Content
   */
  public function content() {

    // check if everything needs to be wrapped with a fieldset
    // you can avoid this by wrapping everything in fieldsets yourself
    if($first = a::first($this->fields)) {
      if(is_array($first) && $first['type'] != 'fieldset') {
        $this->fields = array(
          'fieldset' => array(
            'type'   => 'fieldset',
            'fields' => $this->fields
          )
        );
      }
    }

    // create the content object, which will take care of converting 
    // the array with field setups to proper field/fieldset/columns objects
    return new Content($this->fields, $this);

  }

  /**
   * Return the buttons object for the form's button bar
   * 
   * @param  array $params
   * @return Kirby\Form\Buttons
   */
  public function buttons($params = array()) {
    return ($params === false) ? false : new Buttons($params);
  }

  /**
   * Converts the entire form object to HTML
   * 
   * @return string
   */
  public function html() {

    // trigger attached events before the html is generated
    $this->events();    

    // make sure the class name is attached to the attr array
    $this->options['attr'] = array_merge($this->options['attr'], array(
      'id'    => $this->options['id'],
      'class' => $this->options['class']
    ));

    return implode('', array(
        $this->start(
        $this->options['action'], 
        $this->options['method'], 
        $this->options['upload'], 
        $this->options['attr']
      ),
      $this->notice($this->options['notice']),
      $this->content(),
      $this->buttons($this->options['buttons']),
      ($this->options['csfr']) ? $this->csfr() : false,
      $this->end()
    ));

  }

  /**
   * Registers a form event
   * Allowed events: submit and cancel
   * 
   * @param string $type 'submit' or 'cancel'
   * @param closure $event The event method
   */
  public function on($type, $event) {
    if(!in_array($type, array('submit', 'cancel'))) raise('Invalid event: ' . $type);
    $this->options['on'][$type] = $event;
  }

  /**
   * Trigger an attached event
   * 
   * @param string $type
   */
  public function trigger($type) {
    if(!in_array($type, array('submit', 'cancel'))) raise('Invalid event: ' . $type);

    // call the event
    if(is_callable($this->options['on'][$type])) {      
      return $this->options['on'][$type]($this);
    }

  }

  /**
   * Event handler for the attached submit and cancel events
   * 
   */
  protected function events() {

    // check for a valid submission
    if(r::method() == $this->options['method'] and !empty($this->data)) {

      // check for a valid csfr token
      if($this->options['csfr'] and !csfr($this->data['csfr'])) return false; 
    
      // get the right event, which should be triggered
      $event = (isset($this->data['__cancel'])) ? 'cancel' : 'submit';

      // trigger the appropriate event
      $this->trigger($event);

    }

  }

  /**
   * Makes it possible to echo the entire object and get the full html
   * 
   * @return string
   */
  public function __toString() {    
    return (string)$this->html();
  }

}