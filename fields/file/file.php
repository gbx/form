<?php 

namespace Kirby\Form\Field;

use Kirby\Toolkit\Form;
use Kirby\Form\Field;

// direct access protection
if(!defined('KIRBY')) die('Direct access is not allowed');

/**
 * File Upload Field
 * 
 * @package   Kirby Form
 * @author    Bastian Allgeier <bastian@getkirby.com>
 * @link      http://getkirby.com
 * @copyright Bastian Allgeier
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
class File extends Field {

  public function template() {
    return implode('', array(
      form::file(
        $this->name(), 
        $this->attr()
      ),
      '<span data-text="Click to select a file…">Click to select a file…</span>'
    ));
  }

}