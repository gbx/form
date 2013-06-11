<?php 

require('../toolkit/bootstrap.php');
require('bootstrap.php');

use Kirby\Form;

$fields = array(
  'fieldset-left' => array(
    'type'   => 'fieldset',
    'fields' => array(
      'username' => array(
        'type'        => 'text', 
        'label'       => 'Username',
        'autofocus'   => true, 
        'placeholder' => 'Your username', 
      ),
      'password' => array(
        'type'        => 'password', 
        'label'       => 'Password',
        'columnClass' => 'three',
      ),
    )
  ),
  'fieldset-right' => array(
    'type'   => 'fieldset',
    'fields' => array(
      'username' => array(
        'type'        => 'text', 
        'label'       => 'Username',
        'autofocus'   => true, 
        'placeholder' => 'Your username', 
      ),
      'password' => array(
        'type'        => 'password', 
        'label'       => 'Password',
        'columnClass' => 'three',
      ),
    )
  ),
  'buttons' => new Kirby\Form\Fieldset\Buttons 
);

$data = r::get(array(
  'username', 
  'password'
));

$errors = array(
  'username', 
  'password'
);

$form = new Form($fields, array(
  'method'   => 'post',
  'data'     => $data,
  'errors'   => $errors,
  'buttons'  => array(
    'cancel' => false, 
    'submit' => 'Done'
  ), 
  'buttons'  => false
));



echo $form;



echo memory();




?>