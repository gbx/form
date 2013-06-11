<?php 

namespace Kirby\Form;

use Kirby\Toolkit\HTML;

// direct access protection
if(!defined('KIRBY')) die('Direct access is not allowed');

/**
 * Form Notice
 * 
 * Displays a success or error message at the top of the form
 * 
 * @package   Kirby Form
 * @author    Bastian Allgeier <bastian@getkirby.com>
 * @link      http://getkirby.com
 * @copyright Bastian Allgeier
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
class Notice {

  // the notice type (error or success)
  protected $type = null;

  // the message text
  protected $message = null;

  // all options for the notice
  protected $options = array();

  /**
   * Constructor
   * 
   * @param array $options
   */
  public function __construct($type, $message, $options = array()) {
    $this->type    = $type;
    $this->message = $message;
    $this->options = array_merge($this->defaults(), $options);
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
      'id'          => null,
      'class'       => 'form-notice',
    );        
  }

  /**
   * Returns the type of the notice (success or error)
   * 
   * @return string
   */
  public function type() {
    return $this->type;
  }

  /**
   * Returns the message text
   * 
   * @return string
   */
  public function message() {
    return $this->message;
  }

  /**
   * 
   */
  public function attr() {
    return array(
      'class' => trim($this->options['class'] . ' ' . r($this->type == 'success', 'is-success', 'is-error')),
      'id'    => $this->options['id'],
    );
  }

  /**
   * Generates the html for the notice
   * 
   * @return string
   */
  public function html() {

    $html = array();
    $html[] = html::tag($this->options['element'], $this->message, $this->attr());
    return implode('', $html);
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