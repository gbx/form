<?php 

/**
 * A simple login form
 */

require('../../toolkit/bootstrap.php');
require('../bootstrap.php');

$fields = array(
  'username' => array(
    'label' => 'Username', 
    'type'  => 'text'
  ),
  'password' => array(
    'label' => 'Password',
    'type'  => 'password'
  )
);

$form = new Kirby\Form($fields, array(
  'buttons' => array(
    'submit' => 'Login',
    'cancel' => false
  )
));

echo $form;