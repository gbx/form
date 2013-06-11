<?php 

namespace Kirby\Form;

// direct access protection
if(!defined('KIRBY')) die('Direct access is not allowed');

/**
 * Form Fieldset
 * 
 * This class builds a fieldset with any
 * number of contained fields or columns
 * 
 * @package   Kirby Form
 * @author    Bastian Allgeier <bastian@getkirby.com>
 * @link      http://getkirby.com
 * @copyright Bastian Allgeier
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
class Fieldset {

  // a list of all fields for the fieldset
  protected $fields = array();

  // a list of all applicable attributes
  protected $attributes = array();

  /**
   * Constructor
   * 
   * @param array $fields An array with field objects
   * @param array $attributes An optional array of additional attributes for the fieldset
   */
  public function __construct($fields, $attributes = array()) {

    // all available options for fieldsets
    $defaults = array(
      'legend' => null,
      'id'     => null,
      'class'  => 'form-fieldset',
    );

    $this->attributes = array_merge($defaults, $attributes);
    $this->fields     = $fields;

  }

  /**
   * Generates the head tag for the fieldset with all its attributes
   * 
   * @return string
   */
  public function start() {

    // create a list of applicable attributes
    $attr = array(
      'id'    => $this->attributes['id'], 
      'class' => $this->attributes['class'], 
    );

    // start the fieldset and add all attributes
    return '<fieldset ' . attr($attr) . '>';

  }

  /**
   * Generates the legend for the fieldset if available
   * 
   * @return string
   */
  public function legend() {
    return ($legend = $this->attributes['legend']) ? '<legend>' . html($legend) . '</legend>' : null;
  }

  /**
   * Generates the end tag for the fieldset
   * 
   * @return string
   */
  public function end() {
    return '</fieldset>'; 
  }

  /**
   * Generates the entire HTML for the fieldset
   * 
   * @return string
   */
  public function html() {

    $html = array();

    // start the fieldset and add all attributes
    $html[] = $this->start();

    // add the fieldset legend
    if($legend = $this->legend()) $html[] = $legend;
      
    // add each field
    foreach($this->fields as $field) {
      $html[] = is_string($field) ? $field : $field->html();
    } 

    // end the fieldset
    $html[] = $this->end();

    return implode('', $html);   

  }

  /**
   * Makes it possible to simply echo the fieldset object 
   * and get the html for the fieldset that way. 
   */
  public function __toString() {
    return $this->html();
  }

}