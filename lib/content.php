<?php 

namespace Kirby\Form;

use Kirby\Toolkit\A;
use Kirby\Toolkit\L;
use Kirby\Form;

/**
 * Form Content
 * 
 * Takes a field setup array and converts
 * it to proper field/fieldset/columns objects first and 
 * html afterwards. 
 * 
 * @package   Kirby Form
 * @author    Bastian Allgeier <bastian@getkirby.com>
 * @link      http://getkirby.com
 * @copyright Bastian Allgeier
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
class Content {

  // holds the setup array
  protected $fields = array();
  
  // the parent form object
  protected $form = null;
  
  /**
   * Constructor
   * 
   * @param array $fields
   * @param array $form
   */
  public function __construct($fields, Form $form) {
    $this->fields = $fields;
    $this->form   = $form;
  }

  /**
   * Returns an array with all fields objects
   * 
   * @param array
   */
  public function fields() {
    
    $fields = array();

    // loop through all fields, which should be added to the content
    foreach($this->fields as $name => $field) {

      // for simple field setup arrays
      // we need to build proper Field/Fieldset/Columns objects first
      if(is_array($field)) {

        switch($field['type']) {
          case 'fieldset':
          case 'columns':
            
            // build a new fieldset or columns class
            $class  = 'Kirby\\Form\\' . $field['type'];
            
            // recursively create a new Content object to make sure 
            // that all child fields are converted to proper objects as well
            $object = new Content($field['fields'], $this->form);
            
            // apply the global class selector coming from the form
            if(!isset($field['class'])) {
              $field['class'] = $this->form->options['class'] . '-' . strtolower($field['type']);
            }

            // add the fields array of the recursive content object and
            // return the html of the fieldset/columns object
            $fields[] = new $class($object->fields(), $field);
            break;
          default:
            
            // build a new field class
            $class = 'Kirby\\Form\\Field\\' . $field['type'];
            
            // add the name to the field
            $field['name'] = $name;            

            // add the data value to the field and pass the default value if exists
            $field['value'] = (string)a::get($this->form->data(), $name, @$field['default']);

            // add the error if exists
            $field['error'] = in_array($name, $this->form->errors());

            // add the global form class to the field
            $field['class'] = $this->form->options['class'] . '-field';

            // check for an existing class and add it to the fields array
            if(class_exists($class)) $fields[] = new $class($field);
            break;            
        }

      } else if(is_object($field) && method_exists($field, 'html')) {
        // if this is a proper field/fieldset/columns object, we can simply
        // add the html of it to the fields array. No conversion needed
        $fields[] = $field->html();        
      }

    }

    return $fields;

  }

  /**
   * Returns the generated html
   * 
   * @param string
   */
  public function html() {
    return implode('', $this->fields());
  }

  /**
   * Echos the entire form
   * 
   * @return string
   */
  public function __toString() {  
    return $this->html();
  }

}