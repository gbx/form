<?php 

namespace Kirby\Form;

// direct access protection
if(!defined('KIRBY')) die('Direct access is not allowed');

/**
 * Form Field Columns
 * 
 * Makes it possible to group form fields in a single
 * row with multiple columns. Simply pass an array of field 
 * objects and set the columns attribute for each field.
 * 
 * @package   Kirby Form
 * @author    Bastian Allgeier <bastian@getkirby.com>
 * @link      http://getkirby.com
 * @copyright Bastian Allgeier
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
class Columns {

  // a list of all fields for the fieldset
  protected $fields = array();

  // a stored count of all fields
  protected $count = 0;

  // a list of all applicable attributes
  protected $attributes = array();

  /**
   * Constructor
   * 
   * @param array $fields An array of field objects, which should be grouped in columns
   * @param array $attribute An optional array of attributes for the columns element
   */
  public function __construct($fields, $attributes = array()) {

    $defaults = array(
      'element' => 'div',
      'class'   => 'columns', 
      'id'      => null,
    );

    $this->attributes = array_merge($defaults, $attributes);
    $this->fields     = $fields;
    $this->count      = count($fields);

    if($this->count > 6) raise('Max. six fields per columns');

  }

  /**
   * Generates the HTML for the entire columns element and
   * all columns including fields. 
   * 
   * @return string
   */
  public function html() {

    $html = array();

    // create a list of applicable attributes
    $attr = array(
      'id'    => $this->attributes['id'], 
      'class' => $this->attributes['class'], 
    );

    // start the fieldset and add all attributes
    $html[] = '<' . $this->attributes['element'] . ' ' . attr($attr) . '>';

    // start counting fields
    $n = 0;

    // add each field
    foreach($this->fields as $class => $field) {
      $n++; $html[] = '<div class="column' . r($field->attribute('columnClass'), ' ' . $field->attribute('columnClass')) . r($n == $this->count, ' last') . '">' . $field->html() . '</div>';
    } 

    // end the fieldset
    $html[] = '</' . $this->attributes['element'] . '>';

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