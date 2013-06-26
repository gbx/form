<?php

namespace Kirby;

use Kirby\Toolkit\A;
use Kirby\Toolkit\L;
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

  // holds all default data for the form
  protected $data = array();
  
  // holds all field names with errors
  protected $errors = array();
  
  // holds the content html from the Content object
  protected $content = null;
  
  // holds all options for the form
  public $options = array();

  /**
   * Constructor
   * 
   * @param array $content
   * @param array $params
   */
  public function __construct($content = array(), $params = array()) {
    
    // if there's only a single object passed as content, 
    // make sure to wrap it in an array to make everything else work smoothly.
    if(is_object($content)) $content = array($content);

    $this->options = array_merge($this->defaults(), $params);
    $this->data    = $this->options['data'];
    $this->errors  = $this->options['errors'];
    
    // check if everything needs to be wrapped with a fieldset
    // you can avoid this by wrapping everything in fieldsets yourself
    if($first = a::first($content)) {
      if(is_array($first) && $first['type'] != 'fieldset') {
        $content = array(
          'fieldset' => array(
            'type'   => 'fieldset',
            'fields' => $content
          )
        );
      }
    }

    // create the content object, which will take care of converting 
    // the array with field setups to proper field/fieldset/columns objects
    $this->content = new Content($content, $this);
  
  }

  /**
   * Returns all default options for the object
   * 
   * @return array
   */
  public function defaults() {
    return array(
      'action'  => null,
      'method'  => 'POST',
      'upload'  => false,
      'class'   => 'form',
      'attr'    => array(),
      'data'    => array(),
      'errors'  => array(),
      'buttons' => array(),
      'notice'  => false,
      'csfr'    => true
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
   * Returns the entire data array
   * 
   * @return array
   */
  public function data() {
    return $this->data;
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
   * Returns the content object for the form
   * 
   * @return object Kirby\Form\Content
   */
  public function content() {
    return $this->content; 
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

    // make sure the class name is attached to the attr array
    $this->options['attr'] = array_merge($this->options['attr'], array('class' => $this->options['class']));

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
   * Makes it possible to echo the entire object and get the full html
   * 
   * @return string
   */
  public function __toString() {
    return $this->html();
  }

}