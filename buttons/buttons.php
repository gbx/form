<?php 

use Kirby\Form\Field\Buttons;

// direct access protection
if(!defined('KIRBY')) die('Direct access is not allowed');

/**
 * Kirby Form Buttons
 *
 * A default set of available format buttons for 
 * textareas. You can overwrite this or add new buttons in your
 * own config or custom buttons file.  
 * 
 * @package   Kirby Form
 * @author    Bastian Allgeier <bastian@getkirby.com>
 * @link      http://getkirby.com
 * @copyright Bastian Allgeier
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */

buttons::add(array(
  'h1'     => '<button data-type="tag" data-tag-open="# ">' . l::get('form.buttons.h1', 'h1') . '</button>',
  'h2'     => '<button data-type="tag" data-tag-open="## ">' . l::get('form.buttons.h2', 'h2') . '</button>',
  'h3'     => '<button data-type="tag" data-tag-open="### ">' . l::get('form.buttons.h3', 'h3') . '</button>',
  'bold'   => '<button data-type="tag" data-tag-open="**" data-tag-close="**" data-tag-sample="' . l::get('form.buttons.bold.sample', 'bold text') . '">' . l::get('form.buttons.bold', 'bold') . '</button>',
  'italic' => '<button data-type="tag" data-tag-open="*" data-tag-close="*" data-tag-sample="' . l::get('form.buttons.italic.sample', 'italic text') . '">' . l::get('form.buttons.italic', 'italic') . '</button>',
));