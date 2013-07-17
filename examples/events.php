<?php 

/**
 * On submit and cancel events
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
  ), 
));

// register a submit handler
$form->on('submit', function($form) {

  // handle your login here
  $authenticated = false;

  if($authenticated) {
    go(url::current());
  } else {
    $form->alert('Invalid email/username');
  }

});

// register a cancel handler
$form->on('cancel', function() {
  go(url::current());
});

echo $form;