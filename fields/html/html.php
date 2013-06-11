<?php 

namespace Kirby\Form\Field;

use Kirby\Toolkit\Form;
use Kirby\Form\Field;

// direct access protection
if(!defined('KIRBY')) die('Direct access is not allowed');

/**
 * Plain HTML field
 * 
 * @package   Kirby Form
 * @author    Bastian Allgeier <bastian@getkirby.com>
 * @link      http://getkirby.com
 * @copyright Bastian Allgeier
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
class HTML extends Field {

  public function template() {
    return $this->attribute('html');
  }

  public function inner($html) {
    return $html;
  }

}