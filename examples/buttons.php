<?php 

/**
 * Formatting buttons for textareas
 */
require('../../toolkit/bootstrap.php');
require('../bootstrap.php');

$fields = array(
  'text' => array(
    'label'   => 'Your text',
    'type'    => 'textarea', 
    'buttons' => true,
  ) 
);

$form = new Kirby\Form($fields, array(
  'buttons' => array(
    'submit' => 'Save'
  )
));

echo $form;