<?php

namespace Kirby\Form\Field;

use Kirby\Toolkit\Form;
use Kirby\Form\Field;

/**
 * Radio button field
 * 
 * @package   Kirby Form
 * @author    Bastian Allgeier <bastian@getkirby.com>
 * @link      http://getkirby.com
 * @copyright Bastian Allgeier
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
class Radio extends Field {

  public function label() {
    return '<label class="' . $this->selector('label') . '">' . $this->attributes['label'] . $this->hint() . '</label>';    
  }

}


