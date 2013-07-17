<?php 

namespace Kirby\Form\Fieldset;

use Kirby\Toolkit\L;
use Kirby\Form\Fieldset;

// direct access protection
if(!defined('KIRBY')) die('Direct access is not allowed');

/**
 * Form Buttons Fieldset
 * 
 * This extends a normal fieldset to build 
 * a buttonbar for the form with submit and cancel buttons
 * 
 * @package   Kirby Form
 * @author    Bastian Allgeier <bastian@getkirby.com>
 * @link      http://getkirby.com
 * @copyright Bastian Allgeier
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
class Buttons extends Fieldset {

  /**
   * Constructor
   * 
   * @param array $params
   */
  public function __construct($params = array()) {

    $defaults = array(
      'cancel' => l::get('form.buttons.cancel', 'Cancel'),
      'submit' => l::get('form.buttons.submit', 'Submit'),
    );

    $options = array_merge($defaults, $params);
    $fields  = array();
        
    // add the submit button
    if($options['submit']) $fields[] = \Kirby\Toolkit\Form::button(false, $options['submit'], array('class' => 'form-button is-submit'));

    // add the cancel button
    if($options['cancel']) $fields[] = \Kirby\Toolkit\Form::button('__cancel', $options['cancel'], array('class' => 'form-button is-reset'));

    parent::__construct($fields, array(
      'class' => 'form-fieldset is-buttonbar'
    ));

  }

}