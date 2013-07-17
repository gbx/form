<?php 

namespace Kirby\Form;

use Kirby\Toolkit\A;
use Kirby\Toolkit\Str;
use Kirby\Form\Field\Buttons;

// direct access protection
if(!defined('KIRBY')) die('Direct access is not allowed');

/**
 * Form Field
 * 
 * This is the base class for all form field classes
 * 
 * @package   Kirby Form
 * @author    Bastian Allgeier <bastian@getkirby.com>
 * @link      http://getkirby.com
 * @copyright Bastian Allgeier
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
class Field {

  // all attributes for this field
  protected $attributes = array();
  
  // cache for the root directory of the field class
  protected $root = null;

  /**
   * Constructor
   * 
   * @param array $attributes Add all attributes for the field with this array. Check out $this->defaults() for available attributes
   */
  public function __construct($attributes = array()) {
    $this->attributes = array_merge($this->defaults(), $attributes);
  
    // overwrite the hint if an error is available
    if(!empty($this->attributes['error'])) {
      $this->attributes['hint'] = $this->attributes['error'];
    }

  }

  /**
   * Returns an array with default values for the attributes array
   * Overwrite this in your extended field class to offer different defaults
   * 
   * @return array
   */
  public function defaults() {
    return array(
      'element'     => 'div',
      'label'       => null,
      'id'          => null,
      'name'        => null,
      'default'     => null,
      'size'        => null,
      'buttons'     => null,
      'hint'        => null,
      'help'        => null,
      'error'       => null,
      'autofocus'   => null,
      'class'       => 'form-field',
      'required'    => null,
      'focus'       => null,
      'placeholder' => null, 
      'value'       => null,
      'default'     => null,
      'options'     => array()
    );        
  }

  /**
   * Returns the field type
   * The class must be named accordingly to make this work. 
   * Otherwise you have to overwrite it and return the type yourself.
   * 
   * @return string
   */
  public function type() {
    return str_replace('kirby\\form\\field\\', '', strtolower(get_called_class()));
  }

  /**
   * Returns the name of the field
   * 
   * @return string
   */
  public function name() {
    return $this->attributes['name'];
  }

  /**
   * Returns the id of the field. If not specified this will be generated with the name and -field 
   * 
   * @return string
   */
  public function id() {
    return $this->attribute('id', $this->name() . '-field');
  }

  /**
   * Returns the value, that should be shown in the input 
   * 
   * @param mixed $default Optional default value, which should be returned if no value is available
   * @return string
   */
  public function value($default = null) {
    return $this->attribute('value', $default);
  }

  /**
   * Makes sure to return the value(s) as array
   * 
   * @param mixed $default Optional default values, which should be returned if no values are available
   * @return array
   */
  public function values($default = null) {
    return (array)$this->attribute('value', $default);
  }
 
  /**
   * Builds the full label with all bells and whistles. 
   * 
   * @return string
   */
  public function label() {
    if(empty($this->attributes['label'])) return false;
    return '<label class="' . $this->selector('label') . '" for="' . $this->id() . '">' . $this->attributes['label'] . $this->hint() . '</label>';
  }

  /**
   * Adds a small hint to the label. 
   * This is useful for things like input type hints on errors
   * 
   * @return string
   */
  public function hint() {
    return ($hint = $this->attributes['hint']) ? '<small class="' . $this->selector('hint') . '">' . $hint . '</small>' : null; 
  }

  /**
   * Builds a help text underneath the input
   * 
   * @return string
   */
  public function help() {
    return (!empty($this->attributes['help'])) ? '<div class="' . $this->selector('help') . '">' . $this->attributes['help'] . '</div>' : false;
  }

  /**
   * Checks if there's an error for this field
   * 
   * @return boolean
   */
  public function error() {
    return $this->attributes['error'];
  }

  /**
   * Checks if this field is required
   * 
   * @return boolean
   */
  public function required() {
    return $this->attributes['required'];
  }

  /**
   * Returns an optional size value for the field
   * This is not used for a size attribute, but for a class selector
   * 
   * @return string
   */
  public function size() {
    return $this->attributes['size'];
  }

  /**
   * Returns input buttons for the input
   * 
   * @return object Kirby\Form\Buttons
   */
  public function buttons() {
    if($buttons = $this->attribute('buttons')) {
      return new Buttons($buttons, array('class' => $this->selector('buttons')));
    }
  }

  /**
   * Checks if the autofocus attribute should be added
   * 
   * @return boolean
   */
  public function autofocus() {
    return $this->attributes['autofocus'];
  }

  /**
   * Returns optional placeholder text for the input
   * 
   * @return string
   */
  public function placeholder() {
    return $this->attributes['placeholder'];
  }

  /**
   * Returns an optional array of options. i.e. for select boxes or multiple checkboxes
   * 
   * @return array
   */
  public function options() {
    return $this->attributes['options'];
  }

  /**
   * Returns a particular attribute from the attributes array
   * 
   * @param mixed $key An optional key. If no key is given, the entire array will be returned
   * @param mixed $default An optional default value if the attribute could not be found
   * @return mixed Whatever is stored for that key
   */
  public function attribute($key = null, $default = null) {
    return a::get($this->attributes, $key, $default);
  }

  /**
   * Returns an array with all attributes that should be added to the input
   *
   * @param array $attr An optional array of attributes that should be merged 
   * @return array
   */
  public function attr($attr = array()) {
    return array_merge(array(
      'id'          => $this->id(),
      'class'       => $this->selector('input'),
      'placeholder' => $this->placeholder(),
      'autofocus'   => $this->autofocus(),
    ), $attr);    
  }

  /**
   * An onSubmit handler that can be used by the extended field class
   * to manipulate the results for this field after the form has been submitted
   * This is useful if you have to inputs, which you need to join in a single field for example. 
   * 
   * @param mixed $value The original value for this field
   * @param array $data The entire data array
   * @return Return the new value for this field
   */
  public function onSubmit($value, $data) {
    return $value;
  }

  /**
   * Loads the template file for this field. 
   * In most extended field classes it will be easier to overwrite
   * this and return some simple form:: class stuff. But if you 
   * need more complex templates you can add a {type}.html.php file to your
   * field root, which will then be loaded automatically via this method. 
   * 
   * @return string The final html for the input
   */
  public function template() {

    $file = $this->root() . DS . $this->type() . '.html.php';

    if(!file_exists($file)) raise('The field template could not be found: ' . $file);

    Kirby\Toolkit\Content::start();  
    require($file);
    return Kirby\Toolkit\Content::stop();      

  }

  /**
   * A css selectors builder for the various places where 
   * a selector is needed for the field and all it's child elements.  
   * 
   * @param string $type The type of selectors you want to get
   * @return string
   */
  public function selector($type = null) {    
    switch($type) {
      case 'label':
        // .form-field-label
        return $this->selector() . '-label';
        break;
      case 'inline-label':
        // .form-field-inline-label
        return $this->selector() . '-inline-label';
        break;
      case 'input':
        // .form-field-input
        return $this->selector() . '-input';        
        break;
      case 'input-list':
        // .form-field-input-list
        return $this->selector() . '-input-list';        
        break;
      case 'outer':
        // .form-field
        $selectors   = array($this->selector());
        if($type     = $this->type())     $selectors[] = 'is-' . $type;
        if($size     = $this->size())     $selectors[] = 'is-' . $size;
        if($required = $this->required()) $selectors[] = 'is-required';
        if($error    = $this->error())    $selectors[] = 'has-error';
        if($buttons  = $this->buttons())  $selectors[] = 'with-buttons';
        return implode(' ', $selectors);
        break;
      case 'inner':
        // .form-field-inner
        return $this->selector() . '-inner';
        break;
      case 'buttons':
        // .form-field-input-buttons
        return $this->selector() . '-input-buttons';
        break;
      case 'help':
        // .form-field-help
        return $this->selector() . '-help';
        break;
      case 'hint':
        // .form-field-label-hint
        return $this->selector() . '-label-hint';
        break;
      default:
        return $this->attributes['class'];
        break;
    }      
  }

  /**
   * The outer html template for the field
   * Overwrite this to create an entirely new wrapper for the field
   * 
   * @param string $html The html for the inner part of the field
   * @return string
   */
  public function outer($html) {
    return '<' . $this->attributes['element'] . ' class="' . $this->selector('outer') . '">' . $html . '</' . $this->attributes['element'] . '>';
  }

  /**
   * The inner html template for the field, which also adds the label and help
   * Overwrite this to create an entirely new inner wrapper for the field
   * 
   * @param string $html The html for the input part of the field
   * @return string
   */
  public function inner($html) {
    return implode('', array(
      $this->label(),
      '<div class="' . $this->selector('inner') . '">' . $html . $this->buttons() . '</div>',
      $this->help()
    ));
  }

  /**
   * Generates the final html for the entire field
   * 
   * @return string
   */
  public function html() {
    return $this->outer($this->inner($this->template()));
  }

  /**
   * Returns the root directory for this field
   * 
   * @return string
   */
  public function root() {
    if(!is_null($this->root)) return $this->root;
    
    $default = KIRBY_FORM_ROOT_DEFAULT_FIELDS . DS . $this->type();
    $custom  = KIRBY_FORM_ROOT_CUSTOM_FIELDS  . DS . $this->type();

    return $this->root = (is_dir($custom)) ? $custom : $default;
  
  }

  /**
   * Converts this object to a string, which 
   * contains the entire html for the field
   * 
   * @return string
   */
  public function __toString() {
    return $this->html();
  }

}